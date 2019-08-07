<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Context\ExecutionContextFactoryInterface;
use Symfony\Component\Validator\GroupSequenceProviderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * DET\AdminBundle\Entity\User
 *
 * @ORM\Table(name="admins")
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 *
 * @Assert\Expression("this.getPassword() == this.getRepeatPassword()", message="Passwords doesn't match.")
 * @UniqueEntity(fields={"username"}, errorPath="username", message="Admin with this username already exists.")
 */
class Admin implements UserInterface, \Serializable, GroupSequenceProviderInterface
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @Assert\NotBlank(message="Username is required.")
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=128)
     *
     * @Assert\NotBlank(groups={"new"}, message="Password is required.")
     */
    private $password;
    
    /**
     * @Assert\NotBlank(groups={"new"}, message="Repeat Password is required.")
     */
    private $repeat_password;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $salt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $two_factor_authentication = false;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $two_factor_code;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * 
     * @Assert\Email()
     * @Assert\Expression(
     *     "not (this.getTwoFactorAuthentication() and not this.getTwoFactorEmail())",
     *     message="Please enter two factor email"
     * )
     */
    private $two_factor_email;

    public function __construct()
    {
        $this->salt = md5(uniqid(null, true));
    }

    public function __toString()
    {
        return (string) $this->getUsername();
    }
    
    public function isNew()
    {
        return is_null($this->getId());
    }

    /**
     * @inheritDoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function setRepeatPassword($repeatPassword)
    {
        $this->repeat_password = $repeatPassword;
    }

    public function getRepeatPassword()
    {
        return $this->repeat_password;
    }

    /**
     * @inheritDoc
     */
    public function getRoles()
    {
        return array('ROLE_ADMIN', 'ROLE_SONATA_ADMIN', 'ROLE_SUPER_ADMIN');
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @see \Serializable::serialize()
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->salt
        ));
    }

    /**
     * @see \Serializable::unserialize()
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list (
                $this->id,
                $this->username,
                $this->password,
                $this->salt
                ) = unserialize($serialized);
    }

    public function getGroupSequence()
    {
        $groups = array('Default');

        if ($this->isNew()) {
            $groups[] = 'new';
        } else {
            $groups[] = 'edit';
        }

        return $groups;
    }

    public function validatePasswords(ExecutionContextFactoryInterface $context)
    {
        if ($this->getPassword() !== $this->getRepeatPassword()) {
            $context->buildViolation('')
                    ->atPath('password')
                    ->addViolation();
        }
    }

    /**
     * Set salt.
     *
     * @param string $salt
     *
     * @return Admin
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Set twoFactorAuthentication.
     *
     * @param bool $twoFactorAuthentication
     *
     * @return Admin
     */
    public function setTwoFactorAuthentication($twoFactorAuthentication)
    {
        $this->two_factor_authentication = $twoFactorAuthentication;

        return $this;
    }

    /**
     * Get twoFactorAuthentication.
     *
     * @return bool
     */
    public function getTwoFactorAuthentication()
    {
        return $this->two_factor_authentication;
    }

    /**
     * Set twoFactorCode.
     *
     * @param int|null $twoFactorCode
     *
     * @return Admin
     */
    public function setTwoFactorCode($twoFactorCode = null)
    {
        $this->two_factor_code = $twoFactorCode;

        return $this;
    }

    /**
     * Get twoFactorCode.
     *
     * @return int|null
     */
    public function getTwoFactorCode()
    {
        return $this->two_factor_code;
    }

    /**
     * Set twoFactorEmail.
     *
     * @param int|null $twoFactorEmail
     *
     * @return Admin
     */
    public function setTwoFactorEmail($twoFactorEmail = null)
    {
        $this->two_factor_email = $twoFactorEmail;

        return $this;
    }

    /**
     * Get twoFactorEmail.
     *
     * @return int|null
     */
    public function getTwoFactorEmail()
    {
        return $this->two_factor_email;
    }

}
