<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Table(name="translations_translations")
 */
class TranslationTranslation
{

    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Translation is required.")
     */
    protected $translation;

    /**
     * @var string
     * @ORM\Column(type="string", length=2, nullable=false)
     *
     * @Assert\NotBlank(message="Locale is required.")
     */
    protected $locale;

    public function getTranslation(): ?string
    {
        return $this->translation;
    }

    public function setTranslation(string $translation): self
    {
        $this->translation = $translation;

        return $this;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function setLocale(string $locale): self
    {
        $this->locale = $locale;

        return $this;
    }

}