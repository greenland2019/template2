<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Snappy\Pdf;
use CommandeBundle\Repository\PanierRepository;


use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{

    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if($request->getSession()->get('login'))
        {
            $personne=$em->getRepository("PlantsBundle:Personne")->findOneBy(['prenom'=>$request->getSession()->get('login')]);
            $paniers=$em->getRepository("CommandeBundle:Panier")->findBy(['user'=>$personne]);
            $panier = $em->getRepository('CommandeBundle:Panier')->total($personne);
        }
        $snappy= $this->get('knp_snappy.pdf');
        $html=$this->renderView('@Plants/template/about.html.twig',array("pan"=>$paniers,"prixtot"=>$panier));
        $filename='myFirstSnappyPDF';
        return new Response(
            $snappy->getOutputFromHtml($html),
            200,
            array(
                'Content-Type'          =>'application/pdf',
                'Content-Disposition'   =>'inline; filename="'.$filename.'.pdf"'
            )
        );
    }
}
