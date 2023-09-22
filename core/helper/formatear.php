<?php
class Formatear
{
    private $encode;
    private $time_zone;
    private $currency;

    public function __construct()
    {
        try 
        {
            $this->encode       = 'UTF-8';
            $this->time_zone    = 'America/Caracas';
            $this->currency     = 'BS';
        } 
        catch (Exception $e) 
        {
            echo json_encode($e->getMessage());
            die();
        }
    }

    // Formateador de nombre de unidad organizativa

    public function unidad($unidad, $uppercase=true)
    {
        try 
        {
            if ($uppercase) {
                $unidad_formated = mb_strtoupper($unidad, $this->encode);
            }
            else {
                $palabras = explode(' ', $unidad);
                $preposiciones = ['de', 'del', 'la', 'las', 'el', 'a', 'un', 'una', 'para', 'por', 'y'];
                foreach ($palabras as $palabra) {
                    $palabras_formated[] = in_array($palabra, $preposiciones)
                    ? mb_strtolower($palabra, $this->encode)
                    : ucfirst(mb_strtolower($palabra, $this->encode));
                }   
                $unidad_formated = implode(' ', $palabras_formated);
            }
            return $unidad_formated;
        } 
        catch (PDOException $e) 
        {
            echo "Error al formatear el nombre: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function cargo($cargo, $uppercase=true)
    {
        try 
        {
            if ($uppercase) {
                $cargo_formated = mb_strtoupper($cargo, $this->encode);
            }
            else {
                $palabras = explode(' ', $cargo);
                $preposiciones = ['de', 'del', 'la', 'las', 'el', 'a', 'un', 'una', 'para', 'por', 'y'];
                $niveles = ['i', 'ii', 'iii'];
                foreach ($palabras as $palabra) {
                    $palabras_formated[] = in_array(strtolower($palabra), $preposiciones)
                    ? mb_strtolower($palabra, $this->encode)
                    :(in_array(strtolower($palabra), $niveles) 
                    ? mb_strtoupper($palabra, $this->encode)
                    : ucfirst(mb_strtolower($palabra, $this->encode)));
                }   
                $cargo_formated = implode(' ', $palabras_formated);
            }
            return $cargo_formated;
        } 
        catch (PDOException $e) 
        {
            echo "Error al formatear el nombre: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function nombre($pnombre, $snombre, $fullname=false, $uppercase=false)
    {
        try 
        {
            if ($fullname) {
                $name_formated = ($uppercase)
                ? mb_strtoupper($pnombre.' '.$snombre, $this->encode)
                : ucwords(mb_strtolower($pnombre.' '.$snombre, $this->encode));
            }
            else {
                $nombres = explode(' ', $pnombre);
                $pri_nombre = $nombres[0];
                $seg_nombre = ($nombres[1]) ? $nombres[1][0] . '.' : '';
                $nombre_fmt = $pri_nombre . ' ' . $seg_nombre;
    
                $apellidos = explode(' ', $snombre);
                $pri_apellido = $apellidos[0];
                $seg_apellido = ($apellidos[1]) ? $apellidos[1][0] . '.' : '';
                $apellido_fmt = $pri_apellido . ' ' . $seg_apellido;

                $name_formated = ucwords(mb_strtolower($nombre_fmt.' '.$apellido_fmt, $this->encode));
            }
            return $name_formated;
        } 
        catch (PDOException $e) 
        {
            echo "Error al formatear el nombre: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function evaluation($total, $empleados) {
        $result = $total != 0 ? round((count($empleados) * 100) / ($total)) : 0;
        return $result;
    }

    public function nivelOrg($nivel_org)
    {
        $nivel = '';
        $cod_nivel = '';

        $gerencia_gral 	= $nivel_org['gerencia_gral'] . "|";
        $gerencia 		= $nivel_org['gerencia'];
        $division 		= $nivel_org['division'] != '' ? "|" . $nivel_org['division'] : '';
        $departamento 	= $nivel_org['departamento'] != '' ? "|" . $nivel_org['departamento'] : '';
        $coordinacion 	= $nivel_org['coordinacion'] != '' ? "|" . $nivel_org['coordinacion'] : '';
        $oficinas 		= $nivel_org['oficinas'] != '' ? "|" . $nivel_org['oficinas'] : '';
        $nivel 			= $gerencia_gral . $gerencia . $division . $departamento . $coordinacion . $oficinas;

        $des = explode("|", $nivel);
        return ucfirst(mb_strtolower($des[count($des) - 1], 'UTF-8'));
    }
}
