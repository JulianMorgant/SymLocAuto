<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Tests\Extension\DependencyInjection\TestTypeExtension;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;

class LoginController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request,UserRepository $repoUser)
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->add("pseudo",TextType::class)
            ->add("psw",PasswordType::class)
            ->add('submit',SubmitType::class,['label'=>'Connexion'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $testUser = $repoUser->findByPseudo($user);
            if ($testUser != null && $testUser->getPsw() == $user->getPsw()) {
                //OK login
                $_SESSION['user'] = $testUser->getPseudo();
                $_SESSION['account'] = $testUser->getAccount();
            }else{
                //KO login

            }
            return $this->redirectToRoute('home');
        }

        $forms[0]=$form->createView();
        return $this->render('login/index.html.twig',[
            'forms' => $forms,
        ]);

        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
            'user' => isset($_SESSION['user'])?$_SESSION['user']:null,
            'account' => isset($_SESSION['account'])?$_SESSION['account']:null,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */

    public function logout(){
        unset($_SESSION['user']);
        unset($_SESSION['account']);

    }
}
