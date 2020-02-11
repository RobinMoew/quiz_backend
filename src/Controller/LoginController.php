<?php

namespace App\Controller;

header('Access-Control-Allow-Origin: *');

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    /**
     * @Route("/log_in", name="log_in")
     */
    public function log_in(Request $request)
    {
        $email = $request->get("email");
        $password = $request->get("password");

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class);
        $bdd_password = $user->findOneByEmail($email)->getPassword();

        if ($user) {
            if (password_verify($password, $bdd_password)) {
                return $this->json(['message' => 'Connecté !']);
            }
        }
    }
}
