<?php
/**
 * Encoding classes
 * @package Server
 * @version $Id$
 */

/**
 * Encoder selection
 *
 * The Encoder is selected using client.ini's EncoderClass.
 * @package Server
 */
class Encoder {
  
    /**
     * @var Logger
     */
    static private $log;
      
    /**
     * List of Encoder
     * @var array array of EncoderInterface
     */
    static public $encoders;

    /**
     * Sets default encoding object (UTF8).
     * @param string context
     */
    static private function setDefault($context) {
        if (!array_key_exists($context, self::$encoders)) {
            self::$encoders[$context] = new EncoderUTF();
        }
    }
    
    /**
     * Initializes encoding
     * @param Config
     */
    static public function init(Config $config) {
        self::$log =& LoggerManager::getLogger(__CLASS__);

        self::$encoders = array();
        $iniArray = $config->getIniArray();
        foreach ($iniArray as $key => $value) {
            $keyArray = explode('.', $key);
            if ($keyArray[0] == 'EncoderClass') {
                if (class_exists($value)) {
                    self::$encoders[$keyArray[1]] = new $value;
                }
            }            
        }
        self::setDefault('config');
        self::setDefault('output');
    }    
   
    /**
     * @param string context
     * @return EncoderInterface
     */
    static private function getEncoder($context) {
        return self::$encoders[$context];
    }
    
    /**
     * Calls encoder's encode
     * @param string
     * @return string
     */
    static public function encode($text, $context = 'output') {
        // self::$log->debug("ENCODE($text,$context)");
        return self::getEncoder($context)->encode($text);
    }

    /**
     * Calls encoder's decode
     * @param string
     * @return string
     */
    static public function decode($text, $context = 'output') {
        // self::$log->debug("DECODE($text,$context)");
        return self::getEncoder($context)->decode($text);
    }
    
    /**
     * Calls encoder's getCharset
     * @param string context
     * @return string
     */
    static public function getCharset($context = 'output') {
        return self::getEncoder($context)->getCharset();
    }
}

/**
 * Encoder interface
 * @package Client
 */
interface EncoderInterface {

    /**
     * Wrapper for function encode
     * @param string
     * @return string
     */ 
    function encode($text);
    
    /**
     * Wrapper for function decode
     * @param string
     * @return string
     */ 
    function decode($text);
    
    /** 
     * Wrapper for function getCharset
     * @return string
     */
    function getCharset();
}

/**
 * UTF8 en/decoder
 *
 * Does nothing, as everything (server files, SOAP XML) is UTF8-encoded.
 * @package Client
 */
class EncoderUTF implements EncoderInterface {

    /**
     * @see EncoderInterface::encode()
     */
    public function encode($text) {
        return $text;
    }

    /**
     * @see EncoderInterface::decode()
     */
    public function decode($text) {
        return $text;
    }
    
    /**
     * @see EncoderInterface::getCharset()
     */
    public function getCharset() {
        return 'utf-8';
    }
}

/**
 * ISO-8859-1 en/decoder
 * @package Client
 */
class EncoderISO implements EncoderInterface {

    /**
     * @see EncoderInterface::encode()
     */
    public function encode($text) {
        if (is_array($text)) {
            $result = array();
            foreach ($text as $key => $value) {
                $result[utf8_encode($key)] = utf8_encode($value);
            }
            return $result;
        }
        return utf8_encode($text);
    }

    /**
     * @see EncoderInterface::decode()
     */
    public function decode($text) {
        if (is_array($text)) {
            $result = array();
            foreach ($text as $key => $value) {
                $result[utf8_decode($key)] = utf8_decode($value);
            }
            return $result;
        }
        return utf8_decode($text);
    }
    
    /**
     * @see EncoderInterface::getCharset()
     */
    public function getCharset() {
        return 'iso-8859-1';
    }
}

?>
