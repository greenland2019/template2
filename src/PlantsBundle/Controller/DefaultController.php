<?php

namespace PlantsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlantsBundle\Entity\Personne;


class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->get("choix")=="connexion") {
            $user = $em->getRepository('PlantsBundle:Personne')->findOneBy(['email' => $request->get("email"), 'password' => $request->get("password")]);
            if ($user) {
                $sesion = $request->getSession();
                $sesion->set('login', $user->getPrenom());
                return $this->redirectToRoute('plants_homepage');

            }


            $this->addFlash("error", "Informations erronees");
            return $this->render('@Plants/template/index.html.twig');
        }
        return $this->render('@Plants/template/index.html.twig');
    }
}
