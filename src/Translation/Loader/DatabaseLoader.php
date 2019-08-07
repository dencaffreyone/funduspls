<?php

namespace App\Translation\Loader;

use App\Entity\Translation;
use App\Translation\Manager\TranslationManagerInterface;
use Symfony\Component\Translation\Loader\LoaderInterface;
use Symfony\Component\Translation\MessageCatalogue;

/**
 * Database Loader
 */
class DatabaseLoader implements LoaderInterface
{

    /**
     * Translation Manager
     *
     * @var TranslationManagerInterface
     */
    private $_translationManager;

    /**
     * Constructor
     *
     * @param TranslationManagerInterface $translationManager
     */
    public function __construct(TranslationManagerInterface $translationManager)
    {
        $this->_translationManager = $translationManager;
    }

    /**
     * {@inheritDoc}
     */
    public function load($resource, $locale, $domain = '')
    {
        $translations = $this->_translationManager->findByLocaleAndDomain($locale, $domain);

        $catalogue = new MessageCatalogue($locale);

        /* @var Translation $translation */
        foreach($translations as $translation)
        {
            $catalogue->set(
                $translation->getSource(),
                isset($translation->getTranslations()[$locale]) ? $translation->getTranslations()[$locale]->getTranslation() : $translation->getSource(),
                $translation->getDomain() ?: 'messages'
            );
        }

        return $catalogue;
    }

}