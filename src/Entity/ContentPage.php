<?php

namespace App\Entity;

use App\Entity\Interfaces\ContentWithImageInterface;
use App\Entity\Superclass\Content;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Entity
 * @ORM\Table(name="contents_pages")
 */
class ContentPage extends Content implements ContentWithImageInterface
{

    use ORMBehaviors\Translatable\Translatable;

    const CHANGE_FREQ_ALWAYS = 'always';
    const CHANGE_FREQ_HOURLY = 'hourly';
    const CHANGE_FREQ_DAILY = 'daily';
    const CHANGE_FREQ_WEEKLY = 'weekly';
    const CHANGE_FREQ_MONTHLY = 'monthly';
    const CHANGE_FREQ_YEARLY = 'yearly';
    const CHANGE_FREQ_NEVER = 'never';

    protected $contentType = "Page";

    /**
     * @ORM\Column(
     *     type="string",
     *     columnDefinition="ENUM('always','hourly','daily','weekly','monthly','yearly','never') NOT NULL"
     * )
     */
    protected $changeFrequency = 'daily';

    /**
     * @ORM\Column(type="string", length=255, nullable=false, unique=true)
     */
    protected $route;

    /**
     * @ORM\Column(type="decimal", precision=2, scale=1, options={"default":0.5})
     */
    protected $priority = 0.5;

    /**
     * @var boolean
     * @ORM\Column(name="has_meta_title", type="boolean", options={"default":false})
     */
    protected $hasMetaTitle;

    /**
     * @var boolean
     * @ORM\Column(name="has_meta_keywords", type="boolean", options={"default":false})
     */
    protected $hasMetaKeywords;

    /**
     * @var boolean
     * @ORM\Column(name="has_meta_description", type="boolean", options={"default":false})
     */
    protected $hasMetaDescription;

    /**
     * @var boolean
     * @ORM\Column(name="has_content", type="boolean", options={"default":false})
     */
    protected $hasContent;

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $controllerAction = 'FrameworkBundle:Template:template';

    /**
     * @var string
     * @ORM\Column(type="string", length=255)
     */
    protected $template = 'App/page.html.twig';

    public function __construct()
    {
        parent::__construct();

        $this->setChangeFrequency(self::CHANGE_FREQ_WEEKLY);
        $this->setPriority(0.5);

        $this->setHasMetaTitle(false);
        $this->setHasMetaKeywords(false);
        $this->setHasMetaDescription(false);
        $this->setHasContent(false);
    }

    /**
     * @return mixed
     */
    public function getChangeFrequency() : string
    {
        return $this->changeFrequency;
    }

    /**
     * @param mixed $changeFrequency
     *
     * @return ContentPage
     */
    public function setChangeFrequency($changeFrequency) : ContentPage
    {
        $this->changeFrequency = $changeFrequency;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriority() : float
    {
        return $this->priority;
    }

    /**
     * @param mixed $priority
     *
     * @return ContentPage
     */
    public function setPriority($priority) : ContentPage
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoute() : string
    {
        return $this->route;
    }

    /**
     * @param string $route
     *
     * @return ContentPage
     */
    public function setRoute($route) : ContentPage
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasMetaTitle() : bool
    {
        return $this->hasMetaTitle;
    }

    /**
     * @param boolean $hasMetaTitle
     *
     * @return ContentPage
     */
    public function setHasMetaTitle($hasMetaTitle) : ContentPage
    {
        $this->hasMetaTitle = $hasMetaTitle;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasMetaKeywords() : bool
    {
        return $this->hasMetaKeywords;
    }

    /**
     * @param boolean $hasMetaKeywords
     *
     * @return ContentPage
     */
    public function setHasMetaKeywords($hasMetaKeywords) : ContentPage
    {
        $this->hasMetaKeywords = $hasMetaKeywords;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isHasMetaDescription() : bool
    {
        return $this->hasMetaDescription;
    }

    /**
     * @param boolean $hasMetaDescription
     *
     * @return ContentPage
     */
    public function setHasMetaDescription($hasMetaDescription) : ContentPage
    {
        $this->hasMetaDescription = $hasMetaDescription;

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
     * @return ContentPage
     */
    public function setHasContent($hasContent) : ContentPage
    {
        $this->hasContent = $hasContent;

        return $this;
    }

    /**
     * @return string
     */
    public function getControllerAction() : string
    {
        return $this->controllerAction;
    }

    public function setControllerAction($controllerAction) : ContentPage
    {
        $this->controllerAction = $controllerAction;

        return $this;
    }

    /**
     * @return string
     */
    public function getTemplate() : string
    {
        return $this->template;
    }

    public function setTemplate($template) : ContentPage
    {
        $this->template = $template;

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
