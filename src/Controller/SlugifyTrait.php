<?php
namespace App\Controller;

use Behat\Transliterator\Transliterator;

trait SlugifyTrait
{

    /**
     * Permet de genérer un slug à partir d'un string
     * @param string $title
     * @return string
     */
    public function slugify(string $title)
    {
        return Transliterator::transliterate($title);
    }

}