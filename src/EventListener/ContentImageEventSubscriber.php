<?php

namespace App\EventListener;

use App\Entity\Interfaces\ContentWithImageInterface;
use App\Manager\ContentImageBase64Converter;
use Doctrine\Common\EventSubscriber;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class ContentImageEventSubscriber implements EventSubscriber
{

    /**
     * @var ContentImageBase64Converter
     */
    protected $contentImageBase64Converter;

    public function __construct(ContentImageBase64Converter $contentImageBase64Converter)
    {
        $this->contentImageBase64Converter = $contentImageBase64Converter;
    }

    public function getSubscribedEvents()
    {
        return array(
            Events::prePersist,
            Events::preUpdate,
        );
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        $this->findBase64ImagesAndReplace($args);
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $this->findBase64ImagesAndReplace($args);
    }

    public function findBase64ImagesAndReplace(LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof ContentWithImageInterface) {
            $fields = $entity->getImageFields();
            foreach ($fields as $field) {
                $getMethod = 'get' . ucfirst($field);
                $setMethod = 'set' . ucfirst($field);

                if (method_exists($entity, $getMethod) and method_exists($entity, $setMethod)) {
                    $convertedContent = $this->contentImageBase64Converter->convert($entity->$getMethod());
                    $entity->$setMethod($convertedContent);
                }
            }
        }
    }

}