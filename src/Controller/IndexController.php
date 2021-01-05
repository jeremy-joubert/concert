<?php

namespace App\Controller;

use App\Repository\ShowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/index", name="index")
     */
    public function index(ShowRepository $showRepository): Response
    {
        return $this->render('index/index.html.twig', [
            'new_shows' => $showRepository->findByRecentDate()
        ]);
    }
}
