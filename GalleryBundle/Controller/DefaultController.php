<?php

namespace Felicelli\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template("FelicelliGalleryBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        return array('name' => 'Testing');
    }
}
