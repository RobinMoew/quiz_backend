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
        $em = $this->getDoctrine()->getManager();

        $email = $request->get("email");
        $password = $request->get("password");

        $repo = $em->getRepository(User::class);
        var_dump($repo);
        $user = $repo->findOneByEmail($email);
        var_dump($user);
        die();
        $bdd_password = $user->getPassword();

        if ($user) {
            if (password_verify($password, $bdd_password)) {
                return $this->json([
                    'success' => true,
                    'message' => 'Connecté !'
                ]);
            }
        }
        return $this->json([
            'success' => false,
            'message' => 'Un des champs est incorrect'
        ]);
    }
}
