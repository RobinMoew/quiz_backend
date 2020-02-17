<?php

namespace App\Controller;

header('Access-Control-Allow-Origin: *');

use App\Entity\Answer;
use App\Entity\Batch;
use App\Entity\Question;
use App\Entity\Theme;
use mysqli;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/getThemes", name="getTheme")
     */
    public function getThemes()
    {
        // $co = new mysqli('localhost', 'root', 'root', 'quiz');
        // $sql = $co->prepare('SELECT * FROM theme');
        // $sql->execute();
        // $sql->bind_result($bdd_id, $bdd_desc, $bdd_title);

        // $output = [];

        // while ($sql->fetch()) {
        //     $output[] = [
        //         'id' => $bdd_id,
        //         'title' => $bdd_title,
        //         'description' => $bdd_desc
        //     ];
        // }

        // $sql->close();
        // $co->close();

        // return $this->json($output);

        $em = $this->getDoctrine()->getManager();
        $repository_theme = $em->getRepository(Theme::class);
        $repository_question = $em->getRepository(Question::class);

        $themes = $repository_theme->findAll();

        $data = [];
        foreach ($themes as $theme) {
            $questions = $repository_question->getQuestionsByTheme($theme);
            $data[] = $theme->toString($questions);
        }

        return $this->json(['themes' => $data]);
    }

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

        $file = file_get_contents('../themes.json');
        $data = json_decode($file);

        foreach ($data as $theme) {
            $title = $theme->title;
            $description = $theme->description;

            $t = new Theme();
            $t->setTitle($title);
            $t->setDescription($description);

            $em->persist($t);

            foreach ($theme->questions as $question) {
                $questionObj = (array) $question;
                $intitule = $questionObj['question'];

                $b = new Batch();
                $q = new Question();
                $q->setTheme($t);
                $q->setQuestion($intitule);
                $q->addBatch($b);

                $em->persist($q);

                for ($i = 1; $i < 5; $i++) {
                    $reponseCourante = htmlspecialchars($questionObj["a" . $i]);

                    $r = new Answer();
                    $r->setAnswer($reponseCourante);
                    $em->persist($r);

                    $b->addAnswer($r);
                }
                $bonneReponse = htmlspecialchars($questionObj["ga"]);

                $ga = new Answer();
                $ga->setAnswer($bonneReponse);
                $em->persist($ga);

                $b->setGoodAnswer($ga);
                $em->persist($b);
            }

            $em->flush();
        }

        return $this->json("Added to database");
    }
}
