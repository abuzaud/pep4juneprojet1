<?php
/**
 * Created by Antoine Buzaud.
 * Date: 11/07/2018
 */

namespace App\Controller\Logger;


use App\Entity\Box;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\Event;
use Symfony\Component\Workflow\Event\GuardEvent;

class WorkflowEvents implements EventSubscriberInterface
{
    private $logger;

    public function __construct(LoggerInterface $logger)
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
            'La box "#%s" a effectué la transition "%s" depuis "%s" jusqu\'à "%s"',
            $event->getSubject()->getId(),
            $event->getTransition()->getName(),
            implode(', ', array_keys($event->getMarking()->getPlaces())),
            implode(', ', $event->getTransition()->getTos())
        ));
    }

    /**
     * Ajout de gardien permettant de veiller à ce que
     * la place "add_products" ne puissent être vue si la box n'a aucun budget
     */
    public function guardAddProducts(GuardEvent $event)
    {
        /** @var Box $box */
        $box = $event->getSubject();
        $budget = $box->getBudget();

        if(empty($budget)){
            // On bloque les box sans budget
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
            'workflow.box_making.entered' => 'onNewPlace',
            'workflow.box_making.add_products' => array('guardAddProducts')
        );
    }
}