<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 19/02/2019
 * Time: 13:38
 */

namespace ProduitBundle\Entity;
use  Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */

class Categorie
{
    /**
     * @var integer
     * @ORM\GeneratedValue
     * @ORM\Id
     * @ORM\Column(type="integer")
     */

    private $id;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $nom;



    /**
     * @ORM\ManyToOne(targetEntity="PlantsBundle\Entity\Personne")
     */
    private $artisan;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

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
    public function getNom()
    {
        return $this->nom;
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
    public function getArtisan()
    {
        return $this->artisan;
    }

    /**
     * @param mixed $artisan
     */
    public function setArtisan($artisan)
    {
        $this->artisan = $artisan;
    }


}