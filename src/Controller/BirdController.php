<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Model\BirdData;
/**
 * Class BirdController
 */

class BirdController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index(SessionInterface $session)
    {
        $bird = new BirdData;

        $lastBird = $session->get('last_bird', 'None');

        return $this->render('default/bird.html.twig', [
            'names' => $bird->getBird(),
            'lastBird' => $lastBird,
        ]);
    }

    /**
     *
     * @Route("/bird/{id}", name="birdDetails", requirements={"id"="\d+"})
     */
    public function bird($id, SessionInterface $session)
    {
        $bird = new BirdData;
        $bird = $bird->getBirdId($id);

        if($bird === false) {
            throw $this->createNotFoundException("Pas doiseau");
        }

        $session->set('last_bird', $bird['name']);

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


    /**
     * @Route("/api/birds", name="bird-json")
     */
    public function api()
    {
        $bird = new BirdData;

        return $this->json($bird->getBird());
    }
}
