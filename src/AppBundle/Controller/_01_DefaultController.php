<?php

namespace AppBundle\Controller;

use AppBundle\Entity\User;
use AppBundle\Service\IUserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class _01_DefaultController extends Controller
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
     * @param $num int
     * @return bool
     */
    private function isPrime($num)
    {
        if ($num < 2) return false;
        $lim = sqrt($num);
        for ($i = 2; $i <= $lim; $i++) {
            if ($num % $i == 0) return false;
        }
        return true;
    }

    /**
     * @param $n int
     * @return int
     */
    private function factor($n)
    {
        $ret = 1;
        for ($i = 2; $i <= $n; $i++) {
            $ret = $ret * $i;
        }
        return $ret;
    }

    /**
     * @param $n int
     * @param $m int
     * @return float
     */
    function power($n, $m)
    {
        $ret = 1;
        if ($m < 0) {
            $negative = true;
            $m = -$m;
        } else {
            $negative = false;
        }
        for ($i = 1; $i <= $m; $i++) {
            $ret = $ret * $n;
        }
        if ($negative) $ret = 1 / $ret;
        return $ret;
    }

    // 0 1 1 2 3 5 8 13 21 34 55

    /**
     * @param $n int
     * @return int
     */
    function fibo1($n)
    {
        if ($n <= 0) return 0;
        if ($n == 1) return 1;
        return $this->fibo1($n - 1) + $this->fibo1($n - 2);
    }

    /**
     * @param $n int
     * @return int
     */
    function fibo2($n)
    {
        if ($n <= 0) return 0;
        if ($n == 1) return 1;
        $prev = 1;
        $prevprev = 0;
        for ($i = 2; $i <= $n; $i++) {
            $next = $prev + $prevprev;
            $prevprev = $prev;
            $prev = $next;
        }
        return $next;
    }

    function divs($n)
    {
        $s = "1, ";
        $lim = sqrt($n);
        for ($i = 2; $i <= $lim; $i++) {
            if ($n % $i == 0) {
                $other = $n / $i;
                if ($other != $i) {
                    $s .= "{$i}, {$other}, ";
                } else {
                    $s .= "{$i}, ";
                }
            }
        }
        $s .= "{$n}";
        return $s;
    }

    /**
     * @return string
     */
    public function getExercise1()
    {
        $output = "";
        $a = rand(100, 1000);
        $b = rand(1, 20);
        $output .= "A={$a} ; B={$b} <br>";
        $output .= "B! = {$this->factor($b)}<br>";
        $output .= "A^B = {$this->power($a, $b)}<br>";
        $output .= "A^(-B) = {$this->power($a, -$b)}<br>";
        $output .= "FIB1(B) = {$this->fibo1($b)}<br>";
        $output .= "FIB2(B) = {$this->fibo2($b)}<br>";
        $output .= "DIVS(A) = {$this->divs($a)}<br>";
        return $output;
    }

    /**
     * @return string
     */
    private function getExercise2()
    {
        $output = "<hr>";
        $tpl_table = file_get_contents("../html/table.html");
        $tpl_cell = file_get_contents("../html/cellnormal.html");
        $tpl_cellprime = file_get_contents("../html/cellprime.html");
        $tpl_rowsep = file_get_contents("../html/rowsep.html");

        $max = 0;
        $output .= $tpl_table;
        $rows = "";
        for ($i = 1; $i <= 100; $i++) {
            $num = rand(0, 999);
            if ($this->isPrime($num)) {
                $rows .= str_replace("[NUM]", $num, $tpl_cellprime);
            } else {
                $rows .= str_replace("[NUM]", $num, $tpl_cell);
            }
            if ($i % 10 == 0) {
                $rows .= $tpl_rowsep;
            }
            if ($num > $max) {
                $max = $num;
            }

        }
        $output = str_replace("[ROWS]", $rows, $output);
        $output = str_replace("[MAX]", $max, $output);
        return $output;
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
