<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\PlayerType;
use App\Player\Manager as PlayerManager;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * @Route("{_locale}/game")
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login", methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authUtils): Response
    {
        return $this->render('security/login.html.twig', [
            'last_username' => $authUtils->getLastUsername(),
            'error' => $authUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/logout", name="logout", methods="GET")
     */
    public function logout()
    {
        // Code never executed as the firewall intercept the request before the
        // Routing component can even match the pattern with the action.
    }

    /**
     * @Route(
     *     "/register",
     *     name="register",
     *     methods={"GET", "POST"},
     *     requirements={"_locale"="en|fr|de"}
     *     )
     */
    public function register(Request $request, PlayerManager $playerManager): Response
    {
        $form = $this->createForm(PlayerType::class)->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $playerManager->register($form->getData());

            $this->addFlash('success', 'You have been successfully added to the big family of the hangman game!');
            return $this->redirectToRoute('homepage');
        }
        return $this->render('security/register.html.twig', [
            'registration_form' => $form->createView(),
        ]);
    }
}
