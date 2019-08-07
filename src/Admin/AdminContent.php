<?php

namespace App\Admin;

use A2lix\TranslationFormBundle\Form\Type\TranslationsType;
use App\Entity\ContentImage;
use App\Entity\ContentPage;
use App\Entity\ContentTextBlock;
use App\Entity\Superclass\Content;
use App\Type\SummernoteType;
use Sonata\AdminBundle\Form\Type\ModelListType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class AdminContent extends AbstractAdmin
{
    protected $maxPerPage = 10000;

    protected $perPageOptions = [10000];

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'level ASC, name DESC',
    ];

    public function configureActionButtons($action, $object = null)
    {
        return [];
    }

    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->clearExcept(
                [
                    'list',
                    'show',
                    'edit'
                ]
            );

        parent::configureRoutes($collection);
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
        ;

        $subject = $this->getSubject();

        if ($subject instanceof ContentPage) {
            $excludedFields = [];
            $fields = [
                'url' => [
                    'field_type' => TextType::class,
                    'label' => 'URL'
                ]
            ];

            if ($subject->isHasMetaTitle()) {
                $fields['metaTitle'] = [
                    'field_type' => TextType::class,
                    'required' => false,
                    'empty_data' => '',
                ];
            } else {
                $excludedFields[] = 'metaTitle';
            }

            if ($subject->isHasMetaKeywords()) {
                $fields['metaKeywords'] = [
                    'field_type' => TextType::class,
                    'required' => false,
                    'empty_data' => '',
                ];
            } else {
                $excludedFields[] = 'metaKeywords';
            }

            if ($subject->isHasMetaDescription()) {
                $fields['metaDescription'] = [
                    'field_type' => TextType::class,
                    'required' => false,
                    'empty_data' => '',
                ];
            } else {
                $excludedFields[] = 'metaDescription';
            }

            if ($subject->isHasContent()) {
                $fields['content'] = [
                    'field_type' => SummernoteType::class,
                    'required' => false,
                    'empty_data' => '',
                ];
            } else {
                $excludedFields[] = 'content';
            }

            $formMapper
                ->add('translations', TranslationsType::class, [
                    'label'=> false,
                    'fields' => $fields,
                    'excluded_fields' => $excludedFields
                ]);
        } elseif ($subject instanceof ContentTextBlock) {
            $excludedFields = [];

            if ($subject->isHasTitle()) {
                $fields['title'] = [
                    'field_type' => TextType::class,
                    'required' => false,
                    'empty_data' => '',
                ];
            } else {
                $excludedFields[] = 'title';
            }

            if ($subject->isHasContent()) {
                $fields['content'] = [
                    'field_type' => SummernoteType::class,
                    'required' => false,
                    'empty_data' => '',
                ];
            } else {
                $excludedFields[] = 'content';
            }

            $formMapper
                ->add('translations', TranslationsType::class, [
                    'label'=> false,
                    'fields' => $fields,
                    'excluded_fields' => $excludedFields
                ]);
        } elseif ($subject instanceof ContentImage) {
            $formMapper
                ->add('image', ModelListType::class, [
                    'required' => false,
                    'btn_add' => 'Upload New Image',
                    'btn_list' => 'Select Image',
                    'btn_delete' => 'Remove Current Image'
                ]);
            ;
        }
    }

    protected function configureListFields(ListMapper $listMapper)
    {

    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);

        $this->resetCaches($object);
    }

    public function preRemove($object)
    {
        parent::preRemove($object);

        $this->resetCaches($object);
    }

    public function resetCaches(Content $object)
    {
        if ($object instanceof ContentPage) {
            $this->getConfigurationPool()
                ->getContainer()
                ->get('app.content_page.manager')
                ->clearAllCache();
        }
    }

}

