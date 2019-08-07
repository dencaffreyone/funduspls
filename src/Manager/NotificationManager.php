<?php

namespace  App\Manager;

use App\Entity\EmailTemplate;
use Doctrine\ORM\EntityManagerInterface;

class NotificationManager
{

    /**
     * @var string
     */
    protected $mailFrom = null;

    /**
     * @var string
     */
    protected $mailAdmin = null;

    /**
     * @var array
     */
    protected $links = [];

    /**
     * @var EntityManager|null
     */
    protected $em = null;

    /** @var  \Swift_Mailer */
    protected $mailer;

    function __construct(EntityManagerInterface $em, \Swift_Mailer $mailer, $mailFrom, $mailAdmin, $links = [])
    {
        $this->links = $links;
        $this->em = $em;
        $this->mailer = $mailer;

        $this->mailFrom = $mailFrom;
        $this->mailAdmin = $mailAdmin;
    }

    public function setLinks($links)
    {
        $this->links = $links;
    }

    public function setEntityManager($em)
    {
        $this->em = $em;
    }

    protected function getLinkFor($for)
    {
        return array_key_exists($for, $this->links) ? $this->links[$for] : null;
    }

    protected function notifyViaEmail($from, $to, EmailTemplate $notificationTemplate, $replacements = [], $attachments = [], $replyTo = null)
    {
        $subject = $notificationTemplate->replaceHoldersForSubject($replacements);
        $body = $notificationTemplate->replaceHoldersForBody($replacements);

        foreach ($replacements as $replacement => $replaceValue) {
            if ($replacement[0] === '{' and $replacement[strlen($replacement) - 1] === '}') {
                $subject = str_replace($replacement, $replaceValue, $subject);
                $body = str_replace($replacement, $replaceValue, $body);
            }
        }

        $message = new \Swift_Message($subject, $body, 'text/html; charset=utf-8');
        $message->setFrom($from)
            ->setTo($to);

        if ($replyTo) {
            $message->setReplyTo($replyTo);
        }

        foreach ($attachments as $attachment) {
            $message->attach(\Swift_Attachment::fromPath($attachment));
        }

        return $this->mailer->send($message);
    }

    protected function getEmailTemplateByEvent($name)
    {
        return $this->em->getRepository(EmailTemplate::class)
            ->findOneBy([
                'event' => $name
            ]);
    }

    public function notifyByContactForm($host, $name, $email, $message)
    {
        $emailTemplate = $this->getEmailTemplateByEvent('contact');

        return $this->notifyViaEmail($this->mailFrom, $this->mailAdmin, $emailTemplate, [
            'siteName' => $host,
            'userName' => $name,
            'userEmail' => $email,
            'userMessage' => $message
        ], [], $email);
    }

}