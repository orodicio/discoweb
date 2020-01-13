<?php

class SessionManager {

    private $session;
    
    public function __construct(array $session) {
        $this->session = $session;
    }

    public function execute() {
        $sessionUser = @$this->session['user'];
        $sessionMode = @$this->session['modo'];


    }
}