<?php

namespace App\Admin;

use App\Entity\FileImage;
use App\Type\HtmlImageType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\ModelType;
use Sonata\CoreBundle\Model\Metadata;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class AdminFileImage extends AbstractAdmin
{

    protected $classnameLabel = 'Images';

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
        $subject = $this->getSubject();

        if ($subject->getId()) {
            $formMapper->add('current_image', HtmlImageType::class, [
                'src' => $this->getConfigurationPool()->getContainer()->get('assets.packages')->getUrl($subject->getWebPath()),
                'label' => 'Current Image',
                'mapped' => false,
                'required' => false
            ]);
        }

        $formMapper
            ->add('file_path', FileType::class, array(
                'label' => $subject->getId() ? 'New Image' : 'Image',
                'required' => $subject->getId() ? false : true
            ))
            ->add('categories', ModelType::class, [
                'multiple' => true,
                'required' => false
            ])
        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('categories')
        ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        if ($mode = $this->request->query->get('_list_mode')) {
            $this->setListMode($mode);
        } else {
            $this->setListMode('mosaic');
        }

        $listMapper
            ->addIdentifier('real_file_name')
        ;

        unset($this->listModes['list']);
    }

    public function prePersist($object)
    {
        parent::prePersist($object);

        $this->processMedia($object);
    }

    public function preUpdate($object)
    {
        parent::preUpdate($object);

        $this->processMedia($object);
    }

    protected function processMedia(FileImage $object)
    {
        if ($object->getFilePath()) {
            $this->getConfigurationPool()->getContainer()->get('gedmo.listener.uploadable.manager')->markEntityToUpload($object, $object->getFilePath());
        }
    }

    public function getObjectMetadata($object)
    {
        $url = $this->getConfigurationPool()->getContainer()->get('assets.packages')->getUrl($object->getWebPath());

        return new Metadata($object, '', $url);
    }

}
