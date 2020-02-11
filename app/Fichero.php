<?php

include_once 'config.php';
class Fichero
{
    private $id;
    private $nombre;
    private $size;
    private $extension;
    private $hash;
    private $usuario;

    public function __construct($nombre,
                                $size,
                                $extension,
                                $hash,
                                $usuario)
    {
        $this->nombre= $nombre;
        $this->size =$size;
        $this->extension= $extension;
        $this->hash = $hash;
        $this->usuario = $usuario;
    }
    public function __get($atributo){
        if(property_exists($this, $atributo)) {
            return $this->$atributo;
        }
    }
}




