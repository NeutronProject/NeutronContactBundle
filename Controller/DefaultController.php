<?php

namespace Neutron\Plugin\ContactBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('NeutronContactBundle:Default:index.html.twig', array('name' => $name));
    }
}
