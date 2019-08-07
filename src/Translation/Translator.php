<?php

namespace App\Translation;

use App\Translation\Manager\TranslationManagerInterface;
use App\Entity\Translation;
use Symfony\Bundle\FrameworkBundle\Translation\Translator as SymfonyTranslator;

class Translator extends SymfonyTranslator
{
    /**
     * @var TranslationManagerInterface
     */
    private $_translationManager;

    /**
     * @param TranslationManagerInterface $translationManager
     */
    public function setTranslationManager(TranslationManagerInterface $translationManager)
    {
        $this->_translationManager = $translationManager;
    }

    /**
     * {@inheritdoc}
     */
    public function trans($id, array $parameters = [], $domain = null, $locale = null)
    {
        if (null === $locale && null !== $this->getLocale()) {
            $locale = $this->getLocale();
        }

        if (null === $locale) {
            $locale = $this->getFallbackLocales()[0]; // fallback locale
        }

        if (null === $domain) {
            $domain = 'messages';
        }

        $id = (string) $id;
        $catalogue = $this->getCatalogue($locale);
        if (!$catalogue->has($id, $domain)) {
//            // the translation manager automagically creates new translation entries if it doesn't exist yet
//            $translation = $this->_translationManager->findOneByTokenLocaleAndDomain($id, $locale, $domain);
//
//            // check if it exists
//            if (isset($translation) && null !== $translation && $translation instanceof Translation) {
//                return strtr($translation->getTranslation(), $parameters);
//            }
//
//            return "[T]{$id}[/T]";
        }

        // fallback
        return parent::trans($id, $parameters, $domain, $locale);
    }
}