<?php

namespace App\Security\TwoFactor\Email;

use App\Entity\Admin;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class Helper
{
    /**
     * @var \Doctrine\ORM\EntityManager $em
     */
    private $em;

    /**
     * @var object $mailer
     */
    private $mailer;

    /**
     * @var string $mailer
     */
    private $fromEmail;

    /**
     * Construct the helper service for mail authenticator
     * @param \Doctrine\ORM\EntityManager $em
     * @param object $mailer
     */
    public function __construct(EntityManager $em, $mailer, $fromEmail)
    {
        $this->em = $em;
        $this->mailer = $mailer;
        $this->fromEmail = $fromEmail;
    }

    /**
     * Generate a new authentication code an send it to the user
     * @param \App\Entity\Admin $admin
     */
    public function generateAndSend(Admin $admin)
    {
        $code = mt_rand(100000, 999999);
        $admin->setTwoFactorCode($code);

        $this->em->merge($admin);
        $this->em->flush($admin);

        $this->sendCode($admin);
    }

    /**
     * Send email with code to user
     * @param \App\Entity\Admin $admin
     */
    private function sendCode(Admin $admin)
    {
        $message = new \Swift_Message();
        $message
            ->setTo($admin->getTwoFactorEmail())
            ->setSubject("myGwork Authentication Code")
            ->setFrom($this->fromEmail)
            ->setBody($admin->getTwoFactorCode())
        ;
        $this->mailer->send($message);
    }

    /**
     * Validates the code, which was entered by the user
     * @param \DET\AdminBundle\Entity\Admin $admin
     * @param $code
     * @return bool
     */
    public function checkCode(Admin $admin, $code)
    {
        return $admin->getTwoFactorCode() == $code;
    }

    /**
     * Generates the attribute key for the session
     * @param \Symfony\Component\Security\Core\Authentication\Token\TokenInterface $token
     * @return string
     */
    public function getSessionKey(TokenInterface $token)
    {
        return sprintf('two_factor_%s_%s', $token->getProviderKey(), $token->getUsername());
    }
}