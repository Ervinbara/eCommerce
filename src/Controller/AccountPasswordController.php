<?php

namespace App\Controller;

use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AccountPasswordController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {
        $this->entityManager = $entityManager;
    }
    // #[Route('/compte/update-password', name: 'app_account_password')]
    /**
     * @Route("/compte/update-password", name="app_account_password")
     */
    public function index(Request $request, UserPasswordHasherInterface $encoder): Response
    {
        $notification = null;
        $info = null;
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid() ) {
            // Vérification de la validité de l'ancien mot de passe
            $old_pwd = $form->get('old_password')->getData();
            if($encoder->isPasswordValid($user, $old_pwd)){
                $new_pwd = $form->get('new_password')->getData();
                $password = $encoder->hashPassword($user, $new_pwd);

                $user->setPassword($password);

                $this->entityManager->persist($user);
                $this->entityManager->flush();
                $notification = "Votre mot de passe à bien été mise à jour";
                $info = "success";
            } else {
                $notification = "Votre mot de passe actuel ne correspond pas";
                $info = "danger";
            }
        }

        return $this->render('account/password.html.twig', [
            'form' => $form->createView(),
            'notification' => $notification,
            'info' => $info
        ]);
    }
}
