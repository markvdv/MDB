<?php

namespace MDB\ModellenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adres
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MDB\ModellenBundle\Repository\AdresRepository")
 */
class Adres
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
     * @ORM\Column(name="straatNaam", type="string", length=255,nullable=true)
     */
    private $straatnaam;

    /**
     * @var integer
     *
     * @ORM\Column(name="huisNummer", type="integer",nullable=true)
     */
    private $huisnummer;


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
     * Set straatNaam
     *
     * @param string $straatNaam
     * @return Adres
     */
    public function setStraatnaam($straatnaam)
    {
        $this->straatnaam = $straatnaam;

        return $this;
    }

    /**
     * Get straatNaam
     *
     * @return string 
     */
    public function getStraatnaam()
    {
        return $this->straatnaam;
    }

    /**
     * Set huisNummer
     *
     * @param integer $huisNummer
     * @return Adres
     */
    public function setHuisnummer($huisnummer)
    {
        $this->huisnummer = $huisnummer;

        return $this;
    }

    /**
     * Get huisNummer
     *
     * @return integer 
     */
    public function getHuisnummer()
    {
        return $this->huisnummer;
    }
    
    /**
     *@ORM\ManyToOne(targetEntity="Plaatsnaam",cascade="persist",inversedBy="adres")
     * @var type 
     */
    private $plaatsnaam=null;
    public function getPlaatsnaam() {
    return $this->plaatsnaam;
    }

    public function setPlaatsnaam($plaatsnaam) {
    $this->plaatsnaam= $plaatsnaam;
    return $this;
    }
}
