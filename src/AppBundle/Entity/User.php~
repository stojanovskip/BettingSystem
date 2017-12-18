<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 01-Dec-17
 * Time: 13:29
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $us_name;

    /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    private $us_pass;

    /**
     * @ORM\OneToOne(targetEntity="Bet", mappedBy="bet_user")
     */
    private $us_bet;

    public function __construct()
    {

    }

    public function __toString()
    {
        return $this->us_name;
    }

    // AUTO GENERATED


    /**
     * Get usName
     *
     * @return string
     */
    public function getUsName()
    {
        return $this->us_name;
    }

    /**
     * Set usPass
     *
     * @param string $usPass
     *
     * @return User
     */
    public function setUsPass($usPass)
    {
        $this->us_pass = $usPass;

        return $this;
    }

    /**
     * Get usPass
     *
     * @return string
     */
    public function getUsPass()
    {
        return $this->us_pass;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @param mixed $us_name
     */
    public function setUsName($us_name)
    {
        $this->us_name = $us_name;
    }

    /**
     * @return mixed
     */
    public function getUsBet()
    {
        return $this->us_bet;
    }

    /**
     * @param mixed $us_bet
     */
    public function setUsBet($us_bet)
    {
        $this->us_bet = $us_bet;
    }

}
