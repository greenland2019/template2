<?php

namespace CommandeBundle\Repository;

/**
 * PanierRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PanierRepository extends \Doctrine\ORM\EntityRepository
{
    public function nb_produit($id)
    {
        $query = $this->getEntityManager()->createQuery('SELECT COUNT(p.id)
FROM CommandeBundle:Panier p where p.user=:id')->setParameter('id',$id);
        $result = $query->getSingleScalarResult();
        return $result;
    }
    public function total($id)
    {
        return $this->getEntityManager()
            ->createQuery("SELECT sum(pr.prix*p.quantite) as prixtotal  FROM CommandeBundle:Panier p inner join ProduitBundle:produit pr with p.produitP=pr where p.user=:id")->setParameter('id',$id)->getSingleScalarResult();

    }
}