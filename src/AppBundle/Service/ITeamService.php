<?php
/**
 * Created by PhpStorm.
 * User: hallgató
 * Date: 2017.12.04.
 * Time: 14:53
 */

namespace AppBundle\Service;


use AppBundle\Entity\Team;
use Symfony\Component\Form\Test\FormInterface;

interface ITeamService
{
    /**
     * @return Team[]
     */
    public function getTeams();

    /**
     * @param $competitionId int
     * @return Team[]
     */
    public function getCompetitionTeams($competitionId);

    /**
     * @param $isVisible boolean
     * @return Team[]
     */
    public function getTeamsByVisibility($isVisible);

    /**
     * @param $te_id int
     * @return Team
     */
    public function getTeamById($te_id);

    /**
     * @param $oneTeam Team
     */
    public function saveTeam($oneTeam);

    /**
     * @param $te_id int
     */
    public function deleteTeam($te_id);

    /**
     * @param $oneTeam Team
     * @return FormInterface
     */
    public function getTeamForm($oneTeam);
}