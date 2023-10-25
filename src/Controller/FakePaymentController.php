<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FakePaymentController extends AbstractController
{
    #[Route('/fake/payment', name: 'app_fake_payment')]
    public function index(): Response
    {
        return $this->render('fake_payment/index.html.twig', [
            'controller_name' => 'FakePaymentController',
        ]);
    }
}
