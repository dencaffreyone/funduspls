<?php

namespace App\Controller\Backend;

use App\Entity\FileImageCategory;
use Sonata\AdminBundle\Controller\CRUDController;
use Doctrine\ORM\QueryBuilder;

class FileImageCategoryAdminController extends CRUDController
{

    public function listAction()
    {
        $this->admin->checkAccess('list');

        /** @var QueryBuilder $query */
        $query = $this->admin->createQuery('list');

        $categories = $query
            ->select('o, file_image_category_children')
            ->leftJoin('o.children', 'file_image_category_children')
            ->orderBy('o.level', 'asc')
            ->getQuery()
            ->getResult();

        /** @var FileImageCategory[] $orderedCtegories */
        $orderedCategories = $this->reorderCategories($categories);

        return $this->renderWithExtraParams(
            'FileImageCategory\list.html.twig',
            [
                'action'             => 'list',
                'categories'         => array_unique($orderedCategories),
            ],
            null
        );
    }

    private function reorderCategories($categories)
    {
        $orderedCategories = [];

        /** @var Content $content */
        foreach ($categories as $category) {
            $orderedCategories[] = $category;
            $orderedCategories = array_merge($orderedCategories, $this->reorderCategories($category->getChildren()));
        }
        return $orderedCategories;
    }

}
