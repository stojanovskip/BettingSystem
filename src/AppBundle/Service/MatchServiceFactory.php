<?php
namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class MatchServiceFactory
{
    /** @var EntityManager  */
    private $entityManager;
    /** @var FormFactory  */
    private $formFactory;
    /** @var Request  */
    private $request; // Do we need this?

    /**
     * ChoiceService constructor.
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
     * @return IMatchService
     */
    public function getService()
    {
        return new MatchService($this->entityManager, $this->formFactory, $this->request);
    }
}