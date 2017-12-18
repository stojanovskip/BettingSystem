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
 * @ORM\Table(name="teams")
 * @ORM\HasLifecycleCallbacks
 */
class Team
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
    private $te_name;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $te_nationality;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $te_address;

    /**
     * @ORM\ManyToMany(targetEntity="Competition", mappedBy="co_teams")
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
    private $te_competitions;

    /**
     * @ORM\OneToMany(targetEntity="Match", mappedBy="ma_team1_g")
     */
    private $te_home_matches;

    /**
     * @ORM\OneToMany(targetEntity="Match", mappedBy="ma_team2_g")
     */
    private $te_away_matches;

    /**
     * @return mixed
     */
    public function getTeName()
    {
        return $this->te_name;
    }

    /**
     * @param mixed $te_name
     */
    public function setTeName($te_name)
    {
        $this->te_name = $te_name;
    }

    /**
     * @return mixed
     */
    public function getTeNationality()
    {
        return $this->te_nationality;
    }

    /**
     * @param mixed $te_nationality
     */
    public function setTeNationality($te_nationality)
    {
        $this->te_nationality = $te_nationality;
    }

    /**
     * @return mixed
     */
    public function getTeAddress()
    {
        return $this->te_address;
    }

    /**
     * @param mixed $te_address
     */
    public function setTeAddress($te_address)
    {
        $this->te_address = $te_address;
    }


    /**
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTeCompetitions()
    {
        return $this->te_competitions;
    }
    /**
     * Team constructor.
     */
    public function __construct()
    {
        $this->te_competitions = new ArrayCollection;
        $this->te_home_matches = new ArrayCollection;
        $this->te_away_matches = new ArrayCollection;
    }
    /**
     * @param mixed $te_competitions
     */
    public function setTeCompetitions($te_competitions)
    {
        $this->te_competitions = $te_competitions;
    }


    /**
     * Add teCompetition
     *
     * @param \AppBundle\Entity\Competition $teCompetition
     *
     * @return Team
     */
    public function addTeCompetition(Competition $teCompetition)
    {
        $this->te_competitions[] = $teCompetition;

        return $this;
    }

    /**
     * Remove teCompetition
     *
     * @param \AppBundle\Entity\Competition $teCompetition
     */
    public function removeTeCompetition(\AppBundle\Entity\Competition $teCompetition)
    {
        $this->te_competitions->removeElement($teCompetition);
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
    public function getTeHomeMatches()
    {
        return $this->te_home_matches;
    }

    /**
     * @param mixed $te_home_matches
     */
    public function setTeHomeMatches($te_home_matches)
    {
        $this->te_home_matches = $te_home_matches;
    }

    /**
     * @return mixed
     */
    public function getTeAwayMatches()
    {
        return $this->te_away_matches;
    }

    /**
     * @param mixed $te_away_matches
     */
    public function setTeAwayMatches($te_away_matches)
    {
        $this->te_away_matches = $te_away_matches;
    }


    /**
     * Add teHomeMatch
     *
     * @param \AppBundle\Entity\Match $teHomeMatch
     *
     * @return Team
     */
    public function addTeHomeMatch(\AppBundle\Entity\Match $teHomeMatch)
    {
        $this->te_home_matches[] = $teHomeMatch;

        return $this;
    }

    /**
     * Remove teHomeMatch
     *
     * @param \AppBundle\Entity\Match $teHomeMatch
     */
    public function removeTeHomeMatch(\AppBundle\Entity\Match $teHomeMatch)
    {
        $this->te_home_matches->removeElement($teHomeMatch);
    }

    /**
     * Add teAwayMatch
     *
     * @param \AppBundle\Entity\Match $teAwayMatch
     *
     * @return Team
     */
    public function addTeAwayMatch(\AppBundle\Entity\Match $teAwayMatch)
    {
        $this->te_away_matches[] = $teAwayMatch;

        return $this;
    }

    /**
     * Remove teAwayMatch
     *
     * @param \AppBundle\Entity\Match $teAwayMatch
     */
    public function removeTeAwayMatch(\AppBundle\Entity\Match $teAwayMatch)
    {
        $this->te_away_matches->removeElement($teAwayMatch);
    }
}
