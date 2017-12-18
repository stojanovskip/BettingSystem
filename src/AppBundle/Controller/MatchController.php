<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Match;
use AppBundle\Service\IMatchService;
use AppBundle\Service\IUserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class MatchController
    extends Controller
{
    /**
     * @var IMatchService
     */
    private $matchService;

    /**
     * @var IUserService
     */
    private $userService;
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
        $this->matchService=$this->get("app.matchservice");
        parent::setContainer($container);
        $this->userService=$this->get("app.userservice");
    }

    /**
     * @Route("/matches", name="matcheslist")
     * @Route("/matches/list", name="matcheslist_explicit")
     * @Route("/matches/list/t/{teamId}", name="matcheslist_team")
     */
    public function getList(Request $request, $teamId=0) {

        $arr = $this->matchService->getMatches();

        foreach($arr as $m)
        {
            $d = new \DateTime;
            if($d> $m->getMaStart())
            {
                $m->setMaTeam1G(1);
                $m->setMaTeam2G(1);
            }
        }
        //var_dump($arr);
            return $this->render('matches/matcheslist.html.twig', array('matcheslist' => $arr));
    }

    /**
     * @Route("/matches/edit/{id}", name="matchesedit")
     */
    public function getForm(Request $request, $id=0)
    {
        // fix ChoiceService / getChoiceForm / $oneCar
        if ($id){
            $onematch = $this->matchService->getMatchById($id);
        } else {
        $onematch = new match();
    }

        $formInterface = $this->matchService->getMatchForm($onematch);

        $formInterface->handleRequest($request);
        if ($formInterface->isSubmitted() && $formInterface->isValid())
        {
            $this->matchService->saveMatch($onematch);
            $this->addFlash('notice', 'Match SAVED!');
            return $this->redirectToRoute('matcheslist');
        }

        return $this->render('matches/matchesform.html.twig', array("form"=>$formInterface->createView()) );
    }

    /**
     * @Route("/matches/{id}", name="matchesshow")
     */
    public function getDatasheet($id){
        $onematch = $this->matchService->getMatchById($id);
        return $this->render('matches/matchessheet.html.twig', array("match"=>$onematch) );
    }

    /**
     * @Route("/matches/delete/{id}", name="matchesdel")
     */
    public function delete($id) {
        $this->matchService->deleteMatch($id);
        $this->addFlash('notice', 'Match DELETED!');
        return $this->redirectToRoute('matcheslist');
    }
}