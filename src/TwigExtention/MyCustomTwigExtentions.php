<?php

namespace App\TwigExtention;
use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;

class MyCustomTwigExtentions extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('defaultImage', [$this, 'defaultImage'])
        ];
    }

    public function defaultImage(string $path): string
    {
        if (
            strlen(trim($path)) == 0) {
            return 'IMG_9846.jpg';
        } else {
            return $path;
        }
    }
}