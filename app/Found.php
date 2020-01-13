<?php

class Found implements Matcheable{

    private $callable;
    
    public function __construct(string $callable) {
        $this->callable = $callable;
    }

    public function execute() {
        call_user_func($this->callable);
    }
}