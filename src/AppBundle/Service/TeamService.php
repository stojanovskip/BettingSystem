<?php
/**
 * Created by PhpStorm.
 * User: hallgató
 * Date: 2017.12.04.
 * Time: 14:51
 */

namespace AppBundle\Service;


use AppBundle\Entity\Team;
use Doctrine\ORM\EntityManager;
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

class TeamService extends CrudService implements  ITeamService {

    public function __construct(EntityManager $entityManager, FormFactory $formFactory, Request $request=null)
    {
        parent::__construct($entityManager, $formFactory, $request);
    }

    public function getRepo(){
        return $this->em->getRepository(Team::class);
    }
    /**
     * @return Team[]
     */
    public function getTeams()
    {
        return $this->getRepo()->findAll();
    }


    /**
     * @param $competitionId int
     * @return Team[]
     */
    public function getCompetitionTeams($competitionId)
      {
          //return $this->em->getRepository(Question::class)->find($questionId)->getQuChoices();
          return $this->getRepo()->findBy(array('id' => $competitionId));
      }

    /**
     * @param $isVisible boolean
     * @return Team[]
     */
    public function getTeamsByVisibility($isVisible)
    {

        $query = $this->em->createQuery("
            SELECT c
            FROM AppBundle:Team t
            WHERE t.te_visible=:visible
            ORDER BY t.te_id ASC ")
            ->setParameter('visible', $isVisible);


        // Doctrine Query Builder
        // could use via the repo too

        $qb = $this->em->createQueryBuilder();
        $qb->select('c')
            ->from('AppBundle:Team', 't')
            ->where('t.te_visible = :visible')
            ->orderBy('t.te_id', 'ASC')
            ->setParameter('visible', $isVisible)
            ->getQuery();
        return $query->getResult();
    }

    /**
     * @param $te_id int
     * @return Team
     */
    public function getTeamById($te_id)
    {
        $oneTeam = $this->getRepo()->find($te_id);
        if (!$oneTeam){
            throw new NotFoundHttpException("ENTITY NOT FOUND: {$te_id}");
        }
        return $oneTeam;
    }

    /**
     * @param $oneTeam Team
     */
    public function saveTeam($oneTeam)
    {
        $this->em->persist($oneTeam);
        $this->em->flush();
    }

    /**
     * @param $te_id int
     */
    public function deleteTeam($te_id)
    {
        $oneTeam = $this->getTeamById($te_id);
        $this->em->remove($oneTeam);
        $this->em->flush();
    }

    /**
     * @param $oneTeam Team
     * @return FormInterface
     */
    public function getTeamForm($oneTeam)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $oneTeam);


        $form->add("te_name", TextType::class);
        $form->add("te_nationality", TextType::class);
        $form->add("te_address", TextType::class);
        $form->add("save", SubmitType::class, array('label'=>'Save Team'));

        return $form->getForm();
    }
}