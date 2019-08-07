<?php

namespace App\Manager;

use App\Entity\ContentImage;
use App\Entity\ContentPage;
use App\Entity\ContentTextBlock;
use App\Entity\Superclass\Content;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\RouterInterface;

class ContentPageManager
{
    /** @var EntityManager  */
    protected $entityManager;

    /** @var Router */
    protected $router;

    /** @var array  */
    protected $cacheDirs = [];

    /** @var string  */
    protected $currentApp;

    /** @var array */
    protected $cache = [];

    /**
     * @var Filesystem
     */
    protected $filesystem;

    public function __construct(EntityManagerInterface $entityManager, RouterInterface $router, $currentApp = 'app', Filesystem $filesystem)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->currentApp = $currentApp;
        $this->filesystem = $filesystem;
    }

    public function addCacheDir($app, $cacheDir)
    {
        $this->cacheDirs[$app] = $cacheDir;
    }

    public function findPageByRoute($route)
    {
        return $this->entityManager->getRepository(ContentPage::class)->findOneBy(['route' => $route]);
    }

    public function getPageUpdatedAt(PageContent $page)
    {
        $updatedAt = $page->getUpdatedAt();

        foreach ($page->getChildren() as $child) {
            if ($child instanceof ContentTextBlock) {
                $updatedAt = ($child->getUpdatedAt() > $updatedAt) ? $child->getUpdatedAt() : $updatedAt;
            }
        }

        return $updatedAt;
    }

    public function generateCacheForPage(ContentPage $page)
    {
        $ids = [];
        $parents = [$page->getId()];
        do {
            $blocks = $this->entityManager
                ->getRepository(Content::class)
                ->createQueryBuilder('c')
                ->select('c.id')
                ->where('c not instance of :page and c.parent in (:parents)')
                ->setParameter('page', $this->entityManager->getClassMetadata(ContentPage::class))
                ->setParameter('parents', array_diff($parents, $ids))
                ->getQuery()
                ->execute();

            $ids = $parents;
            foreach ($blocks as $block) {
                $parents[] = $block['id'];
            }
        } while (!empty($blocks));

        $cacheTables = [
            ContentTextBlock::class,
            ContentImage::class
        ];
        foreach ($cacheTables as $cacheTable) {
            $metaData = $this->entityManager->getClassMetadata($cacheTable);

            $query = $this->entityManager->getRepository($cacheTable)
                ->createQueryBuilder('c')
                ->where('c.id in (:ids)')
                ->setParameter('ids', $ids);

            if (isset($metaData->getAssociationMappings()['translations'])) {
                $query->leftJoin('c.translations', 'ct')
                    ->addSelect('ct');
            }
            $caches = $query
                ->getQuery()
                ->execute();
            foreach ($caches as $cache) {
                if ($cache instanceof ContentTextBlock) {
                    $this->cache['text_block'][$cache->getUid()] = $cache;
                }
                if ($cache instanceof ContentImage) {
                    $this->cache['image'][$cache->getUid()] = $cache;
                }
            }
        }
    }

    /**
     * @param $uid
     *
     * @return null|ContentTextBlock
     */
    public function getTextBlock($uid)
    {
        if (!isset($this->cache['text_block'][$uid])) {
            $textBlockRepository = $this->entityManager->getRepository(ContentTextBlock::class);
            $textBlock = $textBlockRepository->findOneBy([
                'uid' => $uid
            ]);

            $this->cache['text_block'][$uid] = $textBlock;
        }

        return $this->cache['text_block'][$uid];
    }

    /**
     * @param $uid
     *
     * @return null|ContentImage
     */
    public function getImage($uid)
    {
        if (!isset($this->cache['image'][$uid])) {
            $imageRepository = $this->entityManager->getRepository(ContentImage::class);
            $imageBlock = $imageRepository->findOneBy([
                'uid' => $uid
            ]);

            $this->cache['image'][$uid] = $imageBlock;
        }

        return $this->cache['image'][$uid];
    }

    public function clearAllCache()
    {
        foreach ($this->cacheDirs as $app => $cacheDir) {
            $cacheDir = str_replace($this->currentApp, $app, $cacheDir);
            $this->filesystem->remove($cacheDir);
        }
    }
}

