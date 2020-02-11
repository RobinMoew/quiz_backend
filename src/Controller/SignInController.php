<?php

namespace App\Controller;

header('Access-Control-Allow-Origin: *');

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SignInController extends AbstractController
{
    /**
     * @Route("/sign_in", name="sign_in")
     */
    public function sign_in(Request $request)
    {

        $email = $request->get("email");
        $password = $request->get("password");
        $c_password = $request->get("c_password");

        if ($password != $c_password) {
            return $this->json(['message' => 'Mot de passe différents!']);
        }

        $em = $this->getDoctrine()->getManager();
        $user = new User();
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $em->persist($user);
        $em->flush();

        return $this->json(['message' => 'Inscrit !']);
    }
}
