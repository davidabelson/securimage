<?php

require_once '../vendor/securimage/securimage.php';

class SfSecurimage extends \securimage {

    private $session;
    private $sessionKey = 'Securimage.codeValue';

    function __construct($session)
    {
        $this->session = $session;
    }


    /**
     * getCode - Returns the code of the actual captcha.
     * 
     * @access public
     * @return void
     */
    function getCode()
    {
        if ($this->session->has($this->sessionKey)) {
            return $this->session->get($this->sessionKey);
        }
        return false;
	}


    /**
     * saveData - Saves the valud of the captcha in a session variable.
     * 
     * @access public
     * @return void
     */
    function saveData()
    {
        $this->session->set($this->sessionKey, strtolower($this->code));
    }


    /**
     * validate - Validates the captcha given.
     * 
     * @access public
     * @return void
     */
    function validate()
    {
        if ($this->session->has($this->sessionKey)) {
            if ($this->session->get($this->sessionKey) == strtolower(trim($this->code_entered))) {
                $this->correct_code = true;
                $this->session->remove($this->sessionKey);
                return true;
            }
        }
        $this->correct_code = false;
    }
}
