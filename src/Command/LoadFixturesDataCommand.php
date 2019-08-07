<?php

namespace App\Command;

use App\Entity\Admin;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LoadFixturesDataCommand extends ContainerAwareCommand
{

    protected static $defaultName = 'fixtures:load';

    protected function configure()
    {
        $this
            ->setDescription('Load fixtures data.')
            ->setHelp('This command load fixtures from "data" directory.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var EntityManager $em */
        $em = $this->getContainer()->get('doctrine')->getEntityManager();

        $tables = [
            'admins',
            'images_has_images_categories',
            'images_categories',
            'images',
            'contents_text_blocks',
            'contents_pages',
            'contents_images',
            'contents',
            'emails_templates',
            'translations'
        ];

        foreach ($tables as $table) {
            $em->getConnection()->executeQuery('delete from ' . $table);
        }

        $loadParts = ['data.yaml'];

        foreach ($loadParts as $loadPart) {
            $loader = new \Nelmio\Alice\Loader\NativeLoader();
            $objectSet = $loader->loadFile(__DIR__ . '/../../data/fixtures/' . $loadPart);
            foreach($objectSet->getObjects() as $object) {
                if ($object instanceof Admin) {
                    $this->cryptPassword($object);
                }
                $em->persist($object);
            }
            $em->flush();
        }

        $output->writeln(date('Y-m-d H:i:s') . ': data loaded');
    }

    private function cryptPassword(Admin $object)
    {
        /** @var EntityManager $dm */
        $dm = $this->getContainer()->get('doctrine')->getManager();
        $uow = $dm->getUnitOfWork();
        $originalAdmin = $uow->getOriginalEntityData($object);
        $oldPassword = array_key_exists('password', $originalAdmin) ? $originalAdmin['password'] : null;
        if ($object->getPassword() and $object->getPassword() !== $oldPassword) {
            $encoder = $this->getContainer()->get('security.password_encoder');
            $password = $encoder->encodePassword($object, $object->getPassword());
            $object->setPassword($password);
        } else {
            $object->setPassword($oldPassword);
        }
    }
}