<?php

namespace Felicelli\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    protected $_dir = '/Users/fellw9/myphotos';

    /**
     * @Route("/")
     * @Template("FelicelliGalleryBundle:Default:index.html.twig")
     */
    public function indexAction()
    {
        // get list of albums
        $albums = $this->getAllAlbums();

        // get list of images
        $images = $this->getAllImages($this->_dir);

        return array('albums' => $albums);
    }
    /**
     * @Route("/dir/{$dir}")
     * @Template("FelicelliGalleryBundle:Default:index.html.twig")
     */
    public function indexAction($dir)
    {
        // get list of albums

        // get list of images

        return array('albums' => $albums);
    }

    private function getAllAlbums()
    {
        $directories = array();
        $files = glob($this->_dir . "/*");
        foreach($files as $file) {
            if(is_dir($file)) {
                array_unshift($directories, array(
                    'name' => basename($file),
                    'count' => count($this->getAllImages(basename($file))),
                ));
            }
        }

        return $directories;
    }

    private function getAllImages($dir)
    {
        $validExtensions = array(
            'jpg', 'png', 'gif',
        );

        $files = array();
        $fileList = glob($this->_dir . '/' . $dir . "/*.*");
        foreach($fileList as $file) {
            if(is_file($file) && in_array(strtolower(substr($file, -3)), $validExtensions)) {
                array_unshift($files, $dir . '/' . basename($file));
            }
        }

        return $files;
    }
}
