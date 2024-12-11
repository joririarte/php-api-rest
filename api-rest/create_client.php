<?php
    // Se incluye el archivo que contiene la clase Client
    require_once('./includes/Client.class.php');

    // Verifica si la solicitud HTTP es de tipo POST y si se proporcionaron los parámetros requeridos
    if ($_SERVER['REQUEST_METHOD'] == 'POST' &&
        isset($_GET['email']) &&  // Verifica si se proporcionó el parámetro 'email' en la URL
        isset($_GET['name']) &&   // Verifica si se proporcionó el parámetro 'name' en la URL
        isset($_GET['city']) &&   // Verifica si se proporcionó el parámetro 'city' en la URL
        isset($_GET['telephone'])) { // Verifica si se proporcionó el parámetro 'telephone' en la URL
        
        // Llama al método estático 'create_client' de la clase Client para crear un cliente
        Client::create_client(
            $_GET['email'],    // Toma el valor del parámetro 'email' de la URL
            $_GET['name'],     // Toma el valor del parámetro 'name' de la URL
            $_GET['city'],     // Toma el valor del parámetro 'city' de la URL
            $_GET['telephone'] // Toma el valor del parámetro 'telephone' de la URL
        );
    }
?>
