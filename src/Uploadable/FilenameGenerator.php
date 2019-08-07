<?php

namespace App\Uploadable;

use App\Entity\Superclass\File;
use Gedmo\Uploadable\FilenameGenerator\FilenameGeneratorInterface;

class FilenameGenerator implements FilenameGeneratorInterface
{

    public static function generate($filename, $extension, $object = null, $identifier = null)
    {
        $path = sha1(uniqid(((null == $identifier)?'':$identifier).$filename.$extension, true)).$extension;
        $path = '/' . substr($path, 0, 2) . '/' . substr($path, 2, 2) . '/' . $path;

        if ($object instanceof File) {
            $fullPath = $object->getUploadRootDir() . $object->getWebUploadDir() . $path;
            @mkdir(dirname($fullPath), 0777, true);
        }
        return $path;
    }

}