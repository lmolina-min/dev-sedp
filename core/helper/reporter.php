<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/db/conection.php');

class Reporter
{
    private $bd;

    private $talentohum;
    private $gerencia;
    private $division;
    private $departamento;
    private $coordinacion;
    private $oficina;

    public function __construct($bd)
    {
        try 
        {
            $this->bd           = $bd;
            $this->gergeneral   = 0;
            $this->gerencia     = 1;
            $this->division     = 2;
            $this->departamento = 3;
            $this->coordinacion = 4;
            $this->oficina      = 5;
            $this->talentohum   = 10;
        } 
        catch (Exception $e) 
        {
            echo json_encode($e->getMessage());
            die();
        }
    }

    public function get($rol, $nor, $id=null)
    {
        try 
        {
            $filter = [
                0 => "gerente.id = $id AND ger_gral.id = $nor",
                1 => "ger.id = $nor",
                10 => "ger.id = $nor",
            ];
            
            return $this->bd->getResultados($filter[$rol]);
        } 
        catch (PDOException $e) 
        {
            echo "Error al formatear el nombre: " . $e->getMessage() . "<br/>";
            die();
        }
    }
}
