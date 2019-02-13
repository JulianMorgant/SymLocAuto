<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\UserRepository;
use App\Services\PaginationService;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

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
    public function index($page = 1, PaginationService $paginationService)
    {
        $paginationService->setEntityClass(Annonce::class);
        return $this->render('home/index.html.twig', [
            'listAnnonces' => $paginationService->getData($page) ?? null,
            'nbDePages' => $paginationService->getNbDePages() ?? 1,
            'pageCourante' => $page,
            'controller_name' => 'HomeController',
            'user' => isset($_SESSION['user']) ? $_SESSION['user'] : null,
            'account' => isset($_SESSION['account']) ? $_SESSION['account'] : null,
        ]);
    }

    /**
     * @Route("/newAnnonce", name="newAnnonce")
     * @param Request $request
     * @param UserRepository $repoUser
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function newAnnonce(Request $request, UserRepository $repoUser, ObjectManager $manager)
    {
       if (isset($_SESSION['userId'])) {

            $newAnnonce = new Annonce();
            $form = $this->createFormBuilder($newAnnonce)
                ->add('title', TextType::class, ['label' => 'Titre'])
                ->add('content', TextareaType::class, ['label' => 'Description'])
                ->add('image', TextType::class, ['label' => 'Url de l image'])
                ->add('save', SubmitType::class, ['label' => 'valider'])
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $newAnnonce = $form->getData();

                $newAnnonce
                    ->setCreateat(new \DateTime())
                    ->setModifyat(new \DateTime());
                var_dump($newAnnonce);
                $user = $repoUser->findOneById($_SESSION['userId']);
                $user->addAnnonce($newAnnonce);
                $manager->persist($newAnnonce);
                $manager->flush();
                return $this->redirectToRoute('home'); //TODO faire mieux
            }
            $forms[0] = $form->createView();

            return $this->render('home/view.html.twig', [
                'forms' => $forms,
                'controller_name' => 'HomeController',
                'user' => isset($_SESSION['user']) ? $_SESSION['user'] : null,
                'account' => isset($_SESSION['account']) ? $_SESSION['account'] : null,
            ]);
        } else {
           //pas connecté donc pas d'annonce a faire
           return $this->redirectToRoute('home'); //TODO faire mieux
       }
    }
}
