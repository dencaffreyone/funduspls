<?php

namespace App\Entity\Superclass;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
abstract class NotificationTemplate
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    protected $event;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Assert\NotBlank(message="Name is required.")
     */
    protected $name;

    abstract public function getHolders();

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set event
     *
     * @param string $event
     *
     * @return NotificationTemplate
     */
    public function setEvent($event)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return string
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return NotificationTemplate
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function getHoldersAsString()
    {
        $str = '';
        if ($holders = $this->getHolders()) {
            foreach ($holders as $name => $subHolders) {
                $str .= sprintf("<b>%s</b><br />", $name);
                foreach ($subHolders as $subHolder => $description) {
                    $str .= sprintf("<b>{%s}</b> - %s<br />", $subHolder, $description);
                }
                $str .= '<br/>';
            }
        }

        return $str;
    }

    protected function replaceHolders($text, $replacements = array())
    {
        preg_match_all('|\{[^{]+\}+|is', $text, $matches);
        $matches = array_unique($matches[0]);
        foreach ($matches as $match) {
            $data = explode(':', substr($match, 1, -1));
            $replacement = array_key_exists($data[0], $replacements) ? $replacements[ $data[0] ] : $data[0];
            $replace = $match;
            if (is_object($replacement)) {
                $method = 'get' . ucwords($data[1]);
                if (method_exists($replacement, $method)) {
                    try {
                        $replace = call_user_func(array($replacement, 'get' . ucwords($data[1])));
                    } catch (\Exception $e) {
                        // ignore
                    }
                }
            } else {
                $replace = $replacement;
            }
            $text = str_replace($match, $replace, $text);
        }

        return $text;
    }
}

