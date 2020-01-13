<?php

class NotFound implements Matcheable {

    private $path;

    public function __construct(string $path) {
        $this->path = $path;
    }

    public function execute() {
        echo str_replace('{{$_VALUE}}', $this->path, file_get_contents('notfound.html'));
    }
}