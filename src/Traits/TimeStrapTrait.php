<?php

namespace App\Traits;

trait TimeStrapTrait
{ /**
    *@ORM\Column(type: 'datetime', nullable: true)
   */
    private $createdAt;

   /**
    *@ORM\Column(type: 'datetime', nullable: true)]
    */
    private $updatedAt;
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function onPrePersist(){
        $this->createdAt = new \DateTime();
        $this->updatedAt=new \DateTime();


    }

    /**
     * @ORM\PreUpdate()
     */
    public function onPreUpdate(){
        $this->updatedAt=new \DateTime();
    }
}
