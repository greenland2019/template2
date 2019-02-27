<?php

namespace CommandeBundle\Controller;

use mysql_xdevapi\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('@Commande/Default/index.html.twig');
    }

    public function shopAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $produits=$em->getRepository("ProduitBundle:Produit")->findAll();
        if($request->getSession()->get('login'))
    {
        $personne=$em->getRepository("PlantsBundle:Personne")->findOneBy(['prenom'=>$request->getSession()->get('login')]);
        return $this->render('@Plants/template/shop.html.twig',array("pro"=>$produits));
    }
        return $this->render('@Plants/template/shop.html.twig',array("pro"=>$produits));
    }
}
