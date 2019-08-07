<?php

namespace App\Translation\Manager;

use App\Entity\Translation;
use Doctrine\ORM\EntityManagerInterface;

class TranslationManager implements TranslationManagerInterface
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function findByLocaleAndDomain(string $locale, string $domain = ''): array
    {
        return $this->entityManager
            ->getRepository(Translation::class)
            ->createQueryBuilder('t')
            ->leftJoin('t.translations', 'tt')
            ->addSelect('tt')
            ->where("(t.domain = '' or t.domain = :domain)")
            ->setParameter('domain', $domain)
            ->getQuery()
            ->execute();
    }

    public function findOneByTokenLocaleAndDomain(string $id, string $locale, string $domain = ''): ?Translation
    {
        if (!$domain) {
            $domain = '';
        }

        return $this->entityManager
            ->getRepository(Translation::class)
            ->createQueryBuilder('t')
            ->leftJoin('t.translations', 'tt')
            ->addSelect('tt')
            ->where("(t.domain = '' or t.domain = :domain) and t.source = :source")
            ->setParameter('domain', $domain)
            ->setParameter('source', $id)
            ->getQuery()
            ->getOneOrNullResult();

    }

}