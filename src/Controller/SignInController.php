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
        $em = $this->getDoctrine()->getManager();

        $email = $request->get("email");
        $password = $request->get("password");
        $c_password = $request->get("c_password");


        $repo = $em->getRepository(User::class);
        $user_exist = $repo->findOneByEmail($email);

        if ($user_exist) {
            return $this->json([
                'success' => false,
                'message' => 'Cette entrée existe déjà: ' . $email
            ]);
        }

        if (!$email or !$password or !$c_password) {
            return $this->json([
                'success' => false,
                'message' => 'Il manque des informations'
            ]);
        }

        if ($password != $c_password) {
            return $this->json([
                'success' => false,
                'message' => 'Mot de passe différents!'
            ]);
        }

        $user = new User();
        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));

        $em->persist($user);
        $em->flush();

        return $this->json([
            'success' => true,
            'message' => 'Inscrit !'
        ]);
    }
}
