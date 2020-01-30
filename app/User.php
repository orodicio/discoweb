<?php

include_once 'config.php';
class User
{
    private $id;
    private $clave;
    private $nombre;
    private $plan;
    private $estado;
    private $email;

    /**
     * User constructor.
     * @param $email
     * @throws Exception
     */
    public function __construct($id,
                                $clave,
                                $nombre,
                                $email,
                                $plan,
                                $estado)
    {
        $this->id = $id;
        $this->checkId();
        $this->clave = $clave;
        if(!empty($this->clave)){$this->checkClave();$this->cifrarClave();}
        $this->email = $email;
        $this->checkEmail();
        $this->nombre= $nombre;
        $this->plan =$plan;
        $this->estado= $estado;

    }
    public function __get($atributo){
        if(property_exists($this, $atributo)) {
            return $this->$atributo;
        }
    }

    private function checkEmail()
    {
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            throw new \Exception(TMENSAJES['MAILERROR']);
        }
    }

    private function checkId()
    {
        if (preg_match("/^[a-zA-Z0-9]{5,10}$/", $this->id) == 0) {
            throw new \Exception(TMENSAJES['USRERROR']);
        }
    }

    private function checkClave()
    {
        if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&()=])([A-Za-z\d$@$!%*?&()=]|[^ ]){8,15}$/", $this->clave)==0) {
            throw new \Exception(TMENSAJES['PASSEASY']);
        }
    }
    private function cifrarClave(){
        return $this->clave = Cifrador::cifrar($this->clave);
    }
}




