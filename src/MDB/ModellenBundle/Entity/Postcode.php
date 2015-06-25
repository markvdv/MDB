<?php

namespace MDB\ModellenBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Postcode
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MDB\ModellenBundle\Repository\PostcodeRepository")
 */
class Postcode
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
     * @ORM\Column(name="postcode", type="string", length=255,nullable=true)
     */
    private $postcode;


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
     * Set postcode
     *
     * @param string $postcode
     * @return Postcode
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;

        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }
/**
 *@ORM\OneToMany(targetEntity="Plaatsnaam",mappedBy="postcode",cascade={"persist"})
 * @return type  
 */
    private $plaatsnaam=null;

    function getPlaatsnaam() {
      return $this->plaatsnaam;
    }

    function setPlaatsnaam($plaatsnaam) {
      $this->plaatsnaam = $plaatsnaam;
    }



}
