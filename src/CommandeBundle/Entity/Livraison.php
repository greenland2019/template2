<?php

namespace CommandeBundle\Entity;
use  Doctrine\ORM\Mapping as ORM;
/**
 * Livraison
 *@ORM\Entity(repositoryClass="CommandeBundle\Repository\LivraisonRepository")
 */
class Livraison
{
    /**
     *@var int
     *@ORM\Id
     *@ORM\Column(type="integer")
     *@ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="PlantsBundle\Entity\Personne")
     */
    private $livreur;
    /**
     * @ORM\OneToOne(targetEntity="Commande")
     */
    private $commande;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $addresse;
    /**
     * @var string
     * @ORM\Column(type="text")
     */
    private $etat;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getLivreur()
    {
        return $this->livreur;
    }

    /**
     * @param mixed $livreur
     */
    public function setLivreur($livreur)
    {
        $this->livreur = $livreur;
    }

    /**
     * @return mixed
     */
    public function getCommande()
    {
        return $this->commande;
    }

    /**
     * @param mixed $commande
     */
    public function setCommande($commande)
    {
        $this->commande = $commande;
    }

    /**
     * @return string
     */
    public function getAddresse()
    {
        return $this->addresse;
    }

    /**
     * @param string $addresse
     */
    public function setAddresse($addresse)
    {
        $this->addresse = $addresse;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
    }



}

