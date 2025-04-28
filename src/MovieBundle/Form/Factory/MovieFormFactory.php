<?php

namespace MovieBundle\Form\Factory;

use MovieBundle\Entity\Movie;
use MovieBundle\Form\Type\Movie\MovieCreateType;
use MovieBundle\Form\Type\Movie\MovieEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class MovieFormFactory
{
    public function __construct(
        protected FormFactoryInterface $formFactory,
    )
    {
    }

    public function getCreateForm(Movie $movie, array $options = []): FormInterface
    {
        return $this->formFactory->create(MovieCreateType::class, $movie, $options);
    }

    public function getEditForm(Movie $movie, array $options = []): FormInterface
    {
        return $this->formFactory->create(MovieEditType::class, $movie, $options);
    }
}
