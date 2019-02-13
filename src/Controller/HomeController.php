<?php

namespace App\Controller;

use App\Services\PaginationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @Route("/home/{page}", name="homePage")
     * @Route("/", name="homeRoot")
     * @param int $page
     * @param PaginationService $paginationService
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index($page = 1,PaginationService $paginationService)
    {

        $datatest = $paginationService->getInfo();
        var_dump($datatest);
        $limite = 5;
        $offset = $page * $limite;
 //       $nbTotalDePages = ceil(count($repo->findAll())/$limite);


 //       $articles = $repo->findBy([],[],$limite,$offset);


        return $this->render('home/index.html.twig', [
            'listArticles' => $articles ?? null,
            'nbDePages' => $nbTotalDePages ?? 1,
            'pageCourante' => $page,
            'controller_name' => 'HomeController',
            'user' => isset($_SESSION['user'])?$_SESSION['user']:null,
            'account' => isset($_SESSION['account'])?$_SESSION['account']:null,
        ]);
    }
}
