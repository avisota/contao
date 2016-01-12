<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota/contao-core
 * @license    LGPL-3.0+
 * @filesource
 */

namespace Avisota\Contao\Core\Event;

use Avisota\Contao\Entity\Message;
use Symfony\Component\EventDispatcher\Event;

class PreSendImmediateEvent extends Event
{
    /**
     * @var Message
     */
    protected $message;

    /**
     * @var int
     */
    protected $turn;

    /**
     * @var string
     */
    protected $loop;

    function __construct(Message $message, $turn, $loop)
    {
        $this->message = $message;
        $this->turn    = $turn;
        $this->loop    = $loop;
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getTurn()
    {
        return $this->turn;
    }

    /**
     * @return mixed
     */
    public function getLoop()
    {
        return $this->loop;
    }
}
