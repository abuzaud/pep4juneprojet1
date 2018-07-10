<?php
/**
 * Created by Antoine Buzaud.
 * Date: 09/07/2018
 */

namespace App\Controller;


use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(){
        $user = $this->getUser();

        return $this->render('index/index.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     * @param AuthorizationCheckerInterface $authChecker
     * @return Response
     */
    public function admin(AuthorizationCheckerInterface $authChecker)
    {
        if($authChecker->isGranted('ROLE_ADMIN')){
            return $this->render('admin/admin.html.twig');
        } else {
            $this->addFlash('warning', "Vous n'êtes pas connecté en tant qu'administrateur");
            return $this->redirectToRoute('index_login');
        }
    }
}