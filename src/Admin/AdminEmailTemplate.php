<?php

namespace App\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Type\SummernoteType;
use Sonata\AdminBundle\Admin\AbstractAdmin as BaseAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminEmailTemplate extends BaseAdmin
{
    protected $classnameLabel = 'Email Templates';

    protected $holdersLabel = 'Holders';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('delete')
            ->remove('export');

        parent::configureRoutes($collection);
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $holdersInfo = $this->getSubject()->getHoldersAsString();

        $fields = [
            'subject' => [
                'field_type' => TextType::class,
                'label' => 'Notification Subject'
            ],
            'message' => [
                'field_type' => SummernoteType::class,
                'label' => 'Notification Body',
                'help' => sprintf('<p><b>%s:</b></p>%s', $this->holdersLabel, $holdersInfo)
            ]
        ];

        $formMapper
            ->add('name', TextType::class, ['label' => 'Name'])
            ->add('translations', TranslationsType::class, [
                'label'=> false,
                'fields' => $fields
            ])
            ->end();
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('subject');

        unset($this->listModes['mosaic']);
    }
}

