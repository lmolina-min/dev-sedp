<?php

$nivel = '';
$cod_nivel = '';
foreach ($query2 as $query2) {
	$gerencia_gral = $query2['gerencia_gral'] . " --> ";
	$gerencia = $query2['gerencia'];
	$gerenciaop = $query2['gerencia_gral_op'] != '' ? " --> " . $query2['gerencia_gral_op'] : '';
	$division = $query2['division'] != '' ? " --> " . $query2['division'] : '';
	$departamento = $query2['departamento'] != '' ? " --> " . $query2['departamento'] : '';
	$coordinacion = $query2['coordinacion'] != '' ? " --> " . $query2['coordinacion'] : '';
	$oficinas = $query2['oficinas'] != '' ? " --> " . $query2['oficinas'] : '';
	$nivel = $gerencia_gral . $gerencia . $gerenciaop . $division . $departamento . $coordinacion . $oficinas;

	$cod_nivel = $query2['id_ger'];
	$cod_nivel .= $query2['id_ger_oper'] <> 0 ? " |" . $query2['id_ger_oper'] : '';
	$cod_nivel .= $query2['id_div'] <> 0 ? "|" . $query2['id_div'] : '';
	$cod_nivel .= $query2['id_dep'] <> 0 ? "|" . $query2['id_dep'] : '';
	$cod_nivel .= $query2['id_coord'] <> 0 ? "|" . $query2['id_coord'] : '';
}

$_SESSION['cod_nivel'] = $cod_nivel;

function des_nivel ($query2){
	$nivel = '';
	$cod_nivel = '';
	foreach ($query2 as $query2) {
		$gerencia_gral = $query2['gerencia_gral'] . "|";
		$gerencia = $query2['gerencia'];
		$gerenciaop = $query2['gerencia_gral_op'] != '' ? "|" . $query2['gerencia_gral_op'] : '';
		$division = $query2['division'] != '' ? "|" . $query2['division'] : '';
		$departamento = $query2['departamento'] != '' ? "|" . $query2['departamento'] : '';
		$coordinacion = $query2['coordinacion'] != '' ? "|" . $query2['coordinacion'] : '';
		$oficinas = $query2['oficinas'] != '' ? "|" . $query2['oficinas'] : '';
		$nivel = $gerencia_gral . $gerencia . $gerenciaop . $division . $departamento . $coordinacion . $oficinas;
	}
	$des = explode("|", $nivel );
	return $des[count($des)-1];
}
?>