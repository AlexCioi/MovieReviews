<?php

namespace MovieBundle\Service;

use MovieBundle\Entity\MovieCategory;

class MovieCategoryManager
{
    public function newInstance(string $name = null): MovieCategory
    {
        $movieCategory = new MovieCategory();

        $movieCategory->setName($name);

        return $movieCategory;
    }
}
