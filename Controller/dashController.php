<?php
require_once(dirname(__DIR__) . '../Model/dashModel.php');
class DashController
{

    public $tituloPagina;
    public $tituloTabla;
    public $objDash;

    public function __construct()
    {
     
        $this->objDash = new DashModel();
    }
    public function dashboard()
    { $this->tituloPagina = "Inicio";
        return $this->objDash->dashboard();
    }

    public function actualizarVistasGenerales($actual,$nuevo)
    {
       return $this->objDash->actualizarVistasGenerales($actual,$nuevo);
    }
    public function activas()
    {
        $this->tituloTabla = "Cuentas activas";
        return $this->objDash->activas();
    }
    public function inactivas()
    {
        $this->tituloTabla = "Cuentas inactivas";
        return $this->objDash->inactivas();
    }
    public function personalizadas()
    {
        $this->tituloTabla = "Clientes con vistas personalizadas";
        return $this->objDash->personalizadas();
    }
    public function vistasSinRestriccion()
    {
        $this->tituloTabla = "Clientes sin restricción de vistas";
        return $this->objDash->Sinrestriccion();
    }
    public function impresion()
    {
        $this->tituloTabla = "Clientes con permiso de impresión";
        return $this->objDash->impresion();
    }
    public function cobro()
    {
        $this->tituloTabla = "Clientes con cobro desactivado";
        return $this->objDash->cobro();
    }
}
