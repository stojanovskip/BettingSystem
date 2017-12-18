<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 10-Dec-17
 * Time: 20:57
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class UserServiceFactory
{
    /** @var EntityManager  */
    private $entityManager;
    /** @var FormFactory  */
    private $formFactory;
    /** @var Request  */
    private $request; // Do we need this?

    /**
     * CompetitionService constructor.
     * @param $entityManager EntityManager
     * @param $formFactory FormFactory
     * @param $requestStack RequestStack
     */
    public function __construct($entityManager, $formFactory, $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
        $this->request = $requestStack->getCurrentRequest();
    }

    /**
     * @return IUserService
     */
    public function getService()
    {
        return new UserService($this->entityManager, $this->formFactory, $this->request);
    }
}