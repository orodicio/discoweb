<?php

include_once 'config.php';
class Fichero
{
    private $id;
    private $nombre;
    private $size;
    private $extension;
    private $hash;

    /**
     * User constructor.
     * @param $email
     * @throws Exception
     */
    public function __construct($nombre,
                                $size,
                                $extension,
                                $hash)
    {
        $this->nombre= $nombre;
        $this->size =$size;
        $this->extension= $extension;
        $this->hash = $hash;
    }
    public function __get($atributo){
        if(property_exists($this, $atributo)) {
            return $this->$atributo;
        }
    }

}




