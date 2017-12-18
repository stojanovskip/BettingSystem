<?php

namespace AppBundle\Service;


use AppBundle\Entity\Match;
use AppBundle\Entity\Team;
use Symfony\Component\Form\Test\FormInterface;

interface IMatchService{
    /**
     * @return Match[]
     */
    public function getMatches();

    /**
     * @param $matchId int
     * @return Team[]
     */
    public function getMatchTeams($matchId);

    /**
     * @param $teamId int
     * @return Match[]
     */
    public function getTeamMatches($teamId);

    /**
     * @param $matchId int
     * @return Match
     */
    public function getMatchById($matchId);

    /**
     * @param $oneMatch Match
     */
    public function saveMatch($oneMatch);

    /**
     * @param $matchId int
     */
    public function deleteMatch($matchId);

    /**
     * @param $oneMatch Match
     * @return FormInterface
     */
    public function getMatchForm($oneMatch);
}
