<?php

namespace AppBundle\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class CrudService {
    /** @var EntityManager  */
    protected $em;
    /** @var FormFactory  */
    protected $formFactory;
    /** @var Request */
    protected $request;

    /**
     * @param $entityManager EntityManager
     * @param $formFactory FormFactory
     * @param $request Request
     */
    public function __construct($entityManager, $formFactory, $request)
    {
        $this->em=$entityManager;
        $this->formFactory=$formFactory;
        $this->request=$request;
    }

    /**
     * @return EntityRepository
     */
    abstract function getRepo();

    // TODO: carefully add additional generic functions...
}