<?php

namespace App\Controller;

header('Access-Control-Allow-Origin: *');

use App\Entity\User;
use App\Services\SessionUtility;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Attribute\AttributeBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;

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
        $user = $repo->findOneByEmail($email);

        if (!$email or !$password) {
            return $this->json([
                'message' => 'Il manque des informations'
            ]);
        }

        if ($user) {
            if (password_verify($password, $user->getPassword())) {
                $session = new SessionUtility($this->get('session'), $request);
                $session->set('id', $user->getId());
                $session->set('email', $user->getEmail());

                return $this->json([
                    'id' => $user->getId(),
                    'email' => $user->getEmail(),
                    'redirect' => "categories",
                    'message' => 'Connecté !',
                    "sessionId" => $session->getId()
                ]);
            }
        } else {
            return $this->json([
                'message' => 'Aucun compte avec cet email'
            ]);
        }

        return $this->json([
            'message' => 'Un des champs est incorrect'
        ]);
    }
}
