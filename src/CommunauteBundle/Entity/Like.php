<?php
/**
 * Created by PhpStorm.
 * User: HP
 * Date: 13/02/2019
 * Time: 17:52
 */

namespace CommunauteBundle\Entity;
use PlantsBundle\Entity\Personne;

use  Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */

class Like
{
    /**
     * @ORM\Column(type="datetime")
     */
    private $date_like;

    /**
     * @ORM\ManyToOne(targetEntity="PlantsBundle\Entity\Personne")
     * @ORM\Id
     */

    private $liker;

    /**
     * @ORM\ManyToOne(targetEntity="Commentaire")
     * @ORM\Id
     */

    private $commenaire;

    /**
     * @return mixed
     */
    public function getCommenaire()
    {
        return $this->commenaire;
    }

    /**
     * @return mixed
     */
    public function getDateLike()
    {
        return $this->date_like;
    }

    /**
     * @return mixed
     */
    public function getLiker()
    {
        return $this->liker;
    }

    /**
     * @param mixed $commenaire
     */
    public function setCommenaire($commenaire)
    {
        $this->commenaire = $commenaire;
    }

    /**
     * @param mixed $date_like
     */
    public function setDateLike($date_like)
    {
        $this->date_like = $date_like;
    }

    /**
     * @param mixed $liker
     */
    public function setLiker($liker)
    {
        $this->liker = $liker;
    }
}