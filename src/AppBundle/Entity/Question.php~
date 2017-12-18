<?php
/*
php bin/console doctrine:generate:entities AppBundle/Entity/Question
php bin/console doctrine:generate:entities AppBundle/Entity/Choice

php bin/console doctrine:schema:drop --force --full-database
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force

composer require --dev doctrine/doctrine-fixtures-bundle
add: new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle(), in AppKernel.php
edit: DataLoader.php

php bin/console doctrine:schema:drop --force --full-database
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load --no-interaction -vvv

--purge-with-truncate

php bin/console cache:clear

config.yml, services.yml
Event/TablePrefixSubscriber.php

IChoiceService, CrudService, ChoiceService, ChoiceServiceFactory
services.yml

php bin/console debug:container app

*/

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="question")
 */
class Question
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $qu_id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $qu_text;

    /**
     * @ORM\OneToMany(targetEntity="Choice", mappedBy="cho_question")
     */
    private $qu_choices;

    public function __construct()
    {
        $this->qu_choices=new ArrayCollection();
    }

    public function __toString()
    {
        return $this->qu_text;
    }

    // AUTO GENERATED

    /**
     * Get quId
     *
     * @return integer
     */
    public function getQuId()
    {
        return $this->qu_id;
    }

    /**
     * Set quText
     *
     * @param string $quText
     *
     * @return Question
     */
    public function setQuText($quText)
    {
        $this->qu_text = $quText;

        return $this;
    }

    /**
     * Get quText
     *
     * @return string
     */
    public function getQuText()
    {
        return $this->qu_text;
    }

    /**
     * Add quChoice
     *
     * @param \AppBundle\Entity\Choice $quChoice
     *
     * @return Question
     */
    public function addQuChoice(\AppBundle\Entity\Choice $quChoice)
    {
        $this->qu_choices[] = $quChoice;

        return $this;
    }

    /**
     * Remove quChoice
     *
     * @param \AppBundle\Entity\Choice $quChoice
     */
    public function removeQuChoice(\AppBundle\Entity\Choice $quChoice)
    {
        $this->qu_choices->removeElement($quChoice);
    }

    /**
     * Get quChoices
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuChoices()
    {
        return $this->qu_choices;
    }
}
