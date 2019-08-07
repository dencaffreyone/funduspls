<?php

namespace App\Manager;

use Symfony\Component\Asset\Packages;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\RequestStack;

class ContentImageBase64Converter
{

    /**
     * @var Packages
     */
    protected $assetsManager;

    protected $webPath;

    protected $realpath;

    /**
     * @var RequestStack
     */
    protected $request;

    public function __construct(Packages $assetsManager, $webPath, $realPath, RequestStack $request)
    {
        $this->assetsManager = $assetsManager;
        $this->webPath = $webPath;
        $this->realpath = $realPath;
        $this->request = $request;
    }

    public function convert($text) : string
    {
        $realpath = $this->realpath;
        $request = $this->request;
        $replacedText = preg_replace_callback('|src="data:image/(.*);base64,(.*)"|isU', function ($matches) use ($realpath, $request) {
            $ext = $matches[1];
            $fileName = md5(uniqid()) . '.' . $ext;

            $fs = new Filesystem();
            $fs->mkdir($realpath);

            file_put_contents($realpath . '/' . $fileName, base64_decode($matches[2]));

            $url = $request->getCurrentRequest()->getSchemeAndHttpHost();

            return 'src="' . $url . $this->assetsManager->getUrl($this->webPath . '/' . $fileName) . '"';
        }, $text);

        return $replacedText;
    }

}