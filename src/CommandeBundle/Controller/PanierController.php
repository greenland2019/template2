<?php

namespace CommandeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateTime;
use CommandeBundle\Entity\Panier;
use CommandeBundle\Repository\PanierRepository;

class PanierController extends Controller
{
    public function addToPanierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();



        if ($request->isXmlHttpRequest()) {
            $produit = $em->getRepository('ProduitBundle:Produit')->find($request->get('id'));
            $personne = $em->getRepository('PlantsBundle:Personne')->findOneBy(['prenom'=>$request->get('personne_id')]);
            $pan= $em->getRepository('CommandeBundle:Panier')->findOneBy(['user'=>$personne,'produitP'=>$produit]);
                 if(!$pan)
                 {
                 $panier = new Panier();
                 $panier->setDateP(new DateTime('now'));

                 $panier->setUser($personne);
                 $panier->setProduitP($produit);
                 $panier->setQuantite($request->get('qte'));
                 $em->persist($panier);
                 $em->flush();}
                 else{
                     $pan->setQuantite($pan->getQuantite('qte')+$request->get('qte'));
                     $em->persist($pan);
                     $em->flush();

                 }


        }


        $response = new Response(json_encode(array('result' => 'bien')));

        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


    public function afficherPanierAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->getSession()->get('login'))
        {
            $personne=$em->getRepository("PlantsBundle:Personne")->findOneBy(['prenom'=>$request->getSession()->get('login')]);
            $paniers=$em->getRepository("CommandeBundle:Panier")->findBy(['user'=>$personne]);
            $locationRepo = $this->getDoctrine()->getEntityManager()->getRepository('CommandeBundle:Panier');
            $nb = $locationRepo-> nb_produit($personne);
            $panier = $em->getRepository('CommandeBundle:Panier')->total($personne);

        }
        return $this->render('@Plants/template/checkout.html.twig',array("pan"=>$paniers,"nb"=>$nb,"total"=>$panier));
    }



    public function modifierPaniermoinAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()) {

           $paniers = $em->getRepository("CommandeBundle:Panier")->find($request->get('id'));;
            $paniers->setQuantite($paniers->getQuantite()-1);
            $em->persist($paniers);
            $em->flush();
            $response = new Response(json_encode(array('result' => 'bien','newprix'=>$paniers->getProduitP()->getPrix()*$paniers->getQuantite())));

            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

    }


    public function modifierPanierplusAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()) {

            $paniers = $em->getRepository("CommandeBundle:Panier")->find($request->get('id'));;
            $paniers->setQuantite($paniers->getQuantite() + 1);
            $em->persist($paniers);
            $em->flush();
            $response = new Response(json_encode(array('result' => 'bien','newprix'=>$paniers->getProduitP()->getPrix()*$paniers->getQuantite())));

            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }

    }





    public function supprimerAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->isXmlHttpRequest()) {

            $paniers = $em->getRepository("CommandeBundle:Panier")->find($request->get('id'));;

            $em->remove($paniers);
            $em->flush();
            $response = new Response(json_encode(array('result' => 'bien','newprix'=>$paniers->getProduitP()->getPrix()*$paniers->getQuantite())));

            $response->headers->set('Content-Type', 'application/json');
            return $response;
        }
    }

}
