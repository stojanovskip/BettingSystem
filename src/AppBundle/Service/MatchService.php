<?php
namespace AppBundle\Service;


use AppBundle\Entity\Match;
use AppBundle\Entity\Team;
use Doctrine\ORM\EntityManager;
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

class MatchService extends CrudService implements  IMatchService {
    public function __construct(EntityManager $entityManager, FormFactory $formFactory, Request $request=null)
    {
        parent::__construct($entityManager, $formFactory, $request);
    }

    public function getRepo(){
        return $this->em->getRepository(Match::class);
    }

    /**
     * @return Match[]
     */
    public function getMatches()
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @param $matchId int
     * @return Team[]
     */
    public function getMatchTeams($matchId)
    {
        return $this->getRepo()->findBy(array('te_match' => $matchId));
    }

    /**
     * @param $teamId int
     * @return Match[]
     */
    public function getTeamMatches($teamId)
    {
        return $this->getRepo()->findBy(array('id' => $teamId));
    }

    /**
     * @param $matchId int
     * @return Match
     */
    public function getMatchById($matchId)
    {
        $oneMatch = $this->getRepo()->find($matchId);
        if(!$oneMatch)
        {
            throw new NotFoundHttpException("ENTITY NOT FOUND: {$matchId}");
        }
        return $oneMatch;
    }

    /**
     * @param $oneMatch Match
     */
    public function saveMatch($oneMatch)
    {
        $this->em->persist($oneMatch);
        $this->em->flush();
    }

    /**
     * @param $matchId int
     */
    public function deleteMatch($matchId)
    {
        $oneMatch = $this->getMatchById($matchId);
        $this->em->remove($oneMatch);
        $this->em->flush();
    }

    /**
     * @param $oneMatch Match
     * @return FormInterface
     */
    public function getMatchForm($oneMatch)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $oneMatch);

        $form->add("ma_team1", EntityType::class, array(
        'class' => 'AppBundle:Team',
        'choice_label' => 'te_name',
        'choice_value' => 'id'
        ));
        $form->add("ma_team2", EntityType::class, array(
            'class' => 'AppBundle:Team',
            'choice_label' => 'te_name',
            'choice_value' => 'id'
        ));
//        $form->add("bet_result", ChoiceType::class, array("choices"=>array("1"=>"1", "X"=>"X","2"=>"2")));

  //      $form->add("bet_amount", NumberType::class, array('label'=>'$'));
        // TextareaType::class, NumberType::class
        $form->add("save", SubmitType::class, array('label'=>'Save match'));

        return $form->getForm();
    }
}