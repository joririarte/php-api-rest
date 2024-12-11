<?php 
    // Se incluye el archivo que contiene la clase Client
    require_once('./includes/Client.class.php');

    // Verifica si la solicitud HTTP es de tipo GET
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        // Llama al método estático 'get_all_clients' de la clase Client para obtener todos los clientes
        Client::get_all_clients();
    }
?>
