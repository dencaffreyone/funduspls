<?php

namespace App\Admin;

use App\Entity\FileImageCategory;
use App\Type\DataTransformer\EntityToIntTransformer;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdminFileImageCategory extends AbstractAdmin
{

    protected $classnameLabel = 'Images Categories';

    protected $maxPerPage = 10000;

    protected $perPageOptions = [10000];

    protected $datagridValues = [
        '_page' => 1,
        '_sort_order' => 'ASC',
        '_sort_by' => 'level ASC',
    ];

    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $parentChoices = $this->getParentChoices($this->getSubject());
        $em = $this->getConfigurationPool()->getContainer()->get('doctrine');

        $formMapper
            ->add('name')
            ->add('parent', ChoiceType::class, [
                'required' => false,
                'choices' => $parentChoices
            ]);

        $formMapper->get('parent')->addModelTransformer(new EntityToIntTransformer(
            $em->getManager(),
            FileImageCategory::class
        ));
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
    }

    public function getParentChoices(FileImageCategory $excludeFileImageCategory = null)
    {
        $query = $this->getConfigurationPool()->getContainer()->get('doctrine')
            ->getRepository(FileImageCategory::class)
            ->createQueryBuilder('fic')
            ->leftJoin('fic.children', 'ficc')
            ->select('fic, ficc')
            ->orderBy('fic.level', 'asc');

        $categories = $query
            ->getQuery()
            ->getResult();

        $choices = [];
        $excludes = [$excludeFileImageCategory->getId()];
        $this->createChoicesFromCategories($categories,$choices,$excludes);

        return $choices;
    }

    private function createChoicesFromCategories($categories, &$choices, &$excludes)
    {
        /** @var FileImageCategory $category */
        foreach ($categories as $category) {
            if (in_array($category->getId(), $excludes)) {
                foreach ($category->getChildren() as $child) {
                    $excludes[] = $child->getId();
                }
                continue;
            }
            $choices[$category->levelOffset(' -- ') . $category->getName()] =  $category->getId();
            $this->createChoicesFromCategories($category->getChildren(),$choices, $excludes);
        }
    }

    private function reorderChildren($children)
    {
        $ordered = [];

        /** @var FileImageCategory $child */
        foreach ($children as $child) {
            $ordered[] = $child;
            $ordered = array_merge($ordered, $this->reorderContents($child->getChildren()));
        }
        return $ordered;
    }

}
