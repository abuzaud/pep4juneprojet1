<?php
/**
 * Created by Antoine Buzaud.
 * Date: 11/07/2018
 */

namespace App\Controller\Logger;


use App\Entity\Box;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;

class WorkflowEvents implements EventSubscriberInterface
{
    private $logger;

    public function __construct(FileLogger $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Fonction loggant les transitions d'une place à une autre
     * @param Event $event
     */
    public function onNewPlace(Event $event)
    {
        $this->logger->alert(sprintf(
            'La box "#%d" a effectué la transition "%s" depuis "%s" jusqu\'à "%s"',
            $event->getSubject()->getId(),
            $event->getTransition()->getName(),
            implode(', ', $event->getTransition()->getFroms()),
            implode(', ', $event->getTransition()->getTos())
        ));
    }

    /**
     * Ajout de gardien permettant de veiller à ce que
     * la place "add_products" ne puissent être vue si la box n'a aucun budget
     * @param GuardEvent $event
     */
    public function guardDatasAdded(GuardEvent $event)
    {
        /** @var Box $box */
        $box = $event->getSubject();
        $budget = $box->getBudget();
        $name = $box->getName();
        $description = $box->getDescription();
        $reference = $box->getReference();
        $products = $box->getProducts();

        // Si la fiche de la box n'est pas complète
        if (empty($budget) ||
            empty($name) ||
            empty($description) ||
            empty($reference) ||
            empty($products)
        ) {
            // On bloque les box
            $event->setBlocked(true);
        }
    }

    /**
     * Fonction permettant d'ajouter des EventListener
     * pour effectuer diverses opérations
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return array(
            'workflow.box_making.completed' => 'onNewPlace',
            'workflow.box_making.datas_added' => 'guardDatasAdded'
        );
    }
}