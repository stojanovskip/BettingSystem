<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Team;
use AppBundle\Service\ITeamService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class _08_TeamController extends Controller
{
    /**
     * @var ITeamService
     */
    private $teamService;

    /*
    public function __construct($choiceService)
    {
        $this->choiceService=$choiceService;
        $this->choiceService=$this->get("app.choiceservice");
        $repository = $this->getDoctrine()->getRepository('AppBundle:Choice');

        // NO CONTAINER, NO DOCTRINE, etc etc etc!
        // google: symfony create controller as service
    }
    */

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->teamService=$this->get("app.teamservice");
    }

    /**
     * @Route("/teams", name="teamslist")
     * @Route("/teams/list", name="teamslist_explicit")
     * @Route("teams/list/c/{competitionId}", name="teamslist_competition")
     */
    public function getList(Request $request, $competitionId=0) {
        if ($competitionId) {
            $arr=$this->teamService->getCompetitionTeams($competitionId);
        } else {
            $filter = $request->query->get('visible');
            if ($filter !== null) {
                $arr = $this->teamService->getTeamsByVisibility($filter);
            } else {
                $arr = $this->teamService->getTeams();//error
            }
        }

        $response = $this->render('teams/teamslist.html.twig', array('teamslist'=>$arr));
        // $response->headers
        // $response->setCache()
        return $response;
    }

    /**
     * @Route("/teams/edit/{id}", name="teamsedit")
     */
    public function getForm(Request $request, $id=0) {
        // fix ChoiceService / getChoiceForm / $oneCar
        if ($id){
            $oneteam = $this->teamService->getTeamById($id);
        } else {
            $oneteam = new team();
        }

        $formInterface = $this->teamService->getTeamForm($oneteam);

        $formInterface->handleRequest($request);
        if ($formInterface->isSubmitted() && $formInterface->isValid())
        {
            $this->teamService->saveTeam($oneteam);
            $this->addFlash('notice', 'Team SAVED!');
            return $this->redirectToRoute('teamslist');
        }

        return $this->render('teams/teamsform.html.twig', array("form"=>$formInterface->createView()) );
    }

    /**
     * @Route("/teams/{id}", name="teamsshow")
     */
    public function getDatasheet($id){
        $oneteam = $this->teamService->getTeamById($id);
        return $this->render('teams/teamssheet.html.twig', array("team"=>$oneteam) );
    }

    /**
     * @Route("/teams/delete/{id}", name="teamsdel")
     */
    public function delete($id) {
        $this->teamService->deleteTeam($id);
        $this->addFlash('notice', 'Team DELETED!');
        return $this->redirectToRoute('teamslist');
    }
}