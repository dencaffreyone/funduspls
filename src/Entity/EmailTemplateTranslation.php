<?php

namespace App\Entity;

use App\Entity\Superclass\NotificationTemplate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name="emails_templates_translations")
 * @ORM\Entity
 */
class EmailTemplateTranslation
{

    use ORMBehaviors\Translatable\Translation;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Subject is required.")
     */
    protected $subject;

    /**
     * @ORM\Column(type="text")
     *
     * @Assert\NotBlank(message="Message is required.")
     */
    protected $message;

    /**
     * Set subject
     *
     * @param string $subject
     *
     * @return EmailTemplate
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Get subject
     *
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return EmailTemplate
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

}

