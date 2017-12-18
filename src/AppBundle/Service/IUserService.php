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


interface IUserService
{
    /**
     * @return User[]
     */
    public function getUsers();

    /**
     * @param $userId int
     * @return Bet[]
     */
    public function getUserBets($userId);

    /**
     * @param $id int
     * @return User
     */
    public function getUserById($id);

    /**
     * @param $oneUser User
     */
    public function saveUser($oneUser);

    /**
     * @param $id int
     */
    public function deleteUser($id);

    /**
     * @param $oneUser User
     * @return FormInterface
     */
    public function getLoginForm($oneUser);

    /**
     * @param $oneUser User
     * @return FormInterface
     */
    public function getRegisterForm($oneUser);
    /**
     * @param $oneUser string
     * @return User[]
     */
    public function getUser($oneUser);
    /**
     * @param $oneUser User
     * @return boolean
     */
    public function checkUser($oneUser);
}