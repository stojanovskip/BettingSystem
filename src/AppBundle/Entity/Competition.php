<?php
/**
 * Created by PhpStorm.
 * User: hallgató
 * Date: 2017.12.04.
 * Time: 14:44
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="competitions")
 * @ORM\HasLifecycleCallbacks
 */
class Competition
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $co_name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $co_type;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $co_gender;

    /**
     * @ORM\Column(type="integer", length=100, nullable=true)
     */
    private $co_year;
    /**
     * @ORM\Column(type="boolean")
     */
    private $co_visible;
//change competition->team
    /**
     * @ORM\ManyToMany(targetEntity="Team", mappedBy="te_competitions")
     * @ORM\JoinTable(
     *  name="competitionsteams",
     *  joinColumns={
     *  @ORM\JoinColumn(name="ct_team", referencedColumnName="id")
     *  },
     * inverseJoinColumns={
     *   @ORM\JoinColumn(name="ct_competition", referencedColumnName="id")
     *  }
     *     )
     */
    private $co_teams;

    /**
     * Competition constructor.
     */
    public function __construct()
    {
        $this->co_teams = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getCoName()
    {
        return $this->co_name;
    }

    /**
     * @param mixed $co_name
     */
    public function setCoName($co_name)
    {
        $this->co_name = $co_name;
    }

    /**
     * @return mixed
     */
    public function getCoType()
    {
        return $this->co_type;
    }

    /**
     * @param mixed $co_type
     */
    public function setCoType($co_type)
    {
        $this->co_type = $co_type;
    }

    /**
     * @return mixed
     */
    public function getCoGender()
    {
        return $this->co_gender;
    }

    /**
     * @param mixed $co_gender
     */
    public function setCoGender($co_gender)
    {
        $this->co_gender = $co_gender;
    }

    /**
     * @return mixed
     */
    public function getCoYear()
    {
        return $this->co_year;
    }

    /**
     * @param mixed $co_year
     */
    public function setCoYear($co_year)
    {
        $this->co_year = $co_year;
    }

    /**
     * @return mixed
     */
    public function getCoVisible()
    {
        return $this->co_visible;
    }

    /**
     * @param mixed $co_visible
     */
    public function setCoVisible($co_visible)
    {
        $this->co_visible = $co_visible;
    }

    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCoTeams()
    {
        return $this->co_teams;
    }

    /**
     * @param \AppBundle\Entity\Team $co_teams
     */
    public function setCoTeams($co_teams)
    {
        $this->co_teams[] = $co_teams;
    }

    /**
     * Add coTeam
     *
     * @param \AppBundle\Entity\Team $coTeam
     *
     * @return Competition
     */
    public function addCoTeam(\AppBundle\Entity\Team $coTeam)
    {
        $this->co_teams[] = $coTeam;

        return $this;
    }

    /**
     * Remove coTeam
     *
     * @param \AppBundle\Entity\Team $coTeam
     */
    public function removeCoTeam(\AppBundle\Entity\Team $coTeam)
    {
        $this->co_teams->removeElement($coTeam);
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

}
