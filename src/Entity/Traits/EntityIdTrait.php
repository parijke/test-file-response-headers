<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV4Generator;
use Symfony\Bridge\Doctrine\IdGenerator\UuidV6Generator;

trait EntityIdTrait
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true, options={"fixed" = true})
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class=UuidV6Generator::class)
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }


}
