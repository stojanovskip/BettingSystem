<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 10-Dec-17
 * Time: 20:58
 */

namespace AppBundle\Service;

use AppBundle\Entity\Bet;
use AppBundle\Entity\User;
use Symfony\Component\Form\Test\FormInterface;


interface IBetService
{
    /**
     * @return Bet[]
     */
    public function getBets();

    /**
     * @param $betId int
     * @return User[]
     */
    public function getBetUsers($betId);

    /**
     * @param $userId int
     * @return Bet[]
     */
    public function getUserBets($userId);

    /**
     * @param $id int
     * @return Bet
     */
    public function getBetById($id);

    /**
     * @param $oneBet Bet
     */
    public function saveBet($oneBet);

    /**
     * @param $id int
     */
    public function deleteBet($id);

    /**
     * @param $oneBet Bet
     * @return FormInterface
     */
    public function getBetForm($oneBet);
}