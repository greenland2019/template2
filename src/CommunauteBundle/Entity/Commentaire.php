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
class Commentaire
{
    /**
     * @ORM\GeneratedValue
     * @ORM\Id
     * @ORM\Column(type="integer")
     */

    private $id;
    /**
     * @ORM\Column(type="text")
     */
    private $contenu;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_post;

    /**
     * @ORM\ManyToOne(targetEntity="PlantsBundle\Entity\Personne")
     */
    private $editeur;

    /**
     * @ORM\ManyToOne(targetEntity="Theme")
     */
    private $theme;

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
     * @param mixed $theme
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
    }

    /**
     * @return mixed
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @return mixed
     */
    public function getContenu()
    {
        return $this->contenu;
    }

    /**
     * @return mixed
     */
    public function getDatePost()
    {
        return $this->date_post;
    }

    /**
     * @return mixed
     */
    public function getEditeur()
    {
        return $this->editeur;
    }

    /**
     * @param mixed $contenu
     */
    public function setContenu($contenu)
    {
        $this->contenu = $contenu;
    }

    /**
     * @param mixed $date_post
     */
    public function setDatePost($date_post)
    {
        $this->date_post = $date_post;
    }

    /**
     * @param mixed $editeur
     */
    public function setEditeur($editeur)
    {
        $this->editeur = $editeur;
    }

}