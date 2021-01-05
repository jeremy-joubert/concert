<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\UserAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{

    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));

            //generation du token d'activation du compte
            $user->setActivationToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //envoie du email
            $message = (new \Swift_Message("Validation de votre compte"))
                ->setFrom('1christophejoubert@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('registration/confirmation_email.html.twig', [
                        'token' => $user->getActivationToken()
                    ]),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('message', 'Un email de validation vous a été envoyé!');

            return $this->redirectToRoute('index');

        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Inscription'
        ]);
    }

    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UserRepository $repository, GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator, Request $request): Response
    {
        //on cherche le user avec ce token
        $user=$repository->findOneBy(['activationToken'=>$token]);

        //on verifi si le token existe
        if(!$user){
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas!');
        }

        //on suprime le token pour activer le compte
        $user->setActivationToken("");
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Votre compte est bien activé ;)');

        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,
            $request,
            $authenticator,
            'main' // firewall name in security.yaml
        );
    }

    /**
     * @Route("/{id}/compte", name="app_compte", methods={"GET","POST"})
     */
    public function compte(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, User $user): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword($passwordEncoder->encodePassword($user, $form->get('plainPassword')->getData()));

            //generation du token d'activation du compte
            $user->setActivationToken(md5(uniqid()));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            //envoie du email
            $message = (new \Swift_Message("Validation de votre compte"))
                ->setFrom('1christophejoubert@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView('registration/confirmation_email.html.twig', [
                        'token' => $user->getActivationToken()
                    ]),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash('message', 'Un email de validation vous a été envoyé!');

            return $this->redirectToRoute('index');

        }

        return $this->render('registration/register.html.twig', [
            'form' => $form->createView(),
            'titre' => 'Modification du compte'
        ]);
    }
}
