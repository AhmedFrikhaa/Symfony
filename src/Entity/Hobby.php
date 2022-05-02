<?php

namespace App\Entity;

use App\Repository\HobbyRepository;
use App\Traits\TimeStrapTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @method setDesignatin(string $i)
 */
#[ORM\Entity(repositoryClass: HobbyRepository::class)]
#[ORM\HasLifecycleCallbacks()]
class Hobby
{
   // use TimeStrapTrait ;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 70)]
    private $designation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }
   /* public function __toString(): string
    {
        return $this->designation ;
    }*/
}
