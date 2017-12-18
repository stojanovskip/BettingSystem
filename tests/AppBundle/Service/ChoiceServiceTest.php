<?php
namespace Tests\AppBundle\Service;

use Doctrine\Common\Util\Debug;
use PHPUnit\Framework\TestCase;
use AppBundle\Entity\Choice;
use AppBundle\Entity\Question;
use AppBundle\Service\IChoiceService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\DependencyInjection\ContainerInterface;


class ChoiceServiceTest extends TestCase
{
    /*
composer require --dev phpunit/phpunit ^5.7
        (6.1 is only for PHP 7+)
Change files DataLoader.php (disable output), choiceService (allow null Request parameter)
     */
    public function testTrue(){
        $this->assertEquals(true, true);
    }

    /** @var \AppKernel */
    protected static $application;

    /**
     * @var EntityManager
     */
    protected static $em;

    /**
     * @var ContainerInterface
     */
    protected static $container;

    /**
     * @var IChoiceService
     */
    protected static $service;

    /**
     * @var Question
     */
    protected static $colorQ;

    protected static function getApplication()
    {
        if (self::$application === null) {
            $kernel = new \AppKernel('test', true);
            $kernel->boot();
            self::$application = new Application($kernel);
            self::$application->setAutoExit(false);
            self::$container = $kernel->getContainer();
            self::$service = self::$container->get('app.choiceservice');
            self::$em = self::$container->get('doctrine.orm.entity_manager');
        }
        return self::$application;
    }

    protected static function runCommand($cmd){
        self::getApplication()->run(new StringInput($cmd));
    }

    protected function setUp()
    {
        self::runCommand('doctrine:database:drop --force -q');
        self::runCommand('doctrine:database:create -q');
        self::runCommand('doctrine:schema:update --force -q');
        self::runCommand('doctrine:fixtures:load --no-interaction -q');

        self::$colorQ = self::$em->getRepository(Question::class)->findOneBy(array('qu_id'=>'1'));
    }

    public function testMustExist(){
        self::assertNotNull(self::$colorQ);
    }

    public function testGetAll(){
        $choices = self::$service->getChoices();
        self::assertEquals(7, count($choices));
    }

    private function createChoice(){
        $choice = new Choice();
        $choice->setChoQuestion(self::$colorQ);
        $choice->setChoText("An average choice");
        $choice->setChoNumvotes(-1);
        $choice->setChoVisible(true);
        return $choice;
    }

    public function testAdd(){
        $choice = $this->createchoice();
        self::$service->savechoice($choice);

        $choices = self::$service->getchoices();
        self::assertEquals(8, count($choices));
        $choiceFromDb = self::$em->getRepository(Choice::class)->findOneBy(array('cho_numvotes'=>'-1'));
        self::assertNotNull($choiceFromDb);

        return $choice;
    }

    /**
     * @depends testAdd
     */
    public function testAddAndRemove(){
        $choice = $this->createchoice();
        self::$service->savechoice($choice);
        self::$service->deletechoice($choice->getChoId());

        $choices = self::$service->getchoices();
        self::assertEquals(7, count($choices));
        $choiceFromDb = self::$em->getRepository(Choice::class)->findOneBy(array('cho_numvotes'=>'-1'));
        self::assertNull($choiceFromDb);
    }

}
