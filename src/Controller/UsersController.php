<?php

namespace App\Controller;

use App\Entity\Consumer;
use App\Entity\User;
use App\Repository\ConsumerRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * Class LoginController
 * @package App\Controller
 */
class UsersController extends AbstractController
{

    /**
     * @Route("/login", name="login")
     */
    public function index()
    {
        return $this->render('users/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }

    /**
     * @Route("/login/{pseudo}", name="loginPseudo")
     * @param User $user
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function viewUser(User $user,Request $request,ObjectManager $manager)
    {
        $forms=[];
        $form = $this->createFormBuilder($user) //TODO
        ->add('pseudo',TextType::class,[
            'required'   => true,
            'empty_data' => 'pseudo'],[
            'disable'   => true,
        ])
            ->add('mail',EmailType::class,[
                'required'   => true,
                'empty_data' => 'mail'],[
                'disable'   => false,
            ])
            ->add('account',TextType::class)
            ->add('createAt',DateType::class,[
                'required'   => true,
                'empty_data' => ''],[
                'disable'   => false,
            ])
            ->add('modifyAt',DateType::class,[
                'required'   => true,
                'empty_data' => ''],[
                'disable'   => false,
            ])
            ->add('save',SubmitType::class,['label'=>'valider'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();
            $user ->setModifyat(new \DateTime());
            $manager->persist($user);
            $manager->flush();
            return $this->redirectToRoute('login'); //TODO
        }

        array_push($forms,$form->createView());

        // ****************clients************

        $consumers = $user->getConsumers();

      //  if (count($consumers) > 0) {
            foreach ($consumers as $consumer) {
                $form = $this->createFormBuilder($consumer)
                    ->add('name', TextType::class)
                    ->add('firstname', TextType::class)
                    ->add('address', TextareaType::class)
                    ->getForm();

                array_push($forms, $form->createView());
            }
        //}
        return $this->render('users/view.html.twig',[
            'forms' => $forms,
        ]);

    }

    /**
     * @Route("/newUser", name="newUser")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function newUser(Request $request,ObjectManager $manager)
    {
        $newUser = new User();

        $form = $this->createFormBuilder($newUser)
            ->add('pseudo',TextType::class)
            ->add('psw',PasswordType::class)
            ->add('mail',EmailType::class)
            ->add('account',TextType::class)
            ->add('save',SubmitType::class,['label'=>'valider'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newUser = $form->getData();
            $newUser
                ->setCreateat(new \DateTime())
                ->setModifyat(new \DateTime());
            $manager->persist($newUser);
            $manager->flush();
            return $this->redirectToRoute('home'); //TODO
        }
        $forms[0]=$form->createView();
        return $this->render('users/view.html.twig',[
            'forms' => $forms,
        ]);
    }


    /**
     *
     * @Route("/newClient",name="newClient")
     * @param Request $request
     * @param ObjectManager $manager
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function newClient(Request $request, ObjectManager $manager)
    {
        $newClient = new Consumer();

        $form = $this->createFormBuilder($newClient)
            ->add('name',TextType::class)
            ->add('firstname',TextType::class)
            ->add('address',TextareaType::class)
            ->add('save',SubmitType::class,['label'=>'valider'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $newClient = $form->getData();

            $newClient
                ->setCreateat(new \DateTime())
                ->setModifyat(new \DateTime());
            $manager->persist($newClient);
            var_dump($newClient);
            $manager->flush();
            var_dump($manager);
            return $this->redirectToRoute('home'); //TODO
        }

        $forms[0]=$form->createView();
        return $this->render('users/view.html.twig',[
            'forms' => $forms,
        ]);
    }


    /**
     *
     * @Route("/viewUsers",name="viewUsers")
     *
     */

    public function viewUsers(UserRepository $repoUser,Request $request,ObjectManager $manager)
    {
        $forms = [];
        $users = $repoUser->findAll();
        $userlist = [];
        foreach ($users as $user){
            $userlist[$user->getPseudo()]=$user->getPseudo();
        }

        $form = $this->createFormBuilder($userlist)
            ->add('users',ChoiceType::class,['choices'  => $userlist])
            ->add('save',SubmitType::class,['label'=>'valider'])
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            var_dump($data);
            return $this->redirectToRoute('loginPseudo',['pseudo' => $data['users']]);
        }

        array_push($forms,$form->createView());




        return $this->render('users/view.html.twig',[
            'forms' => $forms,
            'user' => $_SESSION['user'],
            'account' => $_SESSION['account'],
        ]);
    }


}
