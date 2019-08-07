<?php

namespace App\Entity;

use App\Entity\Interfaces\ContentWithImageInterface;
use App\Entity\Superclass\Content;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents_text_blocks")
 */
class ContentTextBlock extends Content implements ContentWithImageInterface
{

    use ORMBehaviors\Translatable\Translatable;

    protected $contentType = "Text block";

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $uid;

    /**
     * @var boolean
     * @ORM\Column(name="has_title", type="boolean", options={"default":false})
     */
    protected $hasTitle;

    /**
     * @var boolean
     * @ORM\Column(name="has_content", type="boolean", options={"default":false})
     */
    protected $hasContent;

    /**
     * @return string
     */
    public function getUid() : string
    {
        return $this->uid;
    }

    /**
     * @param string $uid
     *
     * @return ContentTextBlock
     */
    public function setUid($uid) : ContentTextBlock
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasTitle() : bool
    {
        return $this->hasTitle;
    }

    /**
     * @param boolean $hasTitle
     *
     * @return ContentTextBlock
     */
    public function setHasTitle($hasTitle) : ContentTextBlock
    {
        $this->hasTitle = $hasTitle;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasContent() : bool
    {
        return $this->hasContent;
    }

    /**
     * @param boolean $hasContent
     *
     * @return ContentTextBlock
     */
    public function setHasContent($hasContent) : ContentTextBlock
    {
        $this->hasContent = $hasContent;

        return $this;
    }

    public function getImageFields() : array
    {
        return ['content'];
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

