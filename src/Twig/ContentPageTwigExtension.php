<?php

namespace App\Twig;

use App\Manager\ContentPageManager;

class ContentPageTwigExtension extends \Twig_Extension
{

    protected $pageContentManager;

    public function __construct(ContentPageManager $pageContentManager)
    {
        $this->pageContentManager = $pageContentManager;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('render_text_block', [$this, 'renderTextBlock']),
            new \Twig_SimpleFunction('render_text_block_title', [$this, 'renderTextBlockTitle']),
            new \Twig_SimpleFunction('render_image', [$this, 'renderImage']),
        ];
    }

    public function renderTextBlock($uid, $replace = [])
    {
        $textBlock = $this->pageContentManager->getTextBlock($uid);

        $textBlockContent = str_replace(array_keys($replace), array_values($replace), $textBlock->getContent());

        return $textBlockContent;
    }

    public function renderTextBlockTitle($uid)
    {
        $textBlock = $this->pageContentManager->getTextBlock($uid);

        return $textBlock->getTitle();
    }

    public function renderImage($uid)
    {
        $textBlock = $this->pageContentManager->getImage($uid);

        return $textBlock->getImage() ? $textBlock->getImage()->getWebPath() : '';
    }

    public function getName()
    {
        return 'content_page_extension';
    }

}

