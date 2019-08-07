<?php

namespace App\Controller\Backend;

use App\Entity\Superclass\Content;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Controller\CRUDController;
use Doctrine\ORM\QueryBuilder;

class ContentAdminController extends CRUDController
{

    public function listAction()
    {
        $this->admin->checkAccess('list');

        /** @var QueryBuilder $query */
        $query = $this->admin->createQuery('list');

        $contents = $query
            ->select('o, page_content_children')
            ->leftJoin('o.children', 'page_content_children')
            ->addSelect('TYPE(page_content_children) as HIDDEN ctype')
            ->orderBy('o.level', 'asc')
            ->addOrderBy('ctype', 'desc')
            ->addOrderBy('o.name', 'asc')
            ->getQuery()
            ->getResult();

        /** @var Content[] $orderedContents */
        $orderedContents = $this->reorderContents($contents);

        return $this->renderWithExtraParams(
            'Content\list.html.twig',
            [
                'action'        => 'list',
                'contents'      => array_unique($orderedContents)
            ],
            null
        );
    }

    private function reorderContents($contents)
    {
        $orderedContents = [];
        /** @var Content $content */
        foreach ($contents as $content) {
            $orderedContents[] = $content;

            $children = $content->getChildren();
            $childrenContents = $this->reorderContents($children);
            $orderedContents = array_merge($orderedContents, $childrenContents);
        }

        return $orderedContents;
    }

}
