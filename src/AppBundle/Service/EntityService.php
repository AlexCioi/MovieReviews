<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntityService
{
    public function __construct(
        protected EntityManagerInterface $em,
    )
    {
    }

    public function findOrReject(string $entityClass, $id)
    {
        $entity = $this->em->getRepository($entityClass)->find($id);

        if (!$entity) {
            throw new NotFoundHttpException('Entity not found');
        }

        return $entity;
    }

    public function save($entity): void
    {
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function delete($entity): void
    {
        $this->em->remove($entity);
        $this->em->flush();
    }
}
