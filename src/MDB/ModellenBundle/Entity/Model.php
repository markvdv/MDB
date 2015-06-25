<?php

namespace MDB\ModellenBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use MDB\UserBundle\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;
use FOS\UserBundle\Model\User as BaseUser;
/**
 * Model
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="MDB\ModellenBundle\Repository\ModelRepository")
 */
class Model extends BaseUser{
  //de ratings die een model krijgt
  /**
   *@ORM\OneToMany(targetEntity="MDB\RedacteurBundle\Entity\Rating",mappedBy="model",cascade={"all"})
   * @var type 
   */
  private $ratings;
  function getRatings() {
    return $this->ratings;
  }

  function setRatings($ratings) {
    $this->ratings = $ratings;
    return $this;
  }
  public function addRating($rating) {
    $this->ratings[]=$rating;
  }
  public function removeRating($rating){
    foreach ($this->ratings as $key => $value){
      if ($value== $rating){
        unset ($this->ratings[$key]);
      }
    }
  }
  public function getTotaalRating() {
    $count= count($this->ratings);
    $total=0;
    foreach ($this->ratings as $value){
      $total+=$value->getWaarde();
    }
    if($count>0){
      $total=$total/$count;
    }
    return $total;
  }
  /**
   * @var integer
   *
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  protected $id;

  /**
   * @var string
   * @Assert\NotBlank()
   * @ORM\Column(name="gsm", type="string", length=255)
   */
  private $gsm;

  /**
   * @ORM\ManyToOne(targetEntity="Adres",cascade={"all"})
   */
  private $adres = null;

  public function getAdres() {
    return $this->adres;
  }

  public function setAdres($adres) {
    $this->adres = $adres;
    return $this;
  }

  /**
   * @var string
   *
   * @ORM\Column(name="website", type="string", length=255)
   */
  private $website;

  /**
   * @var DateTime
   *@Assert\NotBlank()
   * @ORM\Column(name="geboorteDatum", type="datetime")
   */
  private $geboorteDatum;

  /**
   * @var integer
   *@Assert\NotBlank()
   * @ORM\Column(name="lengte", type="integer")
   */
  private $lengte;

  /**
   * @var integer
   *@Assert\NotBlank()
   * @ORM\Column(name="gewicht", type="integer")
   */
  private $gewicht;

  /**
   * @ORM\ManyToOne(targetEntity="HaarKleur",inversedBy="model")
   * @var type 
   * @Assert\NotBlank()
   */
  private $haarKleur = null;

  public function getHaarKleur() {
    return $this->haarKleur;
  }

  public function setHaarKleur($haarKleur) {
    $this->haarKleur = $haarKleur;
    return $this;
  }

  /**
   * @ORM\ManyToOne(targetEntity="OogKleur",inversedBy="model")
   * @var type 
   * @Assert\NotBlank()
   */
  private $oogKleur = null;

  public function getOogKleur() {
    return $this->oogKleur;
  }

  public function setOogKleur($oogKleur) {
    $this->oogKleur = $oogKleur;
    return $this;
  }

  /**
   * @var integer
   *@Assert\NotBlank()
   * @ORM\Column(name="confectieMaat", type="integer")
   */
  private $confectieMaat;

  /**
   * @var integer
   *@Assert\NotBlank()
   * @ORM\Column(name="cupMaat", type="integer")
   */
  private $cupMaat;

  /**
   * @var integer
   *@Assert\NotBlank()
   * @ORM\Column(name="borstOmtrek", type="integer")
   */
  private $borstOmtrek;

  /**
   * @var integer
   *@Assert\NotBlank()
   * @ORM\Column(name="taille", type="integer")
   */
  private $taille;

  /**
   * @var integer
   *@Assert\NotBlank()
   * @ORM\Column(name="heup", type="integer")
   */
  private $heup;

  /**
   * @var integer
   *@Assert\NotBlank()
   * @ORM\Column(name="schoenMaat", type="integer")
   */
  private $schoenMaat;

  /**
   * @var boolean
   *
   * @ORM\Column(name="fashion", type="boolean")
   */
  private $fashion;

  /**
   * @var boolean
   *
   * @ORM\Column(name="lingerie", type="boolean")
   */
  private $lingerie;

  /**
   * @var boolean
   *
   * @ORM\Column(name="badKledij", type="boolean")
   */
  private $badKledij;

  /**
   * @var boolean
   *
   * @ORM\Column(name="glamour", type="boolean")
   */
  private $glamour;

  /**
   * @var boolean
   *
   * @ORM\Column(name="topLess", type="boolean")
   */
  private $topLess;

  /**
   * @var boolean
   *
   * @ORM\Column(name="bedektTopless", type="boolean")
   */
  private $bedektTopless;

  /**
   * @var boolean
   *
   * @ORM\Column(name="naakt", type="boolean")
   */
  private $naakt;

  /**
   * @var boolean
   *
   * @ORM\Column(name="onherkenbaarNaakt", type="boolean")
   */
  private $onherkenbaarNaakt;

  /**
   * @var boolean
   *
   * @ORM\Column(name="bedektNaakt", type="boolean")
   */
  private $bedektNaakt;

  /**
   * @var boolean
   *
   * @ORM\Column(name="artistiekNaakt", type="boolean")
   */
  private $artistiekNaakt;

  /**
   * @var boolean
   *
   * @ORM\Column(name="bodyPaint", type="boolean")
   */
  private $bodyPaint;

  /**
   * @var boolean
   *
   * @ORM\Column(name="che", type="boolean")
   */
  private $che;

  /**
   * @var boolean
   *
   * @ORM\Column(name="pmagazine", type="boolean")
   */
  private $pmagazine;

  /**
   * @var boolean
   *
   * @ORM\Column(name="clint", type="boolean")
   */
  private $clint;

  /**
   * @var boolean
   *
   * @ORM\Column(name="menzo", type="boolean")
   */
  private $menzo;

  /**
   * @var boolean
   *
   * @ORM\Column(name="andereMagazines", type="boolean")
   */
  private $andereMagazines;

  /**
   * @var string
   *
   * @ORM\Column(name="andereMagazinesOmschrijving", type="text",length=255,nullable=true)
   */
  private $andereMagazinesOmschrijving;

  /**
   * @var string
   *
   * @ORM\Column(name="ervaring", type="boolean")
   */
  private $ervaring;

  /**
   * @var boolean
   *
   * @ORM\Column(name="ervaringOmschrijving", type="string",length=255,nullable=true)
   */
  private $ervaringOmschrijving;

  /**
   * Get id
   *
   * @return integer 
   */
  public function getId() {
    return $this->id;
  }

  /**
   * Set naam
   *
   * @param string $naam
   * @return Model
   */
  public function setNaam($naam) {
    $this->naam = $naam;

    return $this;
  }

  /**
   * Get naam
   *
   * @return string 
   */
  public function getNaam() {
    return $this->naam;
  }

  /**
   * Set voornaam
   *
   * @param string $voornaam
   * @return Model
   */
  public function setVoornaam($voornaam) {
    $this->voornaam = $voornaam;

    return $this;
  }

  /**
   * Get voornaam
   *
   * @return string 
   */
  public function getVoornaam() {
    return $this->voornaam;
  }

  /**
   * Set gsm
   *
   * @param string $gsm
   * @return Model
   */
  public function setGsm($gsm) {
    $this->gsm = $gsm;

    return $this;
  }

  /**
   * Get gsm
   *
   * @return string 
   */
  public function getGsm() {
    return $this->gsm;
  }

  /**
   * Set websiteUrl
   *
   * @param string $websiteUrl
   * @return Model
   */
  public function setWebsite($website) {
    $this->website = $website;

    return $this;
  }

  /**
   * Get websiteUrl
   *
   * @return string 
   */
  public function getWebsite() {
    return $this->website;
  }

  /**
   * Set geboorteDatum
   *
   * @param DateTime $geboorteDatum
   * @return Model
   */
  public function setGeboorteDatum($geboorteDatum) {
    $this->geboorteDatum = $geboorteDatum;

    return $this;
  }

  /**
   * Get geboorteDatum
   *
   * @return DateTime 
   */
  public function getGeboorteDatum() {
    return $this->geboorteDatum;
  }

  /**
   * Set lengte
   *
   * @param integer $lengte
   * @return Model
   */
  public function setLengte($lengte) {
    $this->lengte = $lengte;

    return $this;
  }

  /**
   * Get lengte
   *
   * @return integer 
   */
  public function getLengte() {
    return $this->lengte;
  }

  /**
   * Set gewicht
   *
   * @param integer $gewicht
   * @return Model
   */
  public function setGewicht($gewicht) {
    $this->gewicht = $gewicht;

    return $this;
  }

  /**
   * Get gewicht
   *
   * @return integer 
   */
  public function getGewicht() {
    return $this->gewicht;
  }

  /**
   * Set confectieMaat
   *
   * @param integer $confectieMaat
   * @return Model
   */
  public function setConfectieMaat($confectieMaat) {
    $this->confectieMaat = $confectieMaat;

    return $this;
  }

  /**
   * Get confectieMaat
   *
   * @return integer 
   */
  public function getConfectieMaat() {
    return $this->confectieMaat;
  }

  /**
   * Set cupMaat
   *
   * @param integer $cupMaat
   * @return Model
   */
  public function setCupMaat($cupMaat) {
    $this->cupMaat = $cupMaat;

    return $this;
  }

  /**
   * Get cupMaat
   *
   * @return integer 
   */
  public function getCupMaat() {
    return $this->cupMaat;
  }

  /**
   * Set borstOmtrek
   *
   * @param integer $borstOmtrek
   * @return Model
   */
  public function setBorstOmtrek($borstOmtrek) {
    $this->borstOmtrek = $borstOmtrek;

    return $this;
  }

  /**
   * Get borstOmtrek
   *
   * @return integer 
   */
  public function getBorstOmtrek() {
    return $this->borstOmtrek;
  }

  /**
   * Set tailleMaat
   *
   * @param integer $tailleMaat
   * @return Model
   */
  public function setTaille($taille) {
    $this->taille = $taille;

    return $this;
  }

  /**
   * Get tailleMaat
   *
   * @return integer 
   */
  public function getTaille() {
    return $this->taille;
  }

  /**
   * Set heupMaat
   *
   * @param integer $heupMaat
   * @return Model
   */
  public function setHeup($heup) {
    $this->heup = $heup;

    return $this;
  }

  /**
   * Get heupMaat
   *
   * @return integer 
   */
  public function getHeup() {
    return $this->heup;
  }

  /**
   * Set schoenMaat
   *
   * @param integer $schoenMaat
   * @return Model
   */
  public function setSchoenMaat($schoenMaat) {
    $this->schoenMaat = $schoenMaat;

    return $this;
  }

  /**
   * Get schoenMaat
   *
   * @return integer 
   */
  public function getSchoenMaat() {
    return $this->schoenMaat;
  }

  /**
   * Set fashion
   *
   * @param boolean $fashion
   * @return Model
   */
  public function setFashion($fashion) {
    $this->fashion = $fashion;

    return $this;
  }

  /**
   * Get fashion
   *
   * @return boolean 
   */
  public function getFashion() {
    return $this->fashion;
  }

  /**
   * Set lingerie
   *
   * @param boolean $lingerie
   * @return Model
   */
  public function setLingerie($lingerie) {
    $this->lingerie = $lingerie;

    return $this;
  }

  /**
   * Get lingerie
   *
   * @return boolean 
   */
  public function getLingerie() {
    return $this->lingerie;
  }

  /**
   * Set badKledij
   *
   * @param boolean $badKledij
   * @return Model
   */
  public function setBadKledij($badKledij) {
    $this->badKledij = $badKledij;

    return $this;
  }

  /**
   * Get badKledij
   *
   * @return boolean 
   */
  public function getBadKledij() {
    return $this->badKledij;
  }

  /**
   * Set glamour
   *
   * @param boolean $glamour
   * @return Model
   */
  public function setGlamour($glamour) {
    $this->glamour = $glamour;

    return $this;
  }

  /**
   * Get glamour
   *
   * @return boolean 
   */
  public function getGlamour() {
    return $this->glamour;
  }

  /**
   * Set topLess
   *
   * @param boolean $topLess
   * @return Model
   */
  public function setTopLess($topLess) {
    $this->topLess = $topLess;

    return $this;
  }

  /**
   * Get topLess
   *
   * @return boolean 
   */
  public function getTopLess() {
    return $this->topLess;
  }

  /**
   * Set bedektTopless
   *
   * @param boolean $bedektTopless
   * @return Model
   */
  public function setBedektTopless($bedektTopless) {
    $this->bedektTopless = $bedektTopless;

    return $this;
  }

  /**
   * Get bedektTopless
   *
   * @return boolean 
   */
  public function getBedektTopless() {
    return $this->bedektTopless;
  }

  /**
   * Set naakt
   *
   * @param boolean $naakt
   * @return Model
   */
  public function setNaakt($naakt) {
    $this->naakt = $naakt;

    return $this;
  }

  /**
   * Get naakt
   *
   * @return boolean 
   */
  public function getNaakt() {
    return $this->naakt;
  }

  /**
   * Set onherkenbaarNaakt
   *
   * @param boolean $onherkenbaarNaakt
   * @return Model
   */
  public function setOnherkenbaarNaakt($onherkenbaarNaakt) {
    $this->onherkenbaarNaakt = $onherkenbaarNaakt;

    return $this;
  }

  /**
   * Get onherkenbaarNaakt
   *
   * @return boolean 
   */
  public function getOnherkenbaarNaakt() {
    return $this->onherkenbaarNaakt;
  }

  /**
   * Set bedektNaakt
   *
   * @param boolean $bedektNaakt
   * @return Model
   */
  public function setBedektNaakt($bedektNaakt) {
    $this->bedektNaakt = $bedektNaakt;

    return $this;
  }

  /**
   * Get bedektNaakt
   *
   * @return boolean 
   */
  public function getBedektNaakt() {
    return $this->bedektNaakt;
  }

  /**
   * Set artistiekNaakt
   *
   * @param boolean $artistiekNaakt
   * @return Model
   */
  public function setArtistiekNaakt($artistiekNaakt) {
    $this->artistiekNaakt = $artistiekNaakt;

    return $this;
  }

  /**
   * Get artistiekNaakt
   *
   * @return boolean 
   */
  public function getArtistiekNaakt() {
    return $this->artistiekNaakt;
  }

  /**
   * Set bodyPaint
   *
   * @param boolean $bodyPaint
   * @return Model
   */
  public function setBodyPaint($bodyPaint) {
    $this->bodyPaint = $bodyPaint;

    return $this;
  }

  /**
   * Get bodyPaint
   *
   * @return boolean 
   */
  public function getBodyPaint() {
    return $this->bodyPaint;
  }

  /**
   * Set ervaring
   *
   * @param string $ervaring
   * @return Model
   */
  public function setErvaring($ervaring) {
    $this->ervaring = $ervaring;

    return $this;
  }

  /**
   * Get ervaring
   *
   * @return string 
   */
  public function getErvaring() {
    return $this->ervaring;
  }

  /**
   * Set omschrijvingErvaring
   *
   * @param string $ervaringOmschrijving
   * @return Model
   */
  public function setErvaringOmschrijving($ervaringOmschrijving) {
    $this->ervaringOmschrijving = $ervaringOmschrijving;

    return $this;
  }

  /**
   * Get omschrijvingErvaring
   *
   * @return string 
   */
  public function getErvaringOmschrijving() {
    return $this->ervaringOmschrijving;
  }

  function getChe() {
    return $this->che;
  }

  function getPmagazine() {
    return $this->pmagazine;
  }

  function getClint() {
    return $this->clint;
  }

  function getMenzo() {
    return $this->menzo;
  }

  function getAndereMagazines() {
    return $this->andereMagazines;
  }

  function getAndereMagazinesOmschrijving() {
    return $this->andereMagazinesOmschrijving;
  }

  function setChe($che) {
    $this->che = $che;
    return $this;
  }

  function setPmagazine($pmagazine) {
    $this->pmagazine = $pmagazine;
    return $this;
  }

  function setClint($clint) {
    $this->clint = $clint;
    return $this;
  }

  function setMenzo($menzo) {
    $this->menzo = $menzo;
    return $this;
  }

  function setAndereMagazines($andereMagazines) {
    $this->andereMagazines = $andereMagazines;
    return $this;
  }

  function setAndereMagazinesOmschrijving($andereMagazinesOmschrijving) {
    $this->andereMagazinesOmschrijving = $andereMagazinesOmschrijving;
    return $this;
  }

  /**
   * @ORM\OneToMany(targetEntity="Foto",mappedBy="model",cascade={"all"})
   * @var type 
   */
  private $fotos;

  public function getFotos() {
    return $this->fotos;
  }

  public function setFotos($fotos) {
    $this->fotos = $fotos;
    return $this;
  }

  public function removeFoto() {
    
  }

  public function addFoto($foto) {
    $this->fotos[] = $foto;
    return $this;
  }

  public function __construct() {
    parent::__construct();
    $this->roles[]="ROLE_MODEL";
    $this->ratings = new ArrayCollection();
    $this->fotos = new ArrayCollection();
  }

}
