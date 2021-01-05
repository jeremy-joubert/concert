<?php

namespace App\Controller;

use App\Entity\Band;
use App\Entity\Member;
use App\Entity\Show;
use App\Entity\ShowSearch;
use App\Form\BandType;
use App\Form\MemberType;
use App\Form\ShowSearchType;
use App\Form\ShowType;
use App\Repository\ShowRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ConcertController extends AbstractController
{
    /**
     * @Route("/concert", name="concert", methods={"GET"})
     */
    public function index(Request $request, ShowRepository $showRepository, PaginatorInterface $paginator): Response
    {
        //formulaire de recherche
        $search=new ShowSearch();
        $form=$this->createForm(ShowSearchType::class, $search);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $donnees=$showRepository->findByShowSearch($search);
        }else{
            $donnees=$showRepository->findAll();
        }

        $shows=$paginator->paginate( $donnees,
            $request->query->getInt('page', 1),
            9
        );
        return $this->render('concert/index.html.twig', [
            'concerts' => $shows,
            'form' =>$form->createView()
        ]);
    }

    /**
     * @Route("/concert/new", name="concert_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $show = new Show();
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($show);
            $entityManager->flush();

            return $this->redirectToRoute('concert');
        }

        return $this->render('concert/new.html.twig', [
            'titre' => 'Créer un concert',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/band/new", name="band_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function newBand(Request $request): Response
    {
        $band = new Band();
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //stockage des images
            $image=$form->get('picture')->getData();
            $nomImage=md5(uniqid()).'.png';
            $image->move(
                $this->getParameter('images_directory'),
                $nomImage
            );
            $band->setPicture($nomImage);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($band);
            $entityManager->flush();

            return $this->redirectToRoute('concert');
        }

        return $this->render('concert/new.html.twig', [
            'titre' => 'Créer un groupe',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/member/new", name="member_new", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function newMember(Request $request): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //stockage des images
            $image=$form->get('picture')->getData();
            $nomImage=md5(uniqid()).'.png';
            $image->move(
                $this->getParameter('images_directory'),
                $nomImage
            );
            $member->setPicture($nomImage);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($member);
            $entityManager->flush();

            return $this->redirectToRoute('concert');
        }

        return $this->render('concert/new.html.twig', [
            'titre' => 'Ajouter un membre',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/concert", name="concert_show", methods={"GET"})
     */
    public function show(Show $show): Response
    {
        return $this->render('concert/show.html.twig', [
            'concert' => $show,
        ]);
    }

    /**
     * @Route("/{id}/editconcert", name="concert_edit", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Show $show): Response
    {
        $form = $this->createForm(ShowType::class, $show);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('concert_show',['id' => $show->getId()]);
        }

        return $this->render('concert/new.html.twig', [
            'titre' => 'Modifier un concert',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/deleteconcert", name="concert_delete" , methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function delete(Show $show): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($show);
        $entityManager->flush();

        return $this->redirectToRoute('concert');
    }

    /**
     * @Route("/{id}/editgroupe", name="groupe_edit", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function editBand(Request $request, Band $band): Response
    {
        $form = $this->createForm(BandType::class, $band);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('concert/new.html.twig', [
            'titre' => 'Modifier un groupe',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/deleteband", name="band_edit" , methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteBand(Band $band): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($band);
        $entityManager->flush();

        return $this->redirectToRoute('concert');
    }

    /**
     * @Route("/{id}/editMember", name="member_edit", methods={"GET","POST"})
     * @isGranted("ROLE_ADMIN")
     */
    public function editMember(Request $request, Member $member): Response
    {
        $member->setPicture("");
        $form = $this->createForm(MemberType::class, $member);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //stockage des images
            $image=$form->get('picture')->getData();
            $nomImage=md5(uniqid()).'.png';
            $image->move(
                $this->getParameter('images_directory'),
                $nomImage
            );
            $member->setPicture($nomImage);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('index');
        }

        return $this->render('concert/new.html.twig', [
            'titre' => 'Modifier un membre',
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/deletemember", name="member_delete" , methods={"GET"})
     * @isGranted("ROLE_ADMIN")
     */
    public function deleteMember(Member $member): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($member);
        $entityManager->flush();

        return $this->redirectToRoute('concert');
    }
}
