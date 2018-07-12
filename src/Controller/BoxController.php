<?php
/**
 * Created by Antoine Buzaud.
 * Date: 10/07/2018
 */

namespace App\Controller;

use App\Controller\Box\BoxRequest;
use App\Controller\Box\BoxRequestHandler;
use App\Entity\Box;
use App\Entity\User;
use App\Form\BoxType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Workflow\Registry;

class BoxController extends Controller
{
    /**
     * @Route("/all-boxes", name="listboxes")
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function listAllBoxes(EntityManagerInterface $em){
        // On récupère toutes les box
        $boxes = $em->getRepository(Box::class)->findAll();

        // On affiche la page
        return $this->render('boxes/list_all_boxes.html.twig', [
            'boxes' => $boxes
        ]);
    }

    /**
     * @Route("/boxes", name="box_all")
     * @param EntityManagerInterface $em
     * @param Registry $workflows
     * @param Security $security
     * @return Response
     */
    public function listBoxes(EntityManagerInterface $em, Registry $workflows, Security $security)
    {
        if (!$security->isGranted(['ROLE_ADMIN']) &&
            !$security->isGranted(['ROLE_MO']) &&
            !$security->isGranted(['ROLE_PM']) &&
            !$security->isGranted(['ROLE_DIRECTOR']) &&
            !$security->isGranted(['ROLE_SUPPLIER'])
        ) {
            $this->addFlash('warning', "Vous n'avez pas les droits pour voir les box!");
            return $this->redirectToRoute('index');
        }

        // On récupère l'utilisateur
        /** @var User $user */
        $user = $this->getUser();
        $roles = $user->getRoles();

        $places = [];
        // On récupère les box suivant le role de l'utilisateur
        if ($security->isGranted('ROLE_MO')) {
            array_push($places, 'edition');
        }

        if ($security->isGranted('ROLE_PM')) {
            array_push($places, 'box_complete');
        }

        if ($security->isGranted('ROLE_MM')) {
            array_push($places, 'validate');
        }

        if ($security->isGranted('ROLE_DIRECTOR')) {
            array_push($places, 'production');
        }

        if ($security->isGranted('ROLE_ADMIN')) {
            array_push($places, 'validate', 'go', 'sent');
        }

        $boxes = $em->getRepository(Box::class)->findByPlaces($places);

        // On récupère la liste des boites qui ont été expédié
        $sentBoxes = $em->getRepository(Box::class)->findSentBoxes();

        // On récupère les workflow de chaque box
        $boxWorkflow = $workflows->all($boxes);


        // On affiche la page
        return $this->render('boxes/boxes.html.twig', [
            'boxes' => $boxes,
            'roles' => $roles,
            'sentBoxes' => $sentBoxes
        ]);
    }

    /**
     * @Route("/box/{id}/view", name="box_view", requirements={"id"="\d+"})
     * @param Box $box
     * @return Response
     */
    public function viewBox(Box $box)
    {
        return $this->render('boxes/box.html.twig', [
            'box' => $box
        ]);
    }

    /**
     * @Route("box/{id}/edit", name="box_edit", requirements={"id"="\d+"})
     * @param Request $request
     * @param BoxRequestHandler $boxRequestHandler
     * @param Box $box
     * @param BoxRequest $boxRequest
     * @param EntityManagerInterface $em
     * @param Registry $registry
     * @param Security $security
     * @return Response
     */
    public function editBox(
        Request $request, BoxRequestHandler $boxRequestHandler,
        Box $box, BoxRequest $boxRequest,
        EntityManagerInterface $em, Registry $registry,
        Security $security, $id)
    {
        if (!$security->isGranted(['ROLE_ADMIN']) &&
            !$security->isGranted(['ROLE_MO']) &&
            !$security->isGranted(['ROLE_DIRECTOR'])
        ) {
            $this->addFlash('warning', "Vous n'avez pas les droits pour voir la box [#$id] !");
            return $this->redirectToRoute('index');
        }

        // On passe la box à BoxRequest pour la gestion du formulaire
        $boxRequest = $boxRequest->createBoxRequestFromBox($box);

        // On génère le formulaire
        $form = $this->createForm(BoxType::class, $boxRequest)
            ->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $workflow = $registry->get($box, 'box_making');
            // On passe la requête à notre handler
            try {
                // Si tous les champs obligatoire sont remplis
                if ($boxRequest->isCompleted()) {
                    if ($workflow->can($boxRequest, 'datas_added')) {
                        $workflow->apply($boxRequest, 'datas_added');
                    }
                }

                $boxRequestHandler->handleEdit($boxRequest, $box);
            } catch (\Exception $e) {
                // On affiche une notification
                $this->addFlash('warning',
                    'La mise à jour de la box s\'est mal produit.' . PHP_EOL .
                    '[' . $e->getMessage() . '] dans [' . $e->getFile() . '] - Ligne : ' . $e->getLine());
            }

            // On ajoute un message flash pour dire que tout c'est bien passé
            $this->addFlash('notice', 'La box a bien été modifié !');

            // On redirige vers la liste des box
            return $this->redirectToRoute('box_all');
        }

        // On passe à la vue
        return $this->render('boxes/box_edit.html.twig', [
            'box' => $box,
            'form' => $form->createView()
        ]);
    }

    /**
     * Route permettant la suppression d'une box
     * @Route("/box/{id}/delete", name="box_delete", requirements={"id"="\d+"})
     * @param EntityManagerInterface $em
     * @param Box $box
     * @param Security $security
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteBox(EntityManagerInterface $em, Box $box, Security $security, $id)
    {
        if (!$security->isGranted(['ROLE_ADMIN']) &&
            !$security->isGranted(['ROLE_MO']) &&
            !$security->isGranted(['ROLE_MM']) &&
            !$security->isGranted(['ROLE_DIRECTOR'])
        ) {
            $this->addFlash('warning', "Vous n'avez pas les droits pour supprimer la box [#$id] !");
            return $this->redirectToRoute('index');
        }
        $tmpBox = $box;

        //On supprime la box
        $em->remove($box);

        // On supprime en base
        $em->flush();

        //On affiche une notification
        $options = array($tmpBox->getId(), $tmpBox->getName());
        $message = vsprintf("La box [#%d] '%s' a été supprimé !", $options);

        // On affiche un message pour prévenir l'utilisateur que la suppression s'est bien passé
        $this->addFlash('notice', $message);

        return $this->redirectToRoute('box_all');
    }

    /**
     * @Route("/box/new", name="box_add")
     * @param Request $request
     * @param BoxRequest $boxRequest
     * @param BoxRequestHandler $boxRequestHandler
     * @param Registry $registry
     * @param Security $security
     * @return Response
     */
    public function addBox(Request $request, BoxRequest $boxRequest, BoxRequestHandler $boxRequestHandler,
                           Registry $registry, Security $security)
    {
        if (!$security->isGranted('ROLE_MO')) {
            $this->addFlash('warning', "Vous n'avez pas les droits pour ajouter une boite !");
            return $this->redirectToRoute('index');
        }

        // Création du formulaire
        $form = $this->createForm(BoxType::class, $boxRequest)
            ->handleRequest($request);

        // Vérification des données du formulaire
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère le workflow de la boite
            $workflow = $registry->get($boxRequest, 'box_making');

            // 0n utilise BoxRequestHandler pour valider et persister les infos en bdd
            $box = $boxRequestHandler->handleNew($boxRequest);

            // On avance le workflow
            if ($workflow->can($box, 'datas_added')) {
                $workflow->apply($box, 'datas_added');
            }

            // Affichage d'une notification de réussite
            $this->addFlash('notice', 'La box a été correctement créée');

            return $this->redirectToRoute('box_all');
        }

        return $this->render('boxes/box_new.html.twig', [
            'box' => $boxRequest,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/box/{id}/validate", name="box_validate", requirements={"id"="\d+"})
     * @param $id
     * @param Box $box
     * @param Registry $registry
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function boxValidate($id, Box $box, Registry $registry, EntityManagerInterface $em)
    {
        // On vérifie les droits de l'utilisateur
        if (!$this->isGranted('ROLE_PM')) {
            $this->addFlash('warning', "Vous n'avez pas le droit de valider une box !");
            return $this->redirectToRoute('index');
        }

        // On récupère le workflow
        $workflow = $registry->get($box, 'box_making');

        // Si on peut passer à l'étape suivante, on le fait
        if ($workflow->can($box, 'products_validation')) {
            $box->setIsValidate(true);
            $workflow->apply($box, 'products_validation');
        }

        // On sauvegarde en bdd
        $em->flush();

        // On redirige en affichant une notification
        $this->addFlash('notice', "Vous venez de valider la box [#$id] !");
        return $this->redirectToRoute('box_all');
    }

    /**
     * @Route("/box/{id}/production", name="box_production", requirements={"id"="\d+"})
     * @param $id
     * @param Box $box
     * @param Registry $registry
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|void
     */
    public function boxProduction($id, Box $box, Registry $registry, EntityManagerInterface $em)
    {
        // On vérifie les droits de l'utilisateur
        if (!$this->isGranted('ROLE_MM')) {
            $this->addFlash('warning', "Vous n'avez pas le droit de lancer la production d'une box !");
            return $this->redirectToRoute('index');
        }

        // On récupère le workflow
        $workflow = $registry->get($box, 'box_making');

        // Si on peut passer à l'étape suivante, on le fait
        if ($workflow->can($box, 'box_production')) {
            $workflow->apply($box, 'box_production');
        }

        // On sauvegarde en bdd
        $em->flush();

        // On redirige en affichant une notification
        $this->addFlash('notice', "Vous venez de lancer la production de la box [#$id] !");
        return $this->redirectToRoute('box_all');
    }

    /**
     * @Route("/box/{id}/send", name="box_sending", requirements={"id"="\d+"})
     * @param Box $box
     * @param Registry $registry
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function boxSending(Box $box, Registry $registry, EntityManagerInterface $em)
    {
        // On vérifie les droits de l'utilisateur
        if (!$this->isGranted('ROLE_MM')) {
            $this->addFlash('warning', "Vous n'avez pas les droits pour demander l'expédition des box !");
            return $this->redirectToRoute('index');
        }

        // On récupère le workflow
        $workflow = $registry->get($box, 'box_making');

        // Si on peut passer à l'étape suivante, on le fait
        if ($workflow->can($box, 'box_sent')) {
            $workflow->apply($box, 'box_sent');
            $box->setIsSent(true);
        }

        // On sauvegarde en bdd
        $em->flush();

        // On redirige en affichant une notification
        $this->addFlash('notice', "Vous venez de demander l'expédition des box !");
        return $this->redirectToRoute('box_all');
    }

    /**
     * @Route("/box/{id}/revision", name="box_revision", requirements={"id"="\d+"})
     * @param $id
     * @param Box $box
     * @param Registry $registry
     * @param EntityManagerInterface $em
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function boxRevision($id, Box $box, Registry $registry, EntityManagerInterface $em)
    {
        // On vérifie les droits de l'utilisateur
        if (!$this->isGranted('ROLE_PM')) {
            $this->addFlash('warning', "Vous n'avez pas les droits pour demander la révision de la box [#$id] !");
            return $this->redirectToRoute('index');
        }

        // On récupère le workflow
        $workflow = $registry->get($box, 'box_making');

        // Si on peut passer à l'étape suivante, on le fait
        if ($workflow->can($box, 'products_missing')) {
            $box->setIsValidate(false);
            $workflow->apply($box, 'products_missing');
        }

        // On sauvegarde en bdd
        $em->flush();

        // On redirige en affichant une notification
        $this->addFlash('notice', "Vous venez de demander la révision de la box [#$id] !");
        return $this->redirectToRoute('box_all');
    }

    /**
     * Fonction permettant d'initialiser toute les box à la transition "add_products" du workflow box_making
     * @param EntityManagerInterface $em
     * @param Registry $workflows
     * @param Security $security
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function initAllBoxes(EntityManagerInterface $em, Registry $workflows, Security $security)
    {
        if (!$security->isGranted(['ROLE_ADMIN'])) {
            $this->addFlash('warning', "Vous n'avez pas les droits pour effectuer cette action !");
            return $this->redirectToRoute('index');
        }

        $boxes = $em->getRepository(Box::class)->findAll();

        foreach ($boxes as $box) {
            $workflow = $workflows->get($box);
            $workflow->apply($box, 'add_products');
            $em->persist($box);
            $em->flush();
        }
    }
}