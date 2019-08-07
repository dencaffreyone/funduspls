<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Table(name="translations",indexes={@ORM\Index(name="locale_domain_idx", columns={"source", "domain"})})
 */
class Translation
{

    use ORMBehaviors\Translatable\Translatable;

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false)
     *
     * @Assert\NotBlank(message="Source is required.")
     */
    protected $source;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $domain = '';


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSource(): ?string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;

        return $this;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): self
    {
        $this->domain = $domain;

        return $this;
    }

    public function __call($method, $arguments)
    {
        if (!method_exists(self::getTranslationEntityClass(), $method)) {
            $method = 'get'. ucfirst($method);
        }

        $data = $this->proxyCurrentLocaleTranslation($method, $arguments);
        if ($data) {
            return $data;
        }
        $default = $this->translate('en');

        return $default->$method($arguments);
    }

}