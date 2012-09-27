<?php

require_once __DIR__ . '/securimage.php';

class SfSecurimage extends \securimage {

    private $session;
    private $sessionKey = 'Securimage.codeValue';

    public function __construct($session)
    {
        $this->session = $session;
    }


    /**
     * getCode - Returns the code of the actual captcha.
     * 
     * @access public
     * @return void
     */
    public function getCode()
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
    public function saveData()
    {
        $this->session->set($this->sessionKey, strtolower($this->code));
    }


    /**
     * Validate the code entered by the user.
     *
     * @param string $code The code the user entered
     * @param boolean $persistCookie Tell to remove or persist the value in the cookies
     * @access public
     * @return boolean
     */
    public function check($code, $persistCookie = false)
    {
        $this->code_entered = $code;
        $this->validate($persistCookie);
        return $this->correct_code;
    }


    /**
     * validate - Validates the captcha given.
     * 
     * @param boolean $persistCookie Tell to remove or persist the value in the cookies
     * @access public
     * @return void
     */
    public function validate($persistCookie = false)
    {
        if ($this->session->has($this->sessionKey)) {
            if ($this->session->get($this->sessionKey) == strtolower(trim($this->code_entered))) {
                $this->correct_code = true;
                if (!$persistCookie) {
                    $this->session->remove($this->sessionKey);
                }
                return true;
            }
        }
        $this->correct_code = false;
    }
}
