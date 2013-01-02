<?php

namespace Felicelli\GalleryBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

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

        return array(
            'albums' => $albums,
            'images' => $images,
        );
    }

    /**
     * @Route("/{dir}")
     * @Template("FelicelliGalleryBundle:Default:index.html.twig")
     */
    public function albumAction($dir)
    {
        // get list of albums
        $albums = $this->getAllAlbums();

        // get list of images
        $images = $this->getAllImages($this->_dir . '/' . $dir);

        return array(
            'albums' => $albums,
            'images' => $images,
        );
    }

    /**
     * @Route("/loadimage/{type}/{file}")
     */
    public function imageAction($type, $file)
    {
        header('ContentType: image/jpg');
        $file = str_replace(':', '/', $file);
        $img = new \Imagick($file);

        if($type == 'thumb') {
            $img->thumbnailImage(100, 100);
        } else {
            $img->thumbnailImage(640, 480, true, true);
        }

        echo $img;
        return new Response();
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
        $fileList = glob($dir . "/*.*");
        foreach($fileList as $file) {
            if(is_file($file) && in_array(strtolower(substr($file, -3)), $validExtensions)) {
                array_unshift($files, str_replace('/', ':', $file));
            }
        }

        return $files;
    }
}
