<?php
/**
 * Created by Antoine Buzaud.
 * Date: 09/07/2018
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @return Response
     */
    public function index(){
        return new Response('<html><body><h1>Page d\'accueil lalala</h1></body></html>');
    }
}