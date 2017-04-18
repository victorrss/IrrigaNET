<?php

class ModelIrrigaNET
{
    private $dispositivo;
    private $umidadeSolo;
    private $umidadeAr;
    private $temperatura;
    private $nivelAgua;
    private $irrigar;

	public function getDispositivo(){
     return $this->dispositivo;
    }

    public function setDispositivo($dispositivo){
     $this->dispositivo = $dispositivo;
    }

    public function getUmidadeSolo(){
     return $this->umidadeSolo;
    }

    public function setUmidadeSolo($umidadeSolo){
     $this->umidadeSolo = $umidadeSolo;
    }

    public function getUmidadeAr(){
     return $this->umidadeAr;
    }

    public function setUmidadeAr($umidadeAr){
     $this->umidadeAr = $umidadeAr;
    }

    public function getTemperatura(){
     return $this->temperatura;
    }

    public function setTemperatura($temperatura){
     $this->temperatura = $temperatura;
    }

    public function getNivelAgua(){
     return $this->nivelAgua;
    }

    public function setNivelAgua($nivelAgua){
     $this->nivelAgua = $nivelAgua;
    }

    public function getIrrigar(){
     return $this->irrigar;
    }

    public function setIrrigar($irrigar){
     $this->irrigar = $irrigar;
    }
}
