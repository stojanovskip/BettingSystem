<?php
/*
composer require --dev doctrine/doctrine-fixtures-bundle
        add: new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(), in AppKernel.php

php bin/console doctrine:generate:entities AppBundle/Entity/Brand
php bin/console doctrine:generate:entities AppBundle/Entity/Car
php bin/console doctrine:schema:drop --force --full-database
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force

php bin/console doctrine:fixtures:load --no-interaction -vvv
php bin/console cache:clear
 */
namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Bet;
use AppBundle\Entity\Choice;
use AppBundle\Entity\Match;
use AppBundle\Entity\Question;
use AppBundle\Entity\Competition;
use AppBundle\Entity\Team;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\Debug;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class DataLoader implements FixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    /** @var EntityManager */
    private $em;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    private function getCurrentEnvironment()
    {
        /** @var KernelInterface $kernel */
        $kernel = $this->container->get('kernel');
        return $kernel->getEnvironment();
    }


    public function load(ObjectManager $manager)
    {
        /**
         * @var $manager EntityManager
         */
        $this->em = $manager;
        $manager->getConnection()->getConfiguration()->setSQLLogger(null);

        $stackLogger = new \Doctrine\DBAL\Logging\DebugStack();
        $echoLogger = new \Doctrine\DBAL\Logging\EchoSQLLogger();
        $this->em->getConnection()->getConfiguration()->setSQLLogger($stackLogger);


        $user = new User();
        $user->setUsName("admin");
        $user->setUsPass(sha1("admin"));
        $this->em->persist($user);

        $team = new Team();
        $team->setTeName("Ferencvaros");
        $team->setTeNationality("HUN");
        $team->setTeAddress("Budapest");
        $this->em->persist($team);

        $team2 = new Team();
        $team2->setTeName("Vardar");
        $team2->setTeNationality("MKD");
        $team2->setTeAddress("Skopje");
        $this->em->persist($team2);

        $team3 = new Team();
        $team3->setTeName("Gyor");
        $team3->setTeNationality("HUN");
        $team3->setTeAddress("Gyor");
        $this->em->persist($team3);

        $team4 = new Team();
        $team4->setTeName("Podravka");
        $team4->setTeNationality("CRO");
        $team4->setTeAddress("Koprivnica");
        $this->em->persist($team4);

        $team5 = new Team();
        $team5->setTeName("Barcelona");
        $team5->setTeNationality("ESP");
        $team5->setTeAddress("Barcelona");
        $this->em->persist($team5);

        $team6 = new Team();
        $team6->setTeName("PSG");
        $team6->setTeNationality("FRA");
        $team6->setTeAddress("Paris");
        $this->em->persist($team6);
        $teams = array($team, $team2, $team3, $team4,$team5,$team6);
        for ($i=0; $i<10; $i++)
        {
            $match = new Match();
            $match->setMaTeam1($teams[rand(0,count($teams)-1)]);
            $t2 = $teams[rand(0,count($teams)-1)];
            while($t2==$match->getMaTeam1())
            {
                $t2 = $teams[rand(0,count($teams)-1)];
            }
            $match->setMaTeam2($t2);
            $match->setMaTeam1G(0);
            $match->setMaTeam2G(0);
            $date = new \DateTime();
            $date->setTime(20,45);
            if(rand(0,2)%2==0)
            {
                $date->setTime(20,45);
            }
            else {
                $date->setTime(12,00);
            }
            $match->setMaStart($date);
            $match->setMat($match->getMaTeam1()->getTeName()." : ".$match->getMaTeam2()->getTeName());
            $this->em->persist($match);
        }

        $this->em->flush();

        $this->em->clear();
    }
}



