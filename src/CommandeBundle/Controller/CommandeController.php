<?php

namespace CommandeBundle\Controller;

use CommandeBundle\Entity\livraison;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use CommandeBundle\Entity\Commande;

class CommandeController extends Controller
{
    public function validerAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();


        if ($request->isXmlHttpRequest()) {
            if($request->getSession()->get('login'))
            {

            $personne=$em->getRepository("PlantsBundle:Personne")->findOneBy(['prenom'=>$request->getSession()->get('login')]);
            $paniers=$em->getRepository("CommandeBundle:Panier")->findBy(['user'=>$personne]);

            $panier = $em->getRepository('CommandeBundle:Panier')->total($personne);
            $per=$em->getRepository("PlantsBundle:Personne")->findOneBy(['zone'=>$request->get('ville')]);
            $commande = new Commande();
            $commande->setDate(new DateTime('now'));
            $commande->setPrixTotal($panier);
            $commande->setPersonne($personne);
                foreach ($paniers as $pan){
                    $produit=$em->getRepository("ProduitBundle:Produit")->findOneBy(['id'=>$pan->getProduitP()]);
                    if($pan->getQuantite()>$produit->getStock())
                    {
                        $response = new Response(json_encode(array('result' => 'Stock insuffisant')));

                        $response->headers->set('Content-Type', 'application/json');
                        return $response;
                    }

                    $produit->setStock(($produit->getStock())-($pan->getQuantite()));
                $commande->setProduits($commande->getProduits().$pan->getProduitP()->getNom().'*'.$pan->getQuantite().';');
                    $em->remove($pan);
                }
                $em->persist($commande);
                $em->flush();

            $livraison=new Livraison();
                $livraison->setEtat('en cours');
                $livraison->setCommande($commande);
                $livraison->setAddresse($request->get('addresse'));
                $livraison->setLivreur($per);

            $em->persist($livraison);
            $em->flush();
            }

            }


            $response = new Response(json_encode(array('result' => 'bien')));

            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }



    public function factureAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        if($request->getSession()->get('login'))
        {
            $personne=$em->getRepository("PlantsBundle:Personne")->findOneBy(['prenom'=>$request->getSession()->get('login')]);
            $paniers=$em->getRepository("CommandeBundle:Panier")->findBy(['user'=>$personne]);
            $panier = $em->getRepository('CommandeBundle:Panier')->total($personne);

        }
        return $this->render('@Plants/template/commande.html.twig',array("pan"=>$paniers,"prixtotal"=>$panier));
    }

}