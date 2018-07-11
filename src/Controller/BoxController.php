<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller;


use App\Controller\Box\BoxFactory;
use App\Controller\Box\BoxRequest;
use App\Controller\Box\BoxRequestHandler;
use App\Entity\Box;
use App\Entity\User;
use App\Form\BoxDescType;
use App\Form\BoxProductsType;
use App\Traits\HelperTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Workflow\Registry;

class BoxController extends Controller
{
    /**
     * @Route("/boxes", name="box_all")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param Registry $workflows
     * @param AuthorizationCheckerInterface $authChecker
     * @return Response
     */
    public function listBoxes(Request $request, EntityManagerInterface $em, Registry $workflows, AuthorizationCheckerInterface $authChecker)
    {
        // On récupère l'utilisateur
        /** @var User $user */
        $user = $this->getUser();
        $roles = $user->getRoles();

        $places = [];
        // On récupère les box suivant le role de l'utilisateur
        if ($authChecker->isGranted('ROLE_MO')
        ) {
            array_push($places, 'empty', 'desc_incomplete', 'desc_complete');
        }

        if ($authChecker->isGranted('ROLE_PM')) {
            array_push($places, 'products_incomplete', 'products_complete', 'validation_box', 'ok_box');
        }

        $boxes = $em->getRepository(Box::class)->findByPlaces($places);

        // On récupère les workflow de chaque box
        $boxWorkflow = $workflows->all($boxes);


        // On affiche la page
        return $this->render('boxes/boxes.html.twig', [
            'boxes' => $boxes,
            'roles' => $roles
        ]);
    }

    /**
     * @Route("/box/{id}/view", name="box_view", requirements={"id"="\d+"})
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param $id
     * @param Registry $workflows
     * @param Box $box
     * @return Response
     */
    public function viewBox(Request $request, EntityManagerInterface $em, $id, Registry $workflows, Box $box)
    {
        return $this->render('boxes/box.html.twig', [
            'box' => $box
        ]);
    }

    /**
     * @Route(
     *      "/box/{id}/edit/{_action}",
     *      name="box_edit",
     *      defaults={"_action" = "description"},
     *      requirements={
     *        "id"="\d+",
     *        "_action"="description|produits"
     *      }
     * )
     * @param Request $request
     * @param $_action
     * @param BoxRequest $boxRequest
     * @param Box $box
     * @param BoxFactory $boxFactory
     * @param EntityManagerInterface $em
     * @param Registry $workflows
     * @return Response
     */
    public function editBox(Request $request, $_action, BoxRequest $boxRequest,
                            Box $box, BoxFactory $boxFactory, EntityManagerInterface $em, Registry $workflows)
    {
        $workflow = $workflows->get($box, 'box_making');

        // On créé une $boxRequest pour le traitement des données
        $boxRequest = $boxRequest->createBoxRequestFromBox($box);

        // On affiche un formulaire différent suivant si on est
        // à l'édition de la description ou l'ajout de produits
        if ($_action === 'produits') {
            $formType = BoxProductsType::class;
            $workflow_place = 'products_incomplete';
        } else {
            $formType = BoxDescType::class;
            $workflow_place = 'desc_incomplete';
        }

        // On créé le formulaire
        $form = $this->createForm($formType, $boxRequest)
            ->handleRequest($request);

        // Soumissions du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // Etape de description
            if ($workflow_place === 'add_desc_box') {
                // Si la description de la box est incomplète
                if (empty($boxRequest->getDescription()) ||
                    empty($boxRequest->getReference())
                ) {
                    $workflow->apply($box, 'desc_incomplete');

                    // Si la description de la box est complète
                } else {
                    $workflow->apply($box, 'adding_products');
                }
                // Etape d'ajout de produits
            } elseif ($workflow_place === 'add_products_box') {
                // Si les produits ont été ajoutés correctement
                if (!empty($boxRequest->getProducts())) {
                    $workflow->apply($box, 'products_added');
                } else {
                    $workflow->apply($box, 'adding_products');
                }
            }

            // On appelle notre factory pour modifier notre box
            $box = $boxFactory->modifyFromBoxRequest($box, $boxRequest);

            // On effectue la modification en base de données
            $em->flush();

            // On ajoute un message flash pour dire que tout c'est bien passé
            $this->addFlash('notice', 'La box a bien été modifié !');

            // On redirige vers la liste des box
            return $this->redirectToRoute('box_all');
        }

        return $this->render('boxes/box_edit.html.twig', [
            'box' => $box,
            'form' => $form->createView(),
            'workflow_place' => $workflow_place
        ]);
    }

    /**
     * @Route("/box/new", name="box_add")
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param BoxRequestHandler $boxRequestHandler
     * @param Registry $workflows
     * @return Response
     */
    public function addBox(Request $request, EntityManagerInterface $em, BoxRequestHandler $boxRequestHandler, Registry $workflows)
    {
        // Création de l'objet
        $box = new BoxRequest();

        // Création du formulaire
        $form = $this->createForm(BoxDescType::class, $box)
            ->handleRequest($request);

        // Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère le workflow de la boite
            $workflow = $workflows->get($box, 'box_making');

            // On récupère le workflow et on le passe à l'étape suivante
            // à condition que la description soit complète
            if (!empty($box->getDescription()) && !empty($box->getReference())) {
                $workflow->apply($box, 'desc_ok_from_empty');
            } else {
                $workflow->apply($box, 'adding_budget');
            }

            // 0n utilise BoxRequestHandler pour valider et persister les infos en bdd
            $box = $boxRequestHandler->handle($box);

            // Affichage d'une notification de réussite
            $this->addFlash('notice', 'La box a été correctement créée');

            return $this->redirectToRoute('box_all');
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