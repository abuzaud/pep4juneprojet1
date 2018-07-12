<?php
/**
 * Created by Antoine Buzaud.
 * Date: 09/07/2018
 */

namespace App\Controller\Security;


use App\Form\LoginType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends Controller
{
    private $security;

    /**
     * SecurityController constructor.
     * @param Security $security
     */
    public function __construct(Security $security)
    {
        $this->security = $security;
    }


    /**
     * Page de connexion à l'administration
     * @Route("/connexion", name="index_login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        /**
         * Si l'utilisateur est déjà connecté, on le redirige
         * vers l'administration
         */

        if ($this->getUser()) {
            //return $this->redirectToRoute('admin');
        }

        /*
         * Création du formulaire de connexion
         */
        $form = $this->createForm(LoginType::class, [
            'email' => $authenticationUtils->getLastUsername()
        ]);

        /**
         * Gestion des erreurs
         */
        $error = $authenticationUtils->getLastAuthenticationError();
        /**
         * Transmission à la vue
         */
        return $this->render('security/login.html.twig', [
            'form' => $form->createView(),
            'error' => $error
        ]);
    }
}