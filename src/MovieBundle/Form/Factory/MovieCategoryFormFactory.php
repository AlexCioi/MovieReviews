<?php

namespace MovieBundle\Form\Factory;

use MovieBundle\Entity\MovieCategory;
use MovieBundle\Form\Type\MovieCategory\MovieCategoryCreateType;
use MovieBundle\Form\Type\MovieCategory\MovieCategoryEditType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;

class MovieCategoryFormFactory
{
    public function __construct(
        protected FormFactoryInterface $formFactory
    )
    {
    }

    public function getCreateForm(MovieCategory $movieCategory, array $options = []): FormInterface
    {
        return $this->formFactory->create(MovieCategoryCreateType::class, $movieCategory, $options);
    }

    public function getEditForm(MovieCategory $movieCategory, array $options = []): FormInterface
    {
        return $this->formFactory->create(MovieCategoryEditType::class, $movieCategory, $options);
    }
}
