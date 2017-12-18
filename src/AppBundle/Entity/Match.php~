<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 16-Dec-17
 * Time: 21:17
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="match")
 */
class Match
{

    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $ma_win_c;

    /**
     * @ORM\Column(type="float")
     */
    private $ma_draw_c;

    /**
     * @ORM\Column(type="float")
     */
    private $ma_lose_c;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="te_home_matches")
     * @ORM\JoinColumn(name="ma_team1_q", referencedColumnName="id")
     */
    private $ma_team1;

    /**
     * @ORM\Column(type="integer")
     */
    private $ma_team1_g;

    /**
     * @ORM\Column(type="integer")
     */
    private $ma_team2_g;

    /**
     * @ORM\ManyToOne(targetEntity="Team", inversedBy="te_away_matches")
     * @ORM\JoinColumn(name="ma_team2_q", referencedColumnName="id")
     */
    private $ma_team2;


    /**
     * @ORM\Column(type="string", length=100,nullable=true)
     */
    private $mat;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $ma_result;

    /**
     * @ORM\OneToMany(targetEntity="Bet", mappedBy="bet_match")
     */
    private $ma_bets;


    public function __construct()
    {
        $this->ma_bets = new ArrayCollection();
        $this->setMaWinC(rand(100,300)/100);
        $this->setMaLoseC(rand(100,300)/100);
        $this->setMaDrawC(rand(100,300)/100);
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
    public function getMaWinC()
    {
        return $this->ma_win_c;
    }

    /**
     * @param mixed $ma_win_c
     */
    public function setMaWinC($ma_win_c)
    {
        $this->ma_win_c = $ma_win_c;
    }

    /**
     * @return mixed
     */
    public function getMaDrawC()
    {
        return $this->ma_draw_c;
    }

    /**
     * @param mixed $ma_draw_c
     */
    public function setMaDrawC($ma_draw_c)
    {
        $this->ma_draw_c = $ma_draw_c;
    }

    /**
     * @return mixed
     */
    public function getMaLoseC()
    {
        return $this->ma_lose_c;
    }

    /**
     * @param mixed $ma_lose_c
     */
    public function setMaLoseC($ma_lose_c)
    {
        $this->ma_lose_c = $ma_lose_c;
    }


    /**
     * @return mixed
     */
    public function getMaResult()
    {
        return $this->ma_result;
    }

    /**
     * @param mixed $ma_result
     */
    public function setMaResult($ma_result)
    {
        $this->ma_result = $ma_result;
    }

    /**
     * @return mixed
     */
    public function getMaBets()
    {
        return $this->ma_bets;
    }

    /**
     * @param mixed $ma_bets
     */
    public function setMaBets($ma_bets)
    {
        $this->ma_bets = $ma_bets;
    }

    public function __toString()
    {
        return $this->getMaTeam1G()->getTeName()." : ".$this->getMaTeam2G()->getTeName();
    }


    /**
     * Add maBet
     *
     * @param Bet $maBet
     *
     * @return Match
     */
    public function addMaBet(Bet $maBet)
    {
        $this->ma_bets[] = $maBet;

        return $this;
    }

    /**
     * Remove maBet
     *
     * @param \AppBundle\Entity\Bet $maBet
     */
    public function removeMaBet(\AppBundle\Entity\Bet $maBet)
    {
        $this->ma_bets->removeElement($maBet);
    }

    /**
     * @ORM\Column(type="datetime")
     */
    private $ma_start;

    /**
     * @return mixed
     */
    public function getMat()
    {
        return $this->getMaTeam1()->getTeName()." : ".$this->getMaTeam2()->getTeName();
    }

    /**
     * @param mixed $mat
     */
    public function setMat($mat)
    {
        $this->mat = $mat;
    }

    /**
     * @return mixed
     */
    public function getMaTeam1()
    {
        return $this->ma_team1;
    }

    /**
     * @param mixed $ma_team1
     */
    public function setMaTeam1($ma_team1)
    {
        $this->ma_team1 = $ma_team1;
    }

    /**
     * @return mixed
     */
    public function getMaTeam1G()
    {
        return $this->ma_team1_g;
    }

    /**
     * @param mixed $ma_team1_g
     */
    public function setMaTeam1G($ma_team1_g)
    {
        $this->ma_team1_g = $ma_team1_g;
    }

    /**
     * @return mixed
     */
    public function getMaTeam2G()
    {
        return $this->ma_team2_g;
    }

    /**
     * @param mixed $ma_team2_g
     */
    public function setMaTeam2G($ma_team2_g)
    {
        $this->ma_team2_g = $ma_team2_g;
    }

    /**
     * @return mixed
     */
    public function getMaTeam2()
    {
        return $this->ma_team2;
    }

    /**
     * @param mixed $ma_team2
     */
    public function setMaTeam2($ma_team2)
    {
        $this->ma_team2 = $ma_team2;
    }

    /**
     * @return mixed
     */
    public function getMaStart()
    {
        return $this->ma_start;
    }

    /**
     * @param mixed $ma_start
     */
    public function setMaStart($ma_start)
    {
        $this->ma_start = $ma_start;
    }
    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
        $this->ma_start = new \DateTime();
        $this->ma_start->setTime(20,45);
    }
}
