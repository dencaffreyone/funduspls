<?php

namespace App\Entity;

use App\Entity\Superclass\NotificationTemplate;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;

/**
 * @ORM\Table(name="emails_templates")
 * @ORM\Entity
 */
class EmailTemplate extends NotificationTemplate
{

    use ORMBehaviors\Translatable\Translatable;

    const EVENT_CONTACT_FORM = 'contact';

    public function __toString()
    {
        return $this->getName() ?: '';
    }

    public function replaceHoldersForSubject($replacements = array())
    {
        return $this->replaceHolders($this->getSubject(), $replacements);
    }

    public function replaceHoldersForBody($replacements = array())
    {
        return $this->replaceHolders($this->getMessage(), $replacements);
    }

    public function getHolders()
    {
        switch ($this->getEvent()) {
            case static::EVENT_CONTACT_FORM:
                return [
                    'Site Info' =>[
                        'siteName' => 'Site name'
                    ],
                    'User Info' => [
                        'userName' => 'User name',
                        'userEmail' => 'User email',
                        'userMessage' => 'User message'
                    ]
                ];
                break;
        }

        return [];
    }

    public function __call($method, $arguments)
    {
        if (!method_exists(self::getTranslationEntityClass(), $method)) {
            $method = 'get'. ucfirst($method);
        }

        $data = $this->proxyCurrentLocaleTranslation($method, $arguments);
        if ($data) {
            return $data;
        }
        $default = $this->translate('en');

        return $default->$method($arguments);
    }

}

