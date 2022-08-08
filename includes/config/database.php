<?php

function conectarDB(): mysqli {
    $db =new  mysqli('localhost:3306', 'ruben', 'Cuelebre243*', 'bienesRaices');

    if (!$db) {
        echo "Error fallo al conectar";
        exit;
    }
    return $db;
}