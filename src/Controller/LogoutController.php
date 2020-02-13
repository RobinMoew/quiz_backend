<?php

namespace App\Controller;

header('Access-Control-Allow-Origin: *');

use App\Services\SessionUtility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LogoutController extends AbstractController
{
    /**
     * @Route("/logout", name="logout")
     */
    public function logout(Request $request)
    {
        $session = new SessionUtility($this->get('session'), $request);
        $session->close();

        return $this->json([
            'redirect' => 'home'
        ]);
    }
}
