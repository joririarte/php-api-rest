<?php 
    // Se incluye el archivo que contiene la clase Client
    require_once('./includes/Client.class.php');

    // Verifica si la solicitud HTTP es de tipo DELETE y si se ha proporcionado el parámetro 'id'
    if ($_SERVER['REQUEST_METHOD'] == 'DELETE' &&
        isset($_GET['id'])) {
        
        // Llama al método estático 'delete_client_by_id' de la clase Client para eliminar el cliente
        Client::delete_client_by_id($_GET['id']); // Pasa el 'id' proporcionado como parámetro
    }
?>
