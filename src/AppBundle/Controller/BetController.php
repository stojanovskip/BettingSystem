<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Bet;
use AppBundle\Entity\Match;
use AppBundle\Service\IBetService;
use AppBundle\Service\IMatchService;
use AppBundle\Service\IUserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class BetController
    extends Controller
{
    /**
     * @var IBetService
     */
    private $betService;

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
        $this->betService=$this->get("app.betservice");
        parent::setContainer($container);
        $this->matchService=$this->get("app.matchservice");
        parent::setContainer($container);
        $this->userService=$this->get("app.userservice");
    }

    /**
     * @Route("/bets", name="betslist")
     * @Route("/bets/list", name="betslist_explicit")
     * @Route("/bets/list/b/{userId}", name="betslist_user")
     */
    public function getList(Request $request, $userId=0) {
        $usrs = $this->userService->getUser($this->get('session')->get("user"));

        if(count($usrs)!=0)
        {
            $userId = $usrs[0]->getId();
            $arr = $this->betService->getUserBets($userId);
            return $this->render('bets/betslist.html.twig', array('betslist'=>$arr));

        }
        else {
            $this->addFlash('notice', 'You need to login in order to access this page.');
            return $this->redirectToRoute('homepage');

        }

    }

    /**
     * @Route("/bets/edit/{id}", name="betsedit")
     */
    public function getForm(Request $request, $id=1) {
        $usrs = $this->userService->getUser($this->get('session')->get("user"));

        if(count($usrs)!=0) {
            $onematch = $this->matchService->getmatchById($id);
            $arr = $this->userService->getUser($this->get('session')->get("user"));
            $onebet = new bet();
            $onebet->setBetMatch($onematch);
            $onebet->setBetUser($arr[0]);

            if (new \DateTime < $onematch->getMaStart()) {
                $formInterface = $this->betService->getbetForm($onebet);

                $formInterface->handleRequest($request);
                if ($formInterface->isSubmitted() && $formInterface->isValid()) {
                    $this->betService->saveBet($onebet);
                    $this->addFlash('notice', $this->get('session')->get('user'));
                    return $this->redirectToRoute('betslist');
                }
            } else {
                $this->addFlash('notice', 'The game has already started! You cannot place bets now.');
                return $this->redirectToRoute('matcheslist');
            }
            return $this->render('bets/betsform.html.twig', array("form" => $formInterface->createView()));
            }
            else {
            $this->addFlash('notice', 'You need to login in order to access this page.');
            return $this->redirectToRoute('homepage');

        }
    }

    /**
     * @Route("/bets/{id}", name="betsshow")
     */
    public function getDatasheet($id){
        $onebet = $this->betService->getBetById($id);
        return $this->render('bets/betssheet.html.twig', array("bet"=>$onebet) );
    }

    /**
     * @Route("/bets/delete/{id}", name="betsdel")
     */
    public function delete($id) {
        $this->betService->deleteBet($id);
        $this->addFlash('notice', 'Bet DELETED!');
        return $this->redirectToRoute('betslist');
    }
}