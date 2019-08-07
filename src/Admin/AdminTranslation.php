<?php

namespace App\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminTranslation extends AbstractAdmin
{
    protected $classnameLabel = 'Translations';

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('export');

        parent::configureRoutes($collection);
    }

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $fields = [
            'translation' => [
                'field_type' => TextType::class,
                'label' => 'Translation'
            ],
        ];

        $formMapper
            ->add('source', TextType::class, ['label' => 'Source'])
            ->add('domain', TextType::class, ['label' => 'Domain', 'empty_data' => '', 'required' => false])
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
            ->add('source')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('source')
            ->add('translation')
            ->add('locale')
            ->add('domain')
        ;

        unset($this->listModes['mosaic']);
    }

    public function prePersist($object)
    {
        parent::prePersist($object);

        $this->resetCaches();
    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);

        $this->resetCaches();
    }

    public function preRemove($object)
    {
        parent::preRemove($object);

        $this->resetCaches();
    }

    public function resetCaches()
    {
        $this->getConfigurationPool()
            ->getContainer()
            ->get('app.content_page.manager')
            ->clearAllCache();
    }
}

