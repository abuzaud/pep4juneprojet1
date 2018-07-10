<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller;


use App\Controller\Box\BoxRequest;
use App\Controller\Box\BoxRequestHandler;
use App\Entity\Box;
use App\Form\BoxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Registry;

class BoxController extends Controller
{
    /**
     * @Route("/boxes", name="box_all")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Registry $workflows
     * @return Response
     */
    public function listBoxes(Request $request, EntityManagerInterface $em, Registry $workflows)
    {
        // On récupère les box
        $boxes = $em->getRepository(Box::class)->findAll();

        // On récupère les workflow de chaque box
        $boxWorkflow = $workflows->all($boxes);

        // On créé le tableau qui contiendra les box autorisés à être vue
        $authorizedBoxes = [];
        foreach ($boxes as $box) {
            // On récupère le workflow de la box
            $workflow = $workflows->get($box, 'box_making');

            // Si nous sommes autorisé, on ajoute la box à la vue
            if ($workflow->can($box, 'add_desc') || $workflow->can($box, 'add_products')) {
                $authorizedBoxes[] = $box;
            }

        }
        // On affiche la page
        return $this->render('boxes/boxes.html.twig', [
                'boxes' => $authorizedBoxes
        ]);
    }

    /**
     * @Route("/box/{id}", name="box_one", requirements={"id"="\d+"})
     * @param Request $request
     * @return Response
     */
    public function viewBox(Request $request, EntityManagerInterface $em, $id)
    {
        $box = $em->getRepository(Box::class)->find($id);

        return $this->render('boxes/box.html.twig', [
                'box' => $box
        ]);
    }

    /**
     * @Route("box/{id}/edit", name="box_edit", requirements={"id"="\d+"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $id
     * @return Response
     */
    public function editBox(Request $request, EntityManagerInterface $em, $id)
    {
        $box = $em->getRepository(Box::class)->find($id);

        $form = $this->createForm(BoxType::class, $box);

        return $this->render('boxes/box_edit.html.twig', [
                'box' => $box,
                'form' => $form->createView()
        ]);
    }

    /**
     * @Route("box/nouveau", name="box_add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param BoxRequestHandler $boxRequestHandler
     * @param Registry $workflow
     * @return Response
     */
    public function addBox(Request $request, EntityManagerInterface $em, BoxRequestHandler $boxRequestHandler, Registry $workflow)
    {
        // Création de l'objet
        $box = new BoxRequest();

        // Création du formulaire
        $form = $this->createForm(BoxType::class, $box)
                ->handleRequest($request);

        // Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // 0n utilise BoxRequestHandler pour valider et persister les infos en bdd
            $box = $boxRequestHandler->handle($box);

            // On change l'état du workflow
            $workflow = $workflow->get($box);
            $workflow->apply($box, 'add_products');

            // Affichage d'une notification de réussite
            $this->addFlash('notice', 'La box a été correctement créée');
        }


        return $this->render('boxes/box_new.html.twig', [
                'box' => $box,
                'form' => $form->createView()
        ]);
    }

    /**
     * Fonction permettant d'initialiser toute les box à la transition "add_products" du workflow box_making
     * @param EntityManagerInterface $em
     * @param Registry $workflows
     */
    public function initAllBoxes(EntityManagerInterface $em, Registry $workflows)
    {
        $boxes = $em->getRepository(Box::class)->findAll();

        foreach ($boxes as $box) {
            $workflow = $workflows->get($box);
            $workflow->apply($box, 'add_products');
            $em->persist($box);
            $em->flush();
        }
    }
}