<?php

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Batch;
use App\Entity\Question;
use App\Entity\Theme;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{

    /**
     * @Route("/getThemeInfos", name="getThemeInfos")
     */
    public function getThemeInfos(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repository_theme = $em->getRepository(Theme::class);
        $repository_question = $em->getRepository(Question::class);

        $themeId = $request->get("themeId");

        $theme = $repository_theme->findOneById($themeId);
        $questions = $repository_question->getQuestionsByTheme($theme);

        return $this->json($theme->toString($questions));
    }

    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();

        $theme = new Theme();
        $theme->setTitle("CSS");
        $theme->setDescription("Quizz sur le cascading style sheet !");

        $em->persist($theme);

        $r1 = new Answer();
        $r1->setAnswer("Cascading Style Sheet !");
        $em->persist($r1);

        $r2 = new Answer();
        $r2->setAnswer("Cacading Style Sheet !");
        $em->persist($r2);

        $r3 = new Answer();
        $r3->setAnswer("Cascading Steel Sheet !");
        $em->persist($r3);

        $r4 = new Answer();
        $r4->setAnswer("Cascading Style Shit !");
        $em->persist($r4);

        $b = new Batch();
        $b->setGoodAnswer($r1);
        $b->addAnswer($r1);
        $b->addAnswer($r2);
        $b->addAnswer($r3);
        $b->addAnswer($r4);

        $em->persist($b);

        $q = new Question();
        $q->setTheme($theme);
        $q->setQuestion("Que veut dire CSS ?");
        $q->addBatch($b);

        $em->persist($q);

        $em->flush();


        return $this->json("coucou");
    }
}
