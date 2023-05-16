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
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    /*************************************************************************************************************/
    /*                                              S E L E C T                                                  */
    /*************************************************************************************************************/

    public function getLoginUsuario($login, $pass)
    {
        try {
            $query = "SELECT login, u.id_perfil, id_ccosto as id_nivel_org, emp.cedula as evaluador
						FROM sc_datos_usuarios as u
						INNER JOIN sc_perfiles as p
						ON u.id_perfil=p.id_perfil 
 						INNER JOIN se_empleado as emp
 						ON emp.id=u.id_empleado
						WHERE login=:login AND pass=:pass AND estatus='1'";

            $stmt = $this->conn->prepare($query);
            $stmt->execute([':login' => $login, ':pass' => $pass]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print_r("Error!: " . $e->getMessage() . "<br/>");
            //     die();
            // }
            return false;
        }
    }

    public function getMenus()
    {
        try {
            $query = "SELECT * FROM sc_menu";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getModulos($idmenu, $perfil)
    {
        try {
            $query = "SELECT m.url_modulo, m.nombre FROM sc_modulos AS m 
                                              INNER JOIN sc_permisos AS p
                                              ON p.id_modulos = m.id_modulos
                                              INNER JOIN sc_datos_usuarios AS s
                                              ON s.id_perfil = p.id_perfil
                                              WHERE p.id_perfil = '$perfil' and m.id_menu = '$idmenu'  group by url_modulo";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getRootModulos($id_menu)
    {
        try {
            $query = "SELECT * FROM sc_modulos WHERE id_menu = $id_menu";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getDatosEmpleadosAll()
    {
        try {
            $query = "SELECT * FROM empleados";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }
    public function getDatosEmpleado($id_empleado)
    {
        try {
            $query = "SELECT * FROM sc_datos_usuarios WHERE id_empleado=".$id_empleado;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getDatosEmpleadosxNivelOrg($evaluador)
    {
        try {
            $query = "SELECT count(*) as total FROM se_empleado WHERE evaluado_por=".$evaluador;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEmpleadosxEval($nivel_org, $evaluador)
    {
        try {
            $query = "SELECT id, eva.id_eval, cedula, nombre, apellido, id_nomina, eva.estatus
		 		 FROM se_empleado as emp
                 LEFT JOIN se_evaluacion as eva
                 ON emp.id = eva.id_empleado
				  WHERE eva.id_eval is null  and evaluado_por = " . $evaluador . " and (eva.estatus = 0  or eva.estatus is null)";
            
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEmpleadosEvaluados($evaluador)
    {
        try {
            $query = "SELECT emp.id, emp.id_nomina, eva.id_eval ,cedula, nombre,apellido,  car.descripcion as cargo, (SELECT concat_ws(' ', nombre, apellido) from se_empleado where cedula = (SELECT evaluado_por FROM se_empleado where cedula = " . $evaluador . ")) to_send ,eva.puntaje
					  FROM se_empleado as emp 
						INNER JOIN se_cargo as car
						ON emp.id_cargo = car.id
						INNER JOIN se_evaluacion as eva
						ON emp.id = eva.id_empleado
					  WHERE eva.estatus <> 3 and emp.evaluado_por = " . $evaluador . ""; //revisar estatus

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getFormatoEval($id_nomina)
    {
        try {
            $query = "SELECT fe.id_factor, titulo, subtitulo, nivel, ifa.id as id_item_factor, ifa.descripcion, ifa.valor
		 		 FROM `se_factores_eval`  as fe

				 INNER JOIN se_item_factor as ifa

				 ON fe.id_factor = ifa.id_factor

				 WHERE id_tipo_nomina = " . $id_nomina . "
				 ORDER BY fe.id_factor, RAND();";
            //ORDER BY RAND()
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getFormatoEditar($id_nomina, $id_eval)
    {
        try {
            $query = "SELECT  itf.id as id_item_factor                 
                 
                 FROM  se_evaluacion  as eva

				 INNER JOIN se_eval_item_factor as eif

				 ON  eva.id_eval = eif.id_eval_emp
                 
                 INNER JOIN se_item_factor as itf
                 ON eif.id_item_factor = itf.id
                 
                 INNER JOIN se_factores_eval as fe
                 ON itf.id_factor = fe.id_factor
				 WHERE fe.id_tipo_nomina = " . $id_nomina . " and eva.id_eval = " . $id_eval . "";
            //ORDER BY RAND()
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getResultxGerencias($nivel_org)
    {
        try {
            $query = "SELECT emp.cedula, emp.nombre, emp.apellido, emp.id_ccosto, emp.id_cargo, se_cargo.descripcion as cargo, puntaje
        FROM se_empleado as emp 
        inner join se_evaluacion
        on emp.id = se_evaluacion.id_empleado
        inner join se_cargo
        on emp.id_cargo = se_cargo.id
        inner join bd_nivel_org.nivel_org as nivel
        on nivel.id = emp.id_ccosto
        inner join bd_nivel_org.gerencias
        on bd_nivel_org.gerencias.id_ger = nivel.id_gerencia
        where bd_nivel_org.gerencias.id_ger = " . $nivel_org . "
        order by emp.id_ccosto";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            //if ($varios){
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
            //  }else{
            //     return ($stmt->fetch(PDO::FETCH_ASSOC));
            // }      
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEstatus_eval_gerencias($nivel_org)
    {
        try {
            $query = "SELECT empall.cedula, empall.nombre, empall.apellido, empall.id_ccosto from (SELECT emp2.cedula,emp2.nombre,emp2.apellido, emp2.id_ccosto   
            FROM se_empleado as emp2
            inner join bd_nivel_org.nivel_org as nivel
            on nivel.id = emp2.id_ccosto
            inner join bd_nivel_org.gerencias
            on bd_nivel_org.gerencias.id_ger = nivel.id_gerencia
            where bd_nivel_org.gerencias.id_ger =  $nivel_org  ) as empall
            INNER JOIN
            (SELECT emp.cedula, emp.nombre, emp.apellido, estatus
                FROM se_empleado as emp
                inner join se_evaluacion
                on emp.id = se_evaluacion.id_empleado
            ) as empeval
            ON empeval.cedula = empall.cedula
            WHERE empeval.estatus = 2;";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEstatus_eval_x_emp($evaluador)
    {
        try {
            $query = "select estatus from se_evaluacion where id_empleado = (select id from se_empleado where cedula = " . $evaluador . ");";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            //if ($varios){
            return ($stmt->fetch(PDO::FETCH_ASSOC));
            //  }else{
            //     return ($stmt->fetch(PDO::FETCH_ASSOC));
            // }      
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEmpSinEval($nivel_org)
    {
        try {
            $query = "SELECT empall.cedula, empall.id_ccosto from (SELECT emp2.cedula, emp2.id_ccosto   
                FROM se_empleado as emp2
                inner join bd_nivel_org.nivel_org as nivel
                on nivel.id = emp2.id_ccosto
                inner join bd_nivel_org.gerencias
                on bd_nivel_org.gerencias.id_ger = nivel.id_gerencia
                where bd_nivel_org.gerencias.id_ger =  $nivel_org  ) as empall
                LEFT JOIN
                (SELECT emp.cedula, emp.nombre, emp.apellido, emp.id_ccosto, emp.id_cargo, se_cargo.descripcion as cargo, puntaje
                        FROM se_empleado as emp 
                        inner join se_evaluacion
                        on emp.id = se_evaluacion.id_empleado
                        inner join se_cargo
                        on emp.id_cargo = se_cargo.id
                        inner join bd_nivel_org.nivel_org as nivel
                        on nivel.id = emp.id_ccosto
                        inner join bd_nivel_org.gerencias
                        on bd_nivel_org.gerencias.id_ger = nivel.id_gerencia
                        where bd_nivel_org.gerencias.id_ger = $nivel_org
                        order by emp.id_ccosto) as empeval 
                ON    empeval.cedula = empall.cedula
                WHERE empeval.cedula is null";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            //if ($varios){
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
            //  }else{
            //     return ($stmt->fetch(PDO::FETCH_ASSOC));
            // }      
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getNivelOrg($id)
    {
        try {
            $query = "SELECT ger_gral.id_ger_gral, gerencia_gral,  ger.id_ger, gerencia, ger_gral_op.id_ger_oper, gerencia_gral_op, divi.id_div, division, dep.id_dep, departamento,coord.id_coord,coordinacion,oficinas FROM nivel_org
	
                INNER JOIN (SELECT id_ger_gral, descripcion  as gerencia_gral FROM gerencia_gral) as ger_gral
                ON  nivel_org.id_ger_gral = ger_gral.id_ger_gral
                
                INNER JOIN (SELECT id_ger_oper, descripcion  as gerencia_gral_op FROM gcia_gral_op) as ger_gral_op
                ON  nivel_org.id_ger_gral_op = ger_gral_op.id_ger_oper
            
                INNER JOIN (SELECT id_ger, des_ger as gerencia FROM gerencias) as ger
                ON  id_gerencia = ger.id_ger
            
                INNER JOIN (SELECT id_div, des_div as division FROM divisiones) as divi
                ON  id_division = divi.id_div

                INNER JOIN (SELECT id_dep, des_dep as departamento FROM departamentos) as dep
                ON  id_departamento = dep.id_dep

                INNER JOIN (SELECT id_coord, des_coord as coordinacion FROM coordinaciones) as coord
                ON  id_coordinacion = coord.id_coord
                
                INNER JOIN (SELECT id_ofi, des_ofi as oficinas FROM oficina) as ofis
                ON  id_oficina = ofis.id_ofi 
                
                WHERE id = " . $id;

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getGerencias($evaluador)
    {
        try {
            $query = "select  id, bd_nivel_org.gerencias.des_ger as des, bd_nivel_org.gerencias.id_ger  from bd_nivel_org.nivel_org 
            inner join  (SELECT id_ccosto from bd_eval_personal.se_empleado where evaluado_por = " . $evaluador . ") as ccosto
            on bd_nivel_org.nivel_org.id = ccosto.id_ccosto
            inner join bd_nivel_org.gerencias 
            on bd_nivel_org.nivel_org.id_gerencia = bd_nivel_org.gerencias.id_ger
            where bd_nivel_org.nivel_org.id_gerencia <> 0";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));  
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getGerenciasOp($evaluador)
    {
        try {
            $query = "select  id, bd_nivel_org.gcia_gral_op.descripcion as des  from bd_nivel_org.nivel_org 
                inner join  (SELECT id_ccosto from bd_eval_personal.se_empleado where evaluado_por = " . $evaluador . ") as ccosto
                on bd_nivel_org.nivel_org.id= ccosto.id_ccosto
                inner join bd_nivel_org.gcia_gral_op 
                on bd_nivel_org.nivel_org.id_ger_gral_op = bd_nivel_org.gcia_gral_op.id_ger_oper
                where bd_nivel_org.gcia_gral_op .id_ger_oper  <> 0";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            //if ($varios){
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
            //  }else{
            //     return ($stmt->fetch(PDO::FETCH_ASSOC));
            // }      
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getCoordinaciones($evaluador, $nivel_org)
    {
        try {
            if ($evaluador != 0) {
                $query = "select DISTINCT  id, des_coord as des  from bd_nivel_org.nivel_org 
                inner join  (SELECT id_ccosto from bd_eval_personal.se_empleado where evaluado_por = " . $evaluador . ") as ccosto
                on bd_nivel_org.nivel_org.id= ccosto.id_ccosto
                inner join bd_nivel_org.coordinaciones
                on bd_nivel_org.nivel_org.id_coordinacion = bd_nivel_org.coordinaciones.id_coord
                where bd_nivel_org.nivel_org.id_coordinacion  <> 0";
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return ($stmt->fetchAll(PDO::FETCH_ASSOC));
            } else {
                $query = "select  id_coord, des_coord  from bd_nivel_org.nivel_org 
                inner join bd_nivel_org.coordinaciones
                on bd_nivel_org.nivel_org.id_coordinacion = bd_nivel_org.coordinaciones.id_coord
                where bd_nivel_org.nivel_org.id  =" . $nivel_org;
                $stmt = $this->conn->prepare($query);
                $stmt->execute();
                return ($stmt->fetch(PDO::FETCH_ASSOC));
            }
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getDivisiones($evaluador, $varios)
    {
        try {
            $query = " select DISTINCT  id, des_div as des from bd_nivel_org.nivel_org 
            inner join  (SELECT id_ccosto from bd_eval_personal.se_empleado where evaluado_por = " . $evaluador . ") as ccosto
            on bd_nivel_org.nivel_org.id= ccosto.id_ccosto
            inner join bd_nivel_org.divisiones
            on bd_nivel_org.nivel_org.id_division = bd_nivel_org.divisiones.id_div
            where bd_nivel_org.nivel_org.id_division  <> 0 and bd_nivel_org.nivel_org.id_departamento = 0 and bd_nivel_org.nivel_org.id_coordinacion = 0";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            if ($varios) {
                return ($stmt->fetchAll(PDO::FETCH_ASSOC));
            } else {
                return ($stmt->fetch(PDO::FETCH_ASSOC));
            }
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getDepartamentos($evaluador, $varios)
    {
        try {
            $query = "select DISTINCT  id, des_dep as des from bd_nivel_org.nivel_org 
            inner join  (SELECT id_ccosto from bd_eval_personal.se_empleado where evaluado_por = " . $evaluador . ") as ccosto
            on bd_nivel_org.nivel_org.id= ccosto.id_ccosto
            inner join bd_nivel_org.departamentos
            on bd_nivel_org.nivel_org.id_departamento = bd_nivel_org.departamentos.id_dep
            where bd_nivel_org.nivel_org.id_departamento  <> 0 and  bd_nivel_org.nivel_org.id_coordinacion = 0";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            if ($varios) {
                return ($stmt->fetchAll(PDO::FETCH_ASSOC));
            } else {
                return ($stmt->fetch(PDO::FETCH_ASSOC));
            }
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getDep($nivel_org)
    {
        try {
            $query = "select  id_dep from bd_nivel_org.nivel_org 
            inner join bd_nivel_org.departamentos
            on bd_nivel_org.nivel_org.id_departamento = bd_nivel_org.departamentos.id_dep
            where bd_nivel_org.nivel_org.id_division  = " . $nivel_org . " and id_dep <> 0 ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getDiv($nivel_org)
    {
        try {
            $query = "select  id_div from bd_nivel_org.nivel_org 
            inner join bd_nivel_org.divisiones
            on bd_nivel_org.nivel_org.id_division = bd_nivel_org.divisiones.id_div
            where bd_nivel_org.nivel_org.id  = " . $nivel_org . "  and id_div <> 0";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getResultadoxNivel($condicion, $nivel_org, $evaluador, $sinUni)
    {
        try {
            if ($sinUni) {
                $query = "select count(puntaje) as puntaje from se_evaluacion 
                inner join se_empleado
                on se_evaluacion.id_empleado = se_empleado.id
                where ( " . $condicion . " and evaluado_por = " . $evaluador . ") 
                or  (" . $condicion . " and se_empleado.cedula = " . $evaluador . ")";
            } else {
                $query = "select count(puntaje) as puntaje from se_evaluacion 
                inner join se_empleado
                on se_evaluacion.id_empleado = se_empleado.id
                where ( " . $condicion . " and evaluado_por = " . $evaluador . " and se_empleado.id_ccosto = " . $nivel_org . ") ";
            }

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEvaluadorCoord($nivel_org)
    {
        try {
            $query = "SELECT cedula, bd_nivel_org.coordinaciones.des_coord as coordinacion  FROM bd_eval_personal.se_empleado
            inner join bd_nivel_org.nivel_org 
            on id_ccosto = bd_nivel_org.nivel_org.id
            inner join bd_nivel_org.coordinaciones 
            on bd_nivel_org.nivel_org.id_coordinacion = bd_nivel_org.coordinaciones.id_coord
            WHERE id_ccosto = " . $nivel_org . " and es_evaluador = 1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEvaluadorDiv($nivel_org)
    {
        try {
            $query = "SELECT cedula, bd_nivel_org.divisiones.des_div as division  FROM bd_eval_personal.se_empleado
            inner join bd_nivel_org.nivel_org 
            on id_ccosto = bd_nivel_org.nivel_org.id
            inner join bd_nivel_org.divisiones 
            on bd_nivel_org.nivel_org.id_division = bd_nivel_org.divisiones.id_div
            WHERE id_ccosto = " . $nivel_org . " and es_evaluador = 1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));

            /*  $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':nameuser' => $nameuser, ':pass' => $pass));
      return ($stmt->fetch(PDO::FETCH_ASSOC));*/
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEvaluadorGer($nivel_org)
    {
        try {
            $query = "SELECT cedula, bd_nivel_org.gerencias.des_ger as gerencia FROM bd_eval_personal.se_empleado
            inner join bd_nivel_org.nivel_org 
            on id_ccosto = bd_nivel_org.nivel_org.id
            inner join bd_nivel_org.gerencias
            on bd_nivel_org.nivel_org.id_gerencia = bd_nivel_org.gerencias.id_ger
            WHERE id_ccosto = " . $nivel_org . " and es_evaluador = 1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEvaluadorGerOp($nivel_org)
    {
        try {
            $query = "SELECT cedula, bd_nivel_org.gcia_gral_op.descripcion as gerenciaop  FROM bd_eval_personal.se_empleado
            inner join bd_nivel_org.nivel_org 
            on id_ccosto = bd_nivel_org.nivel_org.id
            inner join bd_nivel_org.gcia_gral_op
            on bd_nivel_org.nivel_org.id_ger_gral_op = bd_nivel_org.gcia_gral_op.id_ger_oper
            WHERE id_ccosto = " . $nivel_org . " and es_evaluador = 1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));

            /*  $stmt = $this->conn->prepare($query);
      $stmt->execute(array(':nameuser' => $nameuser, ':pass' => $pass));
      return ($stmt->fetch(PDO::FETCH_ASSOC));*/
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getEvaluadorDep($nivel_org)
    {
        try {
            $query = "SELECT cedula, bd_nivel_org.departamentos.des_dep as departamento  FROM bd_eval_personal.se_empleado
            inner join bd_nivel_org.nivel_org 
            on id_ccosto = bd_nivel_org.nivel_org.id
            inner join bd_nivel_org.departamentos
            on bd_nivel_org.nivel_org.id_departamento = bd_nivel_org.departamentos.id_dep
            WHERE id_ccosto = " . $nivel_org . " and es_evaluador = 1";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetch(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function getDatosEmpleadosEditar($id)
    {
        try {
            $query = "SELECT id_datos_personas, cedula, nombres, apellidos, unidad, cargo, Grupo, foto, CCosto,V.id_vehiculo,id_vh, marca, modelo, placa, color, tipo_combus, tipo_car, codigo_qr, fecha_creacion
            FROM (SELECT id_datos_personas, cedula, nombres, apellidos, unidad, cargo, b.descripcion Grupo, c.descripcion CCosto,foto,fecha_creacion
            FROM `sc_datos_personas` a, sc_grupos b, sc_centro_costo c
            WHERE a.id_grupo = b.id_grupo and a.id_ccosto = c.id and estatus <> 'RETIRADO') AS P, (SELECT id_vehiculo, b.id id_vh, b.descripcion marca, modelo, placa, color, tipo_combus, tipo_car, codigo_qr FROM `sc_vehiculos` as a, sc_marcas_vehiculos b WHERE a.id_marca = b.id) AS V, sc_personas_vehiculos as PV
            WHERE P.id_datos_personas = PV.id_personas and V.id_vehiculo = PV.id_vehiculo and cedula = '$id'
            ORDER BY fecha_creacion";

            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return ($stmt->fetchAll(PDO::FETCH_ASSOC));
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    /*************************************************************************************************************/
    /*                                              I N S E R T                                                  */
    /*************************************************************************************************************/

    public function insertEmpleados($data)
    {
        try {

            $query = "INSERT INTO empleados (nombre, apellido, cedula) VALUES (:nombre, :apellido, :cedula)";

            $stmt = $this->conn->prepare($query);
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function insertEvaluacion($data)
    {
        try {
            $query = "INSERT INTO se_evaluacion (puntaje, estatus, id_empleado )
			VALUES (:puntaje, :estatus, :id_empleado)";

            $stmt = $this->conn->prepare($query);
            $stmt->execute($data);
            return $this->conn->lastInsertId();;
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function insertEmp_EvalItem($query)
    {
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    /*************************************************************************************************************/
    /*                                              U P D A T E                                                  */
    /*************************************************************************************************************/


    public function updateDatosEmpleados($data)
    {
        try {
            $query = "UPDATE empleados SET cedula = :cedula, nombre = :nombre, apellido = :apellido WHERE id_empleados = :id_empleados";
            $stmt = $this->conn->prepare($query);
            $stmt->execute($data);
            return true;
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function updateEvaluacion($puntaje, $id_eval)
    {
        try {
            $query = "UPDATE se_evaluacion SET puntaje=".$puntaje." WHERE id_eval=".$id_eval;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function updateEvaluacionxGerencia($nivel_org)
    {
        try {
            $query = " UPDATE se_evaluacion SET estatus = 2 WHERE id_eval IN (SELECT eval.id_eval
            FROM se_empleado as emp 
            inner join se_evaluacion as eval
            on emp.id = eval.id_empleado
            inner join bd_nivel_org.nivel_org as nivel
            on nivel.id = emp.id_ccosto
            inner join bd_nivel_org.gerencias
            on bd_nivel_org.gerencias.id_ger = nivel.id_gerencia
            where bd_nivel_org.gerencias.id_ger = $nivel_org
            ) ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    /*************************************************************************************************************/
    /*                                              D E L E T E                                                 */
    /*************************************************************************************************************/

    public function deleteEmpleados($id_empleados)
    {
        try {
            $query = "DELETE FROM empleados WHERE id_empleados = :id_empleados";
            $stmt = $this->conn->prepare($query);
            $stmt->execute(array(':id_empleados' => $id_empleados));
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // if ($this->showErrors) {
            //     print "Error!: " . $e->getMessage() . "<br/>";
            //     die();
            // }
            return false;
        }
    }

    public function deleteEvaluacion($id_eval)
    {
        try {
            $query= "DELETE FROM se_evaluacion WHERE id_eval=".$id_eval;	
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            // return false;
        }
    }

    public function deleteEval_Item_Factor($id_eval)
    {
        try {
            $query = "DELETE FROM se_eval_item_factor WHERE id_eval_emp=".$id_eval;
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->rowCount();
        } catch (PDOException $e) {
            if ($this->showErrors) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
            // return false;
        }
    }
}
