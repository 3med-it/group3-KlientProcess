<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

/** @ORM\Entity */
class CustomerProcess
{
    /** @ORM\Id @ORM\GeneratedValue @ORM\Column(type="integer") */
    private int $id;

    /** @ORM\Column(type="string", length=50) */
    private string $state = 'offen';

    /** @ORM\Column(type="string", length=100, nullable=true) */
    private ?string $email = null;

    /** @ORM\Column(type="string", length=20, nullable=true) */
    private ?string $phone = null;

    // ... Getter/Setter für alle Felder ...
}
