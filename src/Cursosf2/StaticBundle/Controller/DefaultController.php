<?php

namespace Cursosf2\StaticBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{

    public function homepageAction()
    {
        //return new \Symfony\Component\HttpFoundation\Response('Portada del Curso de Symfony2');
        return $this->render('Cursosf2StaticBundle:Default:homepage.html.twig');
    }
}
