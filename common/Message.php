<?php
/**
 * Classes for user and developer messages
 * @package Common
 * @version $Id$
 */

/**
 * A class for messages
 *
 * Theses messages are intended to be displayed to the client.
 * @package Common
 */
class Message extends Serializable {

    const CHANNEL_USER = 1;
    const CHANNEL_DEVELOPER = 2;
    
    /**
     * @var string
     */
    public $message;
    
    /**
     * @var int  
     */
    public $channel;

    /**
     * @param string
     * @param int
     */
    function __construct($message = NULL, $channel = self::CHANNEL_USER) {
        $this->message = $message;
        $this->channel = $channel;
    }

    function unserialize($struct) {
        $this->message = Serializable::unserializeValue($struct, 'message');
        $this->channel = Serializable::unserializeValue($struct, 'channel', 'int');
    }
}

?>