<?php
/**
 * Created by PhpStorm.
 * User: hallgató
 * Date: 2017.12.04.
 * Time: 14:52
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class TeamServiceFactory
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
     * @return ITeamService
     */
    public function getService()
    {
        return new TeamService($this->entityManager, $this->formFactory, $this->request);
    }
}