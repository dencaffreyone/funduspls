<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents_text_blocks_translations")
 */
class ContentTextBlockTranslation
{

    use ORMBehaviors\Translatable\Translation;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $title = '';

    /**
     * @var string
     * @ORM\Column(type="text")
     */
    protected $content = '';

    /**
     * @return string
     */
    public function getTitle() : string
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return ContentTextBlockTranslation
     */
    public function setTitle($title) : ContentTextBlockTranslation
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent() : string
    {
        return $this->content;
    }

    /**
     * @param string $content
     *
     * @return ContentTextBlockTranslation
     */
    public function setContent($content) : ContentTextBlockTranslation
    {
        $this->content = $content;

        return $this;
    }

}

