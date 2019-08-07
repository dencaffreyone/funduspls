<?php

namespace App\Type\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;

class EntityToIntTransformer implements DataTransformerInterface
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    private $om;
    private $entityClass;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om, $entityClass)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
    }

    /**
     * @param mixed $entity
     *
     * @return integer
     */
    public function transform($entity)
    {
        // Modified from comments to use instanceof so that base classes or interfaces can be specified
        if (null === $entity || !($entity instanceof $this->entityClass)) {
            return '';
        }

        return $entity->getId();
    }

    /**
     * @param mixed $id
     *
     * @throws \Symfony\Component\Form\Exception\TransformationFailedException
     *
     * @return mixed|object
     */
    public function reverseTransform($id)
    {
        if (!$id) {
            return null;
        }

        $entity = $this->om->getRepository($this->entityClass)->find(array('id' => $id));

        if (null === $entity) {
            throw new TransformationFailedException(sprintf(
                'A %s with id "%s" does not exist!',
                $this->entityClass,
                $id
            ));
        }

        return $entity;
    }

}