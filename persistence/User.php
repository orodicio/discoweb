<?php

class User
{
    private $login;
    private $passwd;
    private $name;
    private $email;
    private $plan;
    private $status;

    /**
     * User constructor.
     * @param $login
     * @param $passwd
     * @param $name
     * @param $email
     * @param $plan
     * @param $status
     */
    public function __construct($login, $passwd, $name, $email, $plan, $status)
    {
        $this->login = $login;
        $this->passwd = $passwd;
        $this->name = $name;
        $this->email = $email;
        $this->plan = $plan;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @return mixed
     */
    public function getPasswd()
    {
        return $this->passwd;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }


}