<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ThemeRepository")
 */
class Theme
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Question", mappedBy="theme")
     */
    private $questions;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function toString($questions)
    {
        $data = [
            "title" => $this->getTitle(),
            "description" => $this->getDescription()
        ];

        foreach ($questions as $keyQ => $question) {
            $data[$keyQ]["question"] = $question->getQuestion();
            foreach ($question->getBatches() as $keyB => $batch) {
                foreach ($batch->getAnswers() as $keyA => $answer) {
                    $data[$keyQ]["responses"][$keyA] = $answer->getAnswer();
                    if ($batch->getGoodAnswer() == $answer) {
                        $data[$keyQ]["goodAnswer"] = $keyA;
                    }
                }
            }
        }

        return $data;
    }

    public function __construct()
    {
        $this->questions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Question[]
     */
    public function getQuestions(): Collection
    {
        return $this->questions;
    }

    public function addQuestion(Question $question): self
    {
        if (!$this->questions->contains($question)) {
            $this->questions[] = $question;
            $question->setTheme($this);
        }

        return $this;
    }

    public function removeQuestion(Question $question): self
    {
        if ($this->questions->contains($question)) {
            $this->questions->removeElement($question);
            // set the owning side to null (unless already changed)
            if ($question->getTheme() === $this) {
                $question->setTheme(null);
            }
        }

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }
}
