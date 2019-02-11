<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @Route("/", name="homeRoot")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user' => isset($_SESSION['user'])?$_SESSION['user']:null,
            'account' => isset($_SESSION['account'])?$_SESSION['account']:null,
        ]);
    }
}
