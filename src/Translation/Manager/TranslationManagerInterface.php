<?php

namespace App\Translation\Manager;

use App\Entity\Translation;

interface TranslationManagerInterface
{

    public function findByLocaleAndDomain(string $locale, string $domain = ''): array;
    public function findOneByTokenLocaleAndDomain(string $id, string $locale, string $domain = ''): ?Translation;

}