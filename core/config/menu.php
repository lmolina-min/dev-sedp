<?php
$modulos = [
    [
        "titulo"   => "Inicio",
        "ruta"     => "/index.php",
        "icono"    => "chart-simple",
        "roles"    => null,
    ],
    [
        "titulo"   => "Evaluaciones",
        "ruta"     => "/evaluaciones.php",
        "icono"    => "clipboard-list",
        "roles"    => [0, 1, 2, 3, 4],
    ],
    [
        "titulo"   => "Reportes",
        "ruta"     => "",
        "icono"    => "file",
        "roles"    => [0, 1, 10],
        "sub"      => [
            [
                "titulo" => "Listado",
                "ruta"   => "/reportes.php",
                "roles"  => [0, 1, 10],
            ],
            [
                "titulo" => "Gráfico",
                "ruta"   => "/reportes.php?page=grafico",
                "roles"  => [0, 10],
            ],
        ],
    ],
    [
        "titulo"   => "Administración",
        "ruta"     => "",
        "icono"    => "gears",
        "roles"    => [10],
        "sub"      => [
            [
                "titulo" => "Procesos",
                "ruta"   => "/administracion.php?page=procesos",
                "roles"  => [10],
            ],
            [
                "titulo" => "Aspectos",
                "ruta"   => "/administracion.php?page=aspectos",
                "roles"  => [10],
            ],
            [
                "titulo" => "Usuarios",
                "ruta"   => "/administracion.php?page=usuarios",
                "roles"  => [10],
            ],
        ],
    ],
];
?>