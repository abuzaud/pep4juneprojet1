<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller;


use App\User\UserRequest;
use App\User\UserRequestHandler;
use App\User\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends Controller
{
    /**
     * Inscription d'un utilisateur
     * @Route(
     *     "/inscription",
     *     name="register_user",
     *     methods={"GET", "POST"})
     * @param Request $request
     * @param UserRequestHandler $userRequestHandler
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function register(Request $request, UserRequestHandler $userRequestHandler)
    {
        // Création de l'utilisateur intermédiaire
        $user = new UserRequest();

        // Mise en place du formulaire
        $form = $this->createForm(UserType::class, $user)
            ->handleRequest($request);

        // Traitement du formulaire
        if($form->isSubmitted() && $form->isValid()){
            // Inscription de l'utilisateur en BDD
            $user = $userRequestHandler->registerAsUser($user);

            // Message flash
            $this->addFlash('notice', 'Votre compte a bien été créé !');

            // Redirection
            return $this->redirectToRoute('index');
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}