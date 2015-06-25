<?php

namespace MDB\ModellenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kleur
 *
 * @ORM\MappedSuperClass
 */
class Kleur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="kleurNaam", type="string", length=255)
     */
    private $kleurNaam;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set kleurNaam
     *
     * @param string $kleurNaam
     * @return Kleur
     */
    public function setKleurNaam($kleurNaam)
    {
        $this->kleurNaam = $kleurNaam;

        return $this;
    }

    /**
     * Get kleurNaam
     *
     * @return string 
     */
    public function getKleurNaam()
    {
        return $this->kleurNaam;
    }
   
}
