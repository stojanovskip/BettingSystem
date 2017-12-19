<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 10-Dec-17
 * Time: 20:57
 */

namespace AppBundle\Service;

use AppBundle\Entity\Bet;
use AppBundle\Entity\Match;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BetService extends CrudService implements  IBetService
{
    /**
     * @return EntityRepository
     */
    function getRepo()
    {
        return $this->em->getRepository(Bet::class);
    }
    /**
     * @return EntityRepository
     */
    function getMatchesRepo()
    {
        return $this->em->getRepository(Match::class);
    }
    /**
     * @return Bet[]
     */
    public function getBets()
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @param $matchId int
     * @return Bet[]
     */
    public function getMatchBets($matchId)
    {
        return $this->getRepo()->findBy(array('bet_match' => $matchId));
    }

    /**
     * @param $id int
     * @return Bet
     */
    public function getBetById($id)
    {
        $oneBet = $this->getRepo()->find($id);
        return $oneBet;
    }

    /**
     * @param $oneBet Bet
     */
    public function saveBet($oneBet)
    {
        $this->em->persist($oneBet);
        $this->em->flush();
    }

    /**
     * @param $id int
     */
    public function deleteBet($id)
    {
        $oneBet = $this->getBetById($id);
        $this->em->remove($oneBet);
        $this->em->flush();
    }

    /**
     * @param $oneBet Bet
     * @return FormInterface
     */
    public function getBetForm($oneBet)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $oneBet);

        $form->add("bet_match", EntityType::class, array(
            'class' => 'AppBundle:Match',
            'choice_label' => 'mat',
            'choice_value' => 'id'
        ));
        $form->add("bet_result", ChoiceType::class, array("choices"=>array("1"=>"1", "X"=>"X","2"=>"2")));

        $form->getData();
        $form->add("bet_amount", NumberType::class, array('label'=>'$'));
        // TextareaType::class, NumberType::class
        $form->add("save", SubmitType::class, array('label'=>'Place Bet'));

        return $form->getForm();
    }

    /**
     * @param $userId int
     * @return Bet[]
     */
    public function getUserBets($userId)
    {
        return $this->getRepo()->findBy(array('bet_user' => $userId));
    }
}