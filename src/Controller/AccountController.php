<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/login", name="account_login")
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig',[
            'hasError' => $error != null,  
            'username' => $username
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    function logout(){    }

    /**
     * permit d'afficher le formulaire d'inscription 
     *@Route("/register", name="account_register")
     * @return Response
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder){
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);

            $manager=$this->getDoctrine()->getManager();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success', "votre compt a bien été enregistrer  !"
            );
            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig',[
            'form' => $form->createView()
        ]);

    }

    /**
     * modification de profil
     * @Route("/account/profile", name="account_profile")
     * @IsGranted("ROLE_USER")
     *
     * @return Response
     */
    public function profile(Request $request){
        $user = $this->getUser();

        $form=$this->createForm(AccountType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $this->em->persist($user);
            $this->em->flush();

            $this->addFlash(
                'success', "les modification de profil ont été enregistrée avec succés !"
            );

        }

        return $this->render('account/profile.html.twig',[
            'form'=> $form->createView()
        ]); 

    }

    /**
     * permet de modifier le mot de pass
     *
     * @Route("/acccount/password-update", name="account_passsword")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder){
        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            // $manager=$this->getDoctrine()->getManager();
                // vérifier que le oldPassword du formulaire soit le mméme que le password de l'user
               if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash())){
                    //Gérer l'erreur
                    $form->get('oldPassword')->addError(new FormError("le mot de passe que vous avez tappé n'est pas votre mot de passe actuel !"));
               }else{
                   $newPassword = $passwordUpdate->getNewPassword();
                   $hash = $encoder->encodePassword($user, $newPassword);

                   $user->setHash($hash);

                   $this->em->persist($user);
                   $this->em->flush();
                   $this->addFlash(
                    'success', "votre mot de passe a bien été modifier !"
                );
    
                return $this->redirectToRoute('homme');

               }

        }
        return $this->render('account/password.html.twig',[
            'form'=>$form->createView()
        ]);

    }

    /**
     * permit d'afficher le profil de l'utilisateur connecté
     * @Route("/account", name="account_index")
     * @IsGranted("ROLE_USER")
     * @return Response
     */
    public function myAccount(){
        return $this->render('user/index.html.twig',[
            'user' =>  $this->getUser()
        ]);
    }
}
