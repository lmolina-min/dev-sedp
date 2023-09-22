/* ACTUALIZAR ID DE EVALUADORES */
UPDATE empleados AS emp SET emp.id_evaluador = (SELECT eva.id FROM empleados AS eva WHERE eva.cedula = emp.id_evaluador)