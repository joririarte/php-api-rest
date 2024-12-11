<?php
    // Se incluye el archivo que contiene la clase Client
    require_once('./includes/Client.class.php');

    // Verifica si la solicitud HTTP es de tipo PUT
    if (
        $_SERVER['REQUEST_METHOD'] == 'PUT' && // Comprueba que el método de la solicitud sea PUT
        isset($_GET['id']) &&                 // Verifica que se haya enviado el parámetro 'id'
        isset($_GET['email']) &&              // Verifica que se haya enviado el parámetro 'email'
        isset($_GET['name']) &&               // Verifica que se haya enviado el parámetro 'name'
        isset($_GET['city']) &&               // Verifica que se haya enviado el parámetro 'city'
        isset($_GET['telephone'])             // Verifica que se haya enviado el parámetro 'telephone'
    ) {
        // Llama al método estático 'update_client' de la clase Client
        // Pasando los parámetros necesarios para actualizar un cliente
        Client::update_client(
            $_GET['id'],        // ID del cliente a actualizar
            $_GET['email'],     // Nuevo correo electrónico
            $_GET['name'],      // Nuevo nombre
            $_GET['city'],      // Nueva ciudad
            $_GET['telephone']  // Nuevo teléfono
        );
    }
?>
