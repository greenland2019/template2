<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 13/02/2019
 * Time: 17:47
 */

namespace CommunauteBundle\Entity;
use PlantsBundle\Entity\Personne;

use  Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Theme
{

    /**
     * @ORM\GeneratedValue
     * @ORM\Id
     * @ORM\Column(type="integer")
     */

    private $id;
    /**
     * @ORM\Column(type="string",length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_creation;

    /**
     * @ORM\Column(type="integer")
     */
    private $visites;

    /**
     * @ORM\ManyToOne(targetEntity="PlantsBundle\Entity\Personne")
     */

    private $createur;

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $visites
     */
    public function setVisites($visites)
    {
        $this->visites = $visites;
    }

    /**
     * @param mixed $date_creation
     */
    public function setDateCreation($date_creation)
    {
        $this->date_creation = $date_creation;
    }

    /**
     * @return mixed
     */
    public function getVisites()
    {
        return $this->visites;
    }

    /**
     * @return mixed
     */
    public function getDateCreation()
    {
        return $this->date_creation;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $createur
     */
    public function setCreateur($createur)
    {
        $this->createur = $createur;
    }

    /**
     * @return mixed
     */
    public function getCreateur()
    {
        return $this->createur;
    }
}