<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Service\IUserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @var IUserService
     */
    private $userService;

    public function setContainer(ContainerInterface $container = null)
    {
        parent::setContainer($container);
        $this->userService = $this->get("app.userservice");
    }

    /**
     * @Route("/logout",name="logout")
     */
    public function logoutAction(Request $request)
    {
        $this->get('session')->clear();
        $this->addFlash('notice', "Logout successful");
        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $oneuser = new user();
        $formInterface = $this->userService->getLoginForm($oneuser);

        $formInterface->handleRequest($request);

        if ($formInterface->isSubmitted() && $formInterface->isValid()) {
            $arr = $this->userService->checkUser($oneuser);
            if(count($arr)!=0) {
                $this->get('session')->set("user", $oneuser->getUsName());
                $this->addFlash('notice', "Login successful. Welcome, {$oneuser->getUsName()}");
                return $this->redirectToRoute('matcheslist');
            }else {
                $this->addFlash('notice', 'NOT LOGGED IN!');
                return $this->redirectToRoute('homepage');
            }
        }
        return $this->render('login/login.html.twig', array("form" => $formInterface->createView()));
    }
    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request)
    {
        $oneuser = new user();
        $formInterface = $this->userService->getRegisterForm($oneuser);

        $formInterface->handleRequest($request);

        $us = $this->userService->getUser($oneuser->getUsName());
        if($us==null)
        {
            if ($formInterface->isSubmitted() && $formInterface->isValid()) {
                    $oneuser->setUsPass(sha1($oneuser->getUsPass()));
                    $this->userService->saveUser($oneuser);
                    $this->addFlash('notice', "Registration successful! Please, login to continue.");
                    return $this->redirectToRoute('homepage');
            }
        }
        else {
            $this->addFlash('notice', "Username already exists! Try again.");
            return $this->redirectToRoute('register');
        }
        return $this->render('login/register.html.twig', array("form" => $formInterface->createView()));
    }
}
