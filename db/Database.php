<?php
class Database
{
    public $conn = null;
    public $showErrors = 1;
    public $lastQuery = "";
    public $lastInsertId = 0;
    public function __construct($bd_tipo, $bd_servidor, $bd_nombre, $bd_usuario, $bd_password)
    {
        try {
            $this->conn = new PDO("$bd_tipo:host=$bd_servidor;dbname=$bd_nombre", $bd_usuario, $bd_password, array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            ));
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    /*************************************************************************************************************/
    /*                                              S E L E C T                                                  */
    /*************************************************************************************************************/

    public function getUsuario($usuario)
    {
        try {
            if ($usuario == 'root') {
                $sql = "SELECT u.id, u.usuario, u.rol, u.clave, u.correo, u.estado
                        FROM usuarios AS u
                        WHERE u.usuario = '$usuario' AND u.estado = 1";
            }
            else {
                $sql = "SELECT u.id, u.usuario, u.rol, u.clave, u.correo, u.estado,
                        emp.id_ccosto nivel_org, emp.id empleado, emp.id_evaluador evaluador, emp.foto
                        FROM usuarios AS u
                        INNER JOIN empleados AS emp ON emp.id = u.id_empleado
                        WHERE u.usuario = '$usuario' AND u.estado=1";
            }

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getPerfil($id)
    {
        try {
            $sql = "SELECT emp.id id_empleado, emp.nombre, emp.apellido, emp.cedula, emp.foto,
                    u.id id_usuario, u.usuario, u.rol, u.clave, u.correo, u.estado
                    FROM empleados AS emp
                    INNER JOIN usuarios AS u ON u.id_empleado = emp.id
                    WHERE emp.id = $id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getEmpleados()
    {
        try {
            $sql = "SELECT id, nombre, apellido, cedula FROM empleados";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getEmpleadosEvaluador($id_evaluador)
    {
        try {
            $sql = "SELECT id, nombre, apellido, cedula FROM empleados WHERE id_evaluador = $id_evaluador";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getCargos()
    {
        try {
            $sql = "SELECT id, descripcion FROM cargos";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getCentrosCosto()
    {
        try {
            $sql = "SELECT cc.id, cc.descripcion FROM sedp_dev_no.nivel_org nor
                    INNER JOIN sedp_dev_no.gerencia_gral AS cc ON cc.id = nor.id_ger_gral
                    INNER JOIN sedp_dev_no.gerencias AS cc ON cc.id = nor.id_gerencia
                    INNER JOIN sedp_dev_no.divisiones AS cc ON cc.id = nor.id_division
                    INNER JOIN sedp_dev_no.departamentos AS cc ON cc.id = nor.id_departamento
                    INNER JOIN sedp_dev_no.coordinaciones AS cc ON cc.id = nor.id_coordinacion
                    INNER JOIN sedp_dev_no.oficinas AS cc ON cc.id = nor.id_oficina
                    WHERE nor.id_ger_gral = cc.id || nor.id_gerencia = cc.id || nor.id_division = cc.id 
                    || nor.id_departamento = cc.id || nor.id_coordinacion = cc.id || nor.id_oficina = cc.id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getNominas()
    {
        try {
            $sql = "SELECT id, descripcion FROM nominas";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getProcesos()
    {
        try {
            $sql = "SELECT * FROM procesos";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getProcesoActivo()
    {
        try {
            $sql = "SELECT id, estado FROM procesos ORDER BY id DESC LIMIT 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print_r("Error: " . $e->getMessage() . "<br/>");
                die();
            }
            return false;
        }
    }

    public function getDatosEmpleadosAll()
    {
        try {
            $sql = "SELECT * FROM empleados";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }
    
    public function getDatosEmpleado($id_empleado)
    {
        try {
            $sql = "SELECT * FROM sc_datos_usuarios WHERE id_empleado=".$id_empleado;
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getCantidadEmpleados($id_empleado)
    {
        try {
            $sql = "SELECT count(*) AS total FROM empleados WHERE id_evaluador='$id_empleado'";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEmpleadosxEval($evaluador)
    {
        try {
            $sql = "SELECT emp.id, eva.id id_evaluacion, emp.cedula, emp.nombre, emp.apellido, emp.id_nomina, eva.estado
		 		    FROM empleados AS emp
                    LEFT JOIN evaluaciones AS eva ON emp.id = eva.id_empleado
				    WHERE eva.id is null AND emp.id_evaluador = '$evaluador' AND (eva.estado = 0  OR eva.estado is null)";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEmpleadosEvaluacion($id_empleado, $estado=0)
    {
        try {
            $estado = ($estado) ? "AND ev.estado = $estado" : "";
            $sql = "SELECT emp.id id_empleado, emp.cedula, emp.nombre, emp.apellido, emp.foto, emp.id_nomina,
                    c.descripcion cargo, ev.id id_evaluacion, ev.puntaje, ev.estado FROM empleados AS emp
					INNER JOIN cargos AS c ON c.id=emp.id_cargo
					INNER JOIN evaluaciones AS ev ON ev.id_empleado=emp.id
					WHERE emp.id_evaluador = $id_empleado ".$estado;

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getFormatoEval($id_nomina)
    {
        try {
            $sql = "SELECT factor.id, factor.titulo, factor.subtitulo, factor.nivel, 
                    calif.id id_calificacion, calif.descripcion, calif.valor FROM factores factor
                    INNER JOIN calificaciones AS calif ON calif.id_factor = factor.id
                    WHERE factor.id_nomina = '$id_nomina' ORDER BY factor.id, RAND()";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getFormatoEditar($id_nomina, $id_evaluacion)
    {
        try {
            $sql = "SELECT calif.id id_calificacion FROM evaluaciones eva
                    INNER JOIN evaluacion_calificacion AS eval_calif ON eval_calif.id_evaluacion = eva.id
                    INNER JOIN calificaciones AS calif ON calif.id = eval_calif.id_calificacion
                    INNER JOIN factores AS factor ON factor.id = calif.id_factor
				    WHERE factor.id_nomina = '$id_nomina' AND eva.id = '$id_evaluacion'";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getResultados($filtro=1)
    {
        try {
            $sql = "SELECT emp.cedula, emp.nombre, emp.apellido, 
                    emp.id_ccosto, emp.id_cargo, c.descripcion cargo, ev.puntaje FROM sedp_dev.empleados AS emp 
                    INNER JOIN empleados AS gerente ON gerente.id = emp.id_evaluador
                    INNER JOIN sedp_dev.evaluaciones        AS ev    ON ev.id_empleado = emp.id
                    INNER JOIN sedp_dev.cargos              AS c     ON c.id     = emp.id_cargo
                    INNER JOIN sedp_dev_no.nivel_org      AS nor   ON nor.id   = emp.id_ccosto
                    INNER JOIN sedp_dev_no.gerencia_gral  AS ger_gral ON ger_gral.id = nor.id_ger_gral
                    INNER JOIN sedp_dev_no.gerencias      AS ger   ON ger.id   = nor.id_gerencia
                    INNER JOIN sedp_dev_no.divisiones     AS divi  ON divi.id  = nor.id_division
                    INNER JOIN sedp_dev_no.departamentos  AS dep   ON dep.id   = nor.id_departamento
                    INNER JOIN sedp_dev_no.coordinaciones AS coord ON coord.id = nor.id_coordinacion
                    INNER JOIN sedp_dev_no.oficinas       AS ofi   ON ofi.id   = nor.id_oficina
                    WHERE $filtro ORDER BY emp.nombre";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));  
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEstadoEvaluacionesGer($evaluador=1)
    {
        try {
            $sql = "SELECT ev.id, ev.estado, emp.id id_empleado, emp.nombre, emp.apellido, emp.cedula, ger.descripcion gerencia
                    FROM sedp_dev.evaluaciones AS ev
                    INNER JOIN sedp_dev.empleados AS emp ON emp.id_evaluador = $evaluador
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.gerencias AS ger ON ger.id = nor.id_gerencia
                    WHERE ev.id_empleado = emp.id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEvaluaciones($evaluador=60, $estado=0, $ccosto='gerencias')
    {
        try {
            $sql = "SELECT ev.id, ev.estado, emp.id id_empleado, emp.nombre, emp.apellido, emp.cedula, ccosto.descripcion ccosto
                    FROM sedp_dev.evaluaciones AS ev
                    INNER JOIN sedp_dev.empleados AS emp ON emp.id_evaluador = $evaluador
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.$ccosto AS ccosto ON ccosto.id = nor.id_gerencia
                    WHERE ev.id_empleado = emp.id AND ev.estado = $estado";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEstadoEvaluaciones($evaluador)
    {
        try {
            $sql = "SELECT estado FROM evaluaciones WHERE id_empleado = $evaluador";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));     
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEmpSinEvaluar($nivel_org, $id_empleado)
    {
        try {
            $sql = "SELECT empall.cedula, empall.id_ccosto FROM 
                    (SELECT emp2.cedula, emp2.id_ccosto FROM empleados AS emp2
                    INNER JOIN sedp_dev_no.nivel_org AS nivel ON nivel.id = emp2.id_ccosto
                    INNER JOIN sedp_dev_no.gerencias ON sedp_dev_no.gerencias.id = nivel.id_gerencia
                    WHERE sedp_dev_no.gerencias.id = $nivel_org AND emp2.id <> $id_empleado) AS empall
                    LEFT JOIN (SELECT emp.cedula, emp.nombre, emp.apellido, emp.id_ccosto FROM empleados AS emp 
                    INNER JOIN evaluaciones AS eva ON emp.id = eva.id_empleado
                    INNER JOIN sedp_dev_no.nivel_org AS nivel ON nivel.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.gerencias ON sedp_dev_no.gerencias.id = nivel.id_gerencia
                    WHERE sedp_dev_no.gerencias.id = $nivel_org ORDER BY emp.id_ccosto) AS empeval ON empeval.cedula = empall.cedula 
                    WHERE empeval.cedula is null GROUP BY id_ccosto";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));    
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getGerSinEvaluar($id_empleado)
    {
        try {
            $sql = "SELECT empall.cedula, empall.id_ccosto FROM 
            (SELECT emp2.cedula, emp2.id_ccosto FROM empleados AS emp2
            WHERE emp2.id_evaluador = $id_empleado AND emp2.id <> $id_empleado) AS empall
            
            LEFT JOIN (SELECT emp.cedula, emp.nombre, emp.apellido, emp.id_ccosto FROM empleados AS emp 
            INNER JOIN evaluaciones AS eva ON emp.id = eva.id_empleado
            ORDER BY emp.id_ccosto) AS empeval ON empeval.cedula = empall.cedula 
            WHERE empeval.cedula is null GROUP BY id_ccosto";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));    
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getNivelOrg($id)
    {
        try {
            $sql = "SELECT ger_gral.id id_ger_gral, ger_gral.descripcion gerencia_gral,  
                    ger.id id_ger, ger.descripcion gerencia, 
                    divi.id id_divi, divi.descripcion division, 
                    dep.id id_dep, dep.descripcion departamento, 
                    coord.id id_coord, coord.descripcion coordinacion, 
                    ofi.id id_ofi, ofi.descripcion oficinas 
                    FROM nivel_org nor
                    INNER JOIN gerencia_gral AS ger_gral ON ger_gral.id = nor.id_ger_gral
                    INNER JOIN gerencias AS ger ON ger.id = nor.id_gerencia
                    INNER JOIN divisiones AS divi ON divi.id = nor.id_division
                    INNER JOIN departamentos AS dep ON dep.id = nor.id_departamento
                    INNER JOIN coordinaciones AS coord ON coord.id = nor.id_coordinacion
                    INNER JOIN oficinas AS ofi ON ofi.id = nor.id_oficina
                    WHERE nor.id = '$id'";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getPromedioGerencias($nivel_org) 
    {
        try
        {
            $sql = "SELECT AVG(puntaje) AS promedio FROM empleados AS emp 
                    INNER JOIN evaluaciones ON evaluaciones.id_empleado = emp.id
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.gerencias AS ger ON ger.id = nor.id_gerencia
                    WHERE ger.id = $nivel_org ORDER BY emp.id_ccosto";
            
            $stmt = $this->conn->prepare($sql );
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));    
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }    

    public function getGerenciaInfo($nivel_org)
    {
        try {
            $sql = "SELECT ger.descripcion, emp.nombre, emp.apellido, emp.cedula FROM empleados emp
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.gerencias AS ger ON ger.id = nor.id_gerencia
                    WHERE nor.id = $nivel_org AND emp.es_evaluador = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getGerencias($id_evaluador=1)
    {
        try {
            $sql = "SELECT nor.id nivel_org, ger.id, ger.descripcion AS des FROM sedp_dev_no.nivel_org nor
                    INNER JOIN (SELECT id, id_ccosto FROM empleados WHERE id_evaluador = $id_evaluador) AS emp ON emp.id_ccosto = nor.id
                    INNER JOIN sedp_dev_no.gerencias AS ger ON ger.id = nor.id_gerencia
                    WHERE nor.id_gerencia <> 0";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getDivisiones($id_evaluador=null, $todos=true)
    {
        try {
            $sql = "SELECT DISTINCT nor.id nivel_org, divi.id, divi.descripcion AS des FROM sedp_dev_no.nivel_org nor
                    INNER JOIN (SELECT id, id_ccosto FROM empleados WHERE id_evaluador = $id_evaluador) AS emp ON emp.id_ccosto = nor.id
                    INNER JOIN sedp_dev_no.divisiones AS divi ON nor.id_division = divi.id
                    WHERE nor.id_division <> 0 AND nor.id_departamento = 0 AND nor.id_coordinacion = 0";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($todos) 
			? ($stmt->fetchAll(PDO::FETCH_ASSOC))
			: ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getNivelOrg2($id_unidad)
    {
        try {
            $sql = "SELECT nor.id nivel_org FROM sedp_dev_no.nivel_org nor 
                    WHERE nor.id_division = $id_unidad AND nor.id_departamento = 0 AND nor.id_coordinacion = 0";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getDepartamentos($id_evaluador)
    {
        try {
            //if ($id_evaluador) {
				$sql = "SELECT DISTINCT nor.id nivel_org, dep.id id, dep.descripcion AS des FROM sedp_dev_no.nivel_org nor
						INNER JOIN (SELECT id, id_ccosto FROM empleados WHERE id_evaluador = $id_evaluador) as emp ON nor.id = emp.id_ccosto
						INNER JOIN sedp_dev_no.departamentos AS dep ON dep.id = nor.id_departamento
						WHERE nor.id_departamento <> 0";
						
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				return ($stmt->fetchAll(PDO::FETCH_ASSOC));
			// }
			// else {
			// 	$sql = "SELECT nor.id nivel_org, dep.id id, dep.descripcion AS des FROM sedp_dev_no.nivel_org nor
			// 			INNER JOIN sedp_dev_no.departamentos AS dep ON dep.id = nor.id_departamento
			// 			WHERE nor.id = $nivel_org";
						
			// 	$stmt = $this->conn->prepare($sql);
			// 	$stmt->execute();
			// 	return ($stmt->fetch(PDO::FETCH_ASSOC));
			// }
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getCoordinaciones($id_evaluador, $nivel_org=null) 
	{
      	try
        {
			if ($id_evaluador) {
				$sql = "SELECT DISTINCT nor.id nivel_org, coord.id id, coord.descripcion AS des FROM sedp_dev_no.nivel_org nor
						INNER JOIN (SELECT id, id_ccosto FROM empleados WHERE id_evaluador = $id_evaluador) as emp ON nor.id = emp.id_ccosto
						INNER JOIN sedp_dev_no.coordinaciones AS coord ON coord.id = nor.id_coordinacion
						WHERE nor.id_coordinacion <> 0";
						
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				return ($stmt->fetchAll(PDO::FETCH_ASSOC));
			}
			else {
				$sql = "SELECT nor.id nivel_org, coord.id id, coord.descripcion AS des FROM sedp_dev_no.nivel_org nor
						INNER JOIN sedp_dev_no.coordinaciones AS coord ON coord.id = nor.id_coordinacion
						WHERE nor.id = $nivel_org";
						
				$stmt = $this->conn->prepare($sql);
				$stmt->execute();
				return ($stmt->fetch(PDO::FETCH_ASSOC));
			}
      	}
		catch (PDOException $e) {
			if ($this->showErrors) {
				print "Error!: " . $e->getMessage() . "<br/>";
				die();
			}
			return false;
		}
    }	    

    public function getDep($nivel_org)
    {
        try {
            $sql = "SELECT  dev.id FROM sedp_dev_no.nivel_org nor
                    INNER JOIN sedp_dev_no.departamentos AS dep ON dep.id = nor.id_departamento
                    WHERE nor.id = $nivel_org AND nor.id_departamento <> 0 ";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getDiv($nivel_org)
    {
        try {
            $sql = "SELECT divi.id FROM sedp_dev_no.nivel_org nor
                    INNER JOIN sedp_dev_no.divisiones AS divi ON divi.id = nor.id_division
                    WHERE nor.id = $nivel_org AND nor.id_division <> 0";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

	public function getPuntajes($id_evaluador, $nivel_org, $sin_evaluador=false)
	{
		try
		{
			$condicion = ($sin_evaluador)
			? "emp.id_evaluador = $id_evaluador AND emp.id_ccosto = $nivel_org"
			: "emp.id_evaluador = $id_evaluador OR emp.id = $id_evaluador";

			$sql = "SELECT eva.puntaje FROM evaluaciones eva
					INNER JOIN empleados AS emp ON emp.id = eva.id_empleado
					WHERE $condicion";
		
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			return ($stmt->fetchAll(PDO::FETCH_ASSOC));
		}
		catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
	}

    public function getEvaluador($nivel_org)
    {
        try {
            $sql = "SELECT e.id, e.nombre, e.apellido, e.cedula FROM sedp_dev.empleados e
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = e.id_ccosto
                    WHERE e.id_ccosto=$nivel_org AND es_evaluador = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEvaluadorGer($nivel_org)
    {
        try {
            $sql = "SELECT emp.id, emp.nombre, emp.apellido, emp.cedula, ger.descripcion gerencia FROM empleados emp
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.gerencias AS ger ON ger.id = nor.id_gerencia
                    WHERE emp.id_ccosto = $nivel_org AND emp.es_evaluador = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEvaluadorDiv($nivel_org)
    {
        try {
            $sql = "SELECT emp.id, emp.nombre, emp.apellido, emp.cedula, divi.descripcion division FROM empleados emp
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.divisiones AS divi ON divi.id = nor.id_division
                    WHERE emp.id_ccosto = $nivel_org AND emp.es_evaluador = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEvaluadorDep($nivel_org)
    {
        try {
            $sql = "SELECT emp.id, emp.nombre, emp.apellido, emp.cedula, dep.descripcion AS departamento FROM empleados emp
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.departamentos AS dep ON dep.id = nor.id_departamento
                    WHERE emp.id_ccosto = $nivel_org AND es_evaluador = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEvaluadorCoord($nivel_org)
    {
        try {
            $sql = "SELECT emp.id,  emp.nombre, emp.apellido, emp.cedula, coord.descripcion coordinacion FROM empleados emp
                    INNER JOIN sedp_dev_no.nivel_org AS nor ON nor.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.coordinaciones AS coord ON coord.id = nor.id_coordinacion
                    WHERE emp.id_ccosto = $nivel_org AND emp.es_evaluador = 1";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } 
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getDatosEmpleadosEditar($id)
    {
        try {
            $sql = "SELECT id_datos_personas, cedula, nombres, apellidos, unidad, cargo, Grupo, foto, CCosto,V.id_vehiculo,id_vh, marca, modelo, placa, color, tipo_combus, tipo_car, codigo_qr, fecha_creacion
                    FROM (SELECT id_datos_personas, cedula, nombres, apellidos, unidad, cargo, b.descripcion Grupo, c.descripcion CCosto,foto,fecha_creacion
                    FROM `sc_datos_personas` a, sc_grupos b, sc_centro_costo c
                    WHERE a.id_grupo = b.id_grupo AND a.id_ccosto = c.id AND estado <> 'RETIRADO') AS P, (SELECT id_vehiculo, b.id id_vh, b.descripcion marca, modelo, placa, color, tipo_combus, tipo_car, codigo_qr FROM `sc_vehiculos` AS a, sc_marcas_vehiculos b WHERE a.id_marca = b.id) AS V, sc_personas_vehiculos AS PV
                    WHERE P.id_datos_personas = PV.id_personas AND V.id_vehiculo = PV.id_vehiculo AND cedula = '$id'
                    ORDER BY fecha_creacion";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function getEvaluacionesGerEnviadas($nivel_org=100) 
	{
        try
        {
            $sql = "SELECT empall.cedula, empall.nombre, empall.apellido, empall.id_ccosto FROM 
                    (SELECT emp2.cedula, emp2.nombre, emp2.apellido, emp2.id_ccosto FROM empleados AS emp2
                    INNER JOIN sedp_dev_no.nivel_org AS nivel ON nivel.id = emp2.id_ccosto
                    INNER JOIN sedp_dev_no.gerencias ON sedp_dev_no.gerencias.id = nivel.id_gerencia
                    WHERE sedp_dev_no.gerencias.id = $nivel_org) AS empall
                    INNER JOIN (SELECT emp.cedula, emp.nombre, emp.apellido, eva.estado FROM empleados AS emp 
                    INNER JOIN evaluaciones AS eva ON emp.id = eva.id_empleado) AS empeval ON empeval.cedula = empall.cedula
                    WHERE empeval.estado = 2";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    /*************************************************************************************************************/
    /*                                              I N S E R T                                                  */
    /*************************************************************************************************************/

    public function insertEmpleados($data)
    {
        try {

            $sql = "INSERT INTO empleados (nombre, apellido, cedula) VALUES (:nombre, :apellido, :cedula)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function insertEvaluacion($data)
    {
        try {
            $sql = "INSERT INTO evaluaciones (puntaje, estado, id_empleado, id_proceso)
			        VALUES (:puntaje, :estado, :id_empleado, :id_proceso)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return $this->conn->lastInsertId();
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function insertEvaluacionCalificacion($id_evaluacion, $item1, $item2, $item3, $item4, $item5)
    {
        try {
            $sql = "INSERT INTO evaluacion_calificacion (id_evaluacion, id_calificacion) 
                    VALUES ('$id_evaluacion', '$item1'), ('$id_evaluacion', '$item2'), 
                    ('$id_evaluacion', '$item3'), ('$id_evaluacion', '$item4'), ('$id_evaluacion', '$item5')";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function insertConexion($data, $logout)
    {
        try {
            if ($logout) {
                $sql = "UPDATE conexiones SET salida=NOW() WHERE id=:id_conexion";

                $stmt = $this->conn->prepare($sql);
                $stmt->execute($data);
                return true;
            }
            $sql = "INSERT INTO conexiones (id_usuario, ip, navegador)
			        VALUES (:id_usuario, :ip, :navegador)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return $this->conn->lastInsertId();
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }

    /*************************************************************************************************************/
    /*                                              U P D A T E                                                  */
    /*************************************************************************************************************/


    public function updateClave($id, $clave)
    {
        try {
            $sql = "UPDATE usuarios SET clave = '$clave' WHERE id = $id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        }
        catch (PDOException $e) {
            return false;
        }
    }

    public function updateDatosEmpleados($data)
    {
        try {
            $sql = "UPDATE empleados SET cedula = :cedula, nombre = :nombre, apellido = :apellido WHERE id_empleados = :id_empleados";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($data);
            return true;
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function updateEvaluacion($puntaje, $id)
    {
        try {
            $sql = "UPDATE evaluaciones SET puntaje = '$puntaje' WHERE id = '$id'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function updateEvaluaciones($nivel_org)
    {
        try {
            $sql = "UPDATE evaluaciones SET estado = 2 WHERE id IN (SELECT eva.id FROM empleados AS emp 
                    INNER JOIN evaluaciones AS eva ON eva.id_empleado = emp.id
                    INNER JOIN sedp_dev_no.nivel_org AS nivel ON nivel.id = emp.id_ccosto
                    INNER JOIN sedp_dev_no.gerencias AS ger ON ger.id = nivel.id_gerencia
                    WHERE ger.id = $nivel_org)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function updateProceso($id)
    {
        try {
            $sql = "UPDATE procesos SET estado = 1 WHERE id = $id";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return true;
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    /*************************************************************************************************************/
    /*                                              D E L E T E                                                 */
    /*************************************************************************************************************/

    public function deleteEmpleados($id_empleados)
    {
        try {
            $sql = "DELETE FROM empleados WHERE id_empleados = :id_empleados";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(array(':id_empleados' => $id_empleados));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            return false;
        }
    }

    public function deleteEvaluacion($id)
    {
        try {
            $sql= "DELETE FROM evaluaciones WHERE id = '$id'";	
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }

    public function deleteEvaluacionCalificacion($id_evaluacion)
    {
        try {
            $sql = "DELETE FROM evaluacion_calificacion WHERE id_evaluacion = '$id_evaluacion'";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->rowCount();
        }
        catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }
}
