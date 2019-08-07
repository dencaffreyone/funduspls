<?php

namespace App\Admin;

use App\Entity\Admin;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdminUser extends AbstractAdmin
{

    protected $classnameLabel = 'Admins';

    protected $formOptions = [
        'validation_groups' => ['Default']
    ];

    public function configure()
    {
        parent::configure();

        $this->setTemplate('edit', 'Admin/edit.html.twig');
    }

    public function getFormBuilder()
    {
        if (is_null($this->getSubject()->getId())) {
            $this->formOptions['validation_groups'][] = 'new';
        }

        $formBuilder = parent::getFormBuilder();

        return $formBuilder;
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', TextType::class, array('label' => 'Username'))
            ->add('password', PasswordType::class, array('label' => 'Password', 'required' => $this->getSubject()->isNew()))
            ->add(
                'repeat_password',
                PasswordType::class,
                array(
                    'label' => 'Repeat Password',
                    'required' => $this->getSubject()->isNew())
            )
            ->add('two_factor_authentication', CheckboxType::class, [
                'required' => false
            ])
            ->add('two_factor_email', EmailType::class, [
                'required' => false
            ])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('username')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('username')
        ;

        unset($this->listModes['mosaic']);
    }

    public function getExportFields()
    {
        return array(
            'id',
            'username'
        );
    }

    public function prePersist($object)
    {
        parent::prePersist($object);

        $this->cryptPassword($object);
    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);

        $this->cryptPassword($object);
    }

    private function cryptPassword(Admin $object)
    {
        /** @var EntityManager $dm */
        $dm = $this->getConfigurationPool()->getContainer()->get('doctrine')->getManager();
        $uow = $dm->getUnitOfWork();
        $originalAdmin = $uow->getOriginalEntityData($object);
        $oldPassword = array_key_exists('password', $originalAdmin) ? $originalAdmin['password'] : null;
        if ($object->getPassword()) {
            $encoder = $this->getConfigurationPool()->getContainer()->get('security.password_encoder');
            $password = $encoder->encodePassword($object, $object->getPassword());
            $object->setPassword($password);
        } else {
            $object->setPassword($oldPassword);
        }
    }
}
