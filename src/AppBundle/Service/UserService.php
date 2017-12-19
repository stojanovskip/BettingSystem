<?php
/**
 * Created by PhpStorm.
 * User: petar
 * Date: 10-Dec-17
 * Time: 20:57
 */

namespace AppBundle\Service;

use AppBundle\Entity\Bet;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;

class UserService extends CrudService implements  IUserService
{
    /**
     * @return EntityRepository
     */
    function getRepo()
    {
        return $this->em->getRepository(Bet::class);
    }


    /**
     * @return User[]
     */
    public function getUsers()
    {
        return $this->getRepo()->findAll();
    }

    /**
     * @param $userId int
     * @return Bet[]
     */
    public function getUserBets($userId)
    {
        return $this->getRepo()->findBy(array('bet_user' => $userId));
    }

    /**
     * @param $id int
     * @return User
     */
    public function getUserById($id)
    {
        $oneUser = $this->getRepo()->find($id);
        return $oneUser;
    }

    /**
     * @param $oneUser User
     */
    public function saveUser($oneUser)
    {
        $this->em->persist($oneUser);
        $this->em->flush();
    }

    /**
     * @param $id int
     */
    public function deleteUser($id)
    {
       $oneUser = $this->getUserById($id);
       $this->em->persist($oneUser);
       $this->em->flush();
    }

    /**
     * @param $oneUser User
     * @return FormInterface
     */
    public function getLoginForm($oneUser)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $oneUser);

        $form->add('us_name', TextType::class);
        $form->add('us_pass', PasswordType::class);

        $form->add('Send', SubmitType::class);

        return $form->getForm();
    }

    /**
     * @param $oneUser User
     * @return FormInterface
     */
    public function getRegisterForm($oneUser)
    {
        $form = $this->formFactory->createBuilder(FormType::class, $oneUser);

        $form->add('us_name', TextType::class);
        //$form->add('us_pass', PasswordType::class);
        $form->add('us_pass', RepeatedType::class, array(
            'type' => PasswordType::class,
            'first_options'  => array('label' => 'Password'),
            'second_options' => array('label' => 'Repeat Password'),
        ));
        $form->add('Send', SubmitType::class);

        return $form->getForm();
    }
    /**
     * @param $oneUser string
     * @return User[]
     */
    public function getUser($oneUser)
    {
        $username = $oneUser;
        $query = $this->em->createQuery("
            SELECT u
            FROM AppBundle:User u
            WHERE u.us_name=:username")
            ->setParameter('username',$username);

        $qb = $this->em->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:User', 'u')
            ->where('u.us_name = :username')
            ->setParameter('username',$username)
            ->getQuery();
        return $query->getResult();
    }
    /**
     * @param $oneUser User
     * @return User[]
     */
    public function checkUser($oneUser)
    {
        $username = $oneUser->getUsName();
        $password = sha1($oneUser->getUsPass());
        $query = $this->em->createQuery("
            SELECT u
            FROM AppBundle:User u
            WHERE u.us_name=:username
            AND u.us_pass=:password")
            ->setParameters(array('username'=>$username,'password'=>$password));

        $qb = $this->em->createQueryBuilder();
        $qb->select('u')
            ->from('AppBundle:User', 'u')
            ->where('u.us_name = :username')
            ->andWhere('u.us_pass = :password')
            ->setParameters(array('username'=>$username,'password'=>$password))
            ->getQuery();
        return $query->getResult();
    }
}