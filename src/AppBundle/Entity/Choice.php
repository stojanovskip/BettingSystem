<?php
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="choices")
 * @ORM\HasLifecycleCallbacks
 */
class Choice
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $cho_id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $cho_inserted;

    /**
     * @ORM\Column(type="datetime")
     */
    private $cho_modified;

    /**
     * @ORM\Column(type="boolean")
     */
    private $cho_visible;

    /**
     * @ORM\ManyToOne(targetEntity="Question", inversedBy="qu_choices")
     * @ORM\JoinColumn(name="cho_question", referencedColumnName="qu_id")
     */
    private $cho_question;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $cho_text;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $cho_numvotes;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function updateTimestamps()
    {
        $this->cho_modified=new \DateTime();
        if ($this->cho_inserted==null){
            $this->cho_inserted = new \DateTime();
        }
    }

    public function __toString()
    {
        $question = $this->cho_question==null ? "N/A" : $this->getChoQuestion()->getQuText();
        return $question." / ".$this->cho_text." / ".$this->cho_numvotes;
    }

    // AUTO GENERATED


    /**
     * Get choId
     *
     * @return integer
     */
    public function getChoId()
    {
        return $this->cho_id;
    }

    /**
     * Set choInserted
     *
     * @param \DateTime $choInserted
     *
     * @return Choice
     */
    public function setChoInserted($choInserted)
    {
        $this->cho_inserted = $choInserted;

        return $this;
    }

    /**
     * Get choInserted
     *
     * @return \DateTime
     */
    public function getChoInserted()
    {
        return $this->cho_inserted;
    }

    /**
     * Set choModified
     *
     * @param \DateTime $choModified
     *
     * @return Choice
     */
    public function setChoModified($choModified)
    {
        $this->cho_modified = $choModified;

        return $this;
    }

    /**
     * Get choModified
     *
     * @return \DateTime
     */
    public function getChoModified()
    {
        return $this->cho_modified;
    }

    /**
     * Set choVisible
     *
     * @param boolean $choVisible
     *
     * @return Choice
     */
    public function setChoVisible($choVisible)
    {
        $this->cho_visible = $choVisible;

        return $this;
    }

    /**
     * Get choVisible
     *
     * @return boolean
     */
    public function getChoVisible()
    {
        return $this->cho_visible;
    }

    /**
     * Set choText
     *
     * @param string $choText
     *
     * @return Choice
     */
    public function setChoText($choText)
    {
        $this->cho_text = $choText;

        return $this;
    }

    /**
     * Get choText
     *
     * @return string
     */
    public function getChoText()
    {
        return $this->cho_text;
    }

    /**
     * Set choNumvotes
     *
     * @param integer $choNumvotes
     *
     * @return Choice
     */
    public function setChoNumvotes($choNumvotes)
    {
        $this->cho_numvotes = $choNumvotes;

        return $this;
    }

    /**
     * Get choNumvotes
     *
     * @return integer
     */
    public function getChoNumvotes()
    {
        return $this->cho_numvotes;
    }

    /**
     * Set choQuestion
     *
     * @param \AppBundle\Entity\Question $choQuestion
     *
     * @return Choice
     */
    public function setChoQuestion(\AppBundle\Entity\Question $choQuestion = null)
    {
        $this->cho_question = $choQuestion;

        return $this;
    }

    /**
     * Get choQuestion
     *
     * @return \AppBundle\Entity\Question
     */
    public function getChoQuestion()
    {
        return $this->cho_question;
    }
}
