<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\BirdData;
/**
 * Class BirdController
 */

class BirdController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $bird = new BirdData;
        return $this->render('default/bird.html.twig', [
            'names' => $bird->getBird(),
        ]);
    }

    /**
     *
     * @Route("/bird/{id}", name="birdDetails", requirements={"id"="\d+"})
     */
    public function bird($id)
    {
        $bird = new BirdData;
        $bird = $bird->getBirdId($id);

        if($bird === false) {
            throw $this->createNotFoundException("Pas d'oiseau");
        }

        return $this->render('default/birdDetail.html.twig', [
            'name' => $bird['name'],
            'description' => $bird['description'],
            'image' => $bird['image'],
        ]);
    }

    /**
     * @Route("/pdf", name="pdf_download")
     */
    public function pdf()
    {
        return $this->file('pdf/angry_birds_2015_calendar.pdf');
    }
}
