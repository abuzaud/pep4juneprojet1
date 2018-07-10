<?php

namespace App\User;


use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UserRequestHandler
{

    private $manager, $userFactory, $dispatcher;

    /**
     * UserRequestHandler constructor.
     * @param ObjectManager $manager
     * @param UserFactory $userFactory
     * @param EventDispatcherInterface $dispatcher
     * @internal param UserFactory $user
     */
    public function __construct(ObjectManager $manager, UserFactory $userFactory, EventDispatcherInterface $dispatcher)
    {
        $this->manager = $manager;
        $this->userFactory = $userFactory;
        $this->dispatcher = $dispatcher;
    }

    public function registerAsUser(UserRequest $userRequest): User
    {
        // On définit le role de l'utilisateur
        $userRequest->setRoles(['ROLE_USER']);

        // On enregistre l'utilisateur en base de données
        $user = $this->persistRegistration($userRequest);

        return $user;
    }

    public function registerAsSupplier(UserRequest $userRequest): User
    {
        $userRequest->setRoles(['ROLE_SUPPLIER']);
        $user = $this->persistRegistration($userRequest);

        return $user;
    }

    public function registerAsPurchasingManager(UserRequest $userRequest): User
    {
        $userRequest->setRoles(['ROLE_PM']);
        $user = $this->persistRegistration($userRequest);

        return $user;
    }

    public function registerAsMarketingOfficer(UserRequest $userRequest): User
    {
        $userRequest->setRoles(['ROLE_MO']);
        $user = $this->persistRegistration($userRequest);

        return $user;
    }

    public function registerAsAdmin(UserRequest $userRequest): User
    {
        $userRequest->setRoles(['ROLE_ADMIN']);
        $user = $this->persistRegistration($userRequest);

        return $user;
    }

    public function persistRegistration(UserRequest $userRequest): User
    {
        // On appel notre Factory pour créer notre Objet User
        $user = $this->userFactory->createFromUserRequest($userRequest);

        // On sauvegarde en BDD notre User
        $this->manager->persist($user);
        $this->manager->flush();

        // On retourne l'utilisateur
        return $user;
    }
}