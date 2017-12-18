<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 16-Dec-17
 * Time: 21:52
 */

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="bets")
 * @ORM\HasLifecycleCallbacks
 */
class Bet
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $bet_inserted;

    /**
     * @ORM\ManyToOne(targetEntity="Match", inversedBy="ma_bets")
     * @ORM\JoinColumn(name="bet_match", referencedColumnName="id", nullable=true)
     */
    private $bet_match;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="us_bet")
     * @ORM\JoinColumn(name="bet_user", referencedColumnName="id", nullable=true)
     */
    private $bet_user;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $bet_result;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $bet_amount;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
        $this->bet_inserted = new \DateTime();
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
     * @return mixed
     */
    public function getBetInserted()
    {
        return $this->bet_inserted;
    }

    /**
     * @param mixed $bet_inserted
     */
    public function setBetInserted($bet_inserted)
    {
        $this->bet_inserted = $bet_inserted;
    }

    /**
     * @return mixed
     */
    public function getBetMatch()
    {
        return $this->bet_match;
    }

    /**
     * @param mixed $bet_match
     */
    public function setBetMatch($bet_match)
    {
        $this->bet_match = $bet_match;
    }

    /**
     * @return mixed
     */
    public function getBetUser()
    {
        return $this->bet_user;
    }

    /**
     * @param mixed $bet_user
     */
    public function setBetUser($bet_user)
    {
        $this->bet_user = $bet_user;
    }

    /**
     * @return mixed
     */
    public function getBetResult()
    {
        return $this->bet_result;
    }

    /**
     * @param mixed $bet_result
     */
    public function setBetResult($bet_result)
    {
        $this->bet_result = $bet_result;
    }

    /**
     * @return mixed
     */
    public function getBetAmount()
    {
        return $this->bet_amount;
    }

    /**
     * @param mixed $bet_amount
     */
    public function setBetAmount($bet_amount)
    {
        $this->bet_amount = $bet_amount;
    }

}
