<?php

namespace PlantsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use PlantsBundle\Entity\Personne;


class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        if ($request->isXmlHttpRequest()) {

                $user = $em->getRepository('PlantsBundle:Personne')->findOneBy(['email' => $request->get("email"), 'password' => $request->get("password")]);
                if ($user) {
                    $sesion = $request->getSession();
                    $sesion->set('login', $user->getPrenom());

                    $response = new Response(json_encode(array(
                        'result' => 'success',
                        'login' =>  $user->getPrenom()
                    )));
                    $response->headers->set('Content-Type', 'application/json');

                    return $response;
                }

            $response = new Response(json_encode(array(
                'result' => 'fail'

            )));
            $response->headers->set('Content-Type', 'application/json');

            return $response;

                //$this->addFlash("error", "Informations erronees");
                //die('Informations erronees');


        }
        return $this->render('@Plants/template/index.html.twig');
    }
}
