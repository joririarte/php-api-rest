<?php
    // Incluye la clase Database para la conexión con la base de datos
    require_once('Database.class.php');

    // Definición de la clase Client para gestionar operaciones CRUD sobre clientes
    class Client {
        // Método estático para crear un nuevo cliente en la base de datos
        public static function create_client($email, $name, $city, $telephone) {
            // Crear una instancia de la clase Database y obtener la conexión
            $database = new Database();
            $conn = $database->getConnection();

            // Preparar la consulta SQL para insertar un nuevo cliente
            $stmt = $conn->prepare('INSERT INTO listado_clientes(email, name, city, telephone) 
                                    VALUES (:email, :name, :city, :telephone)');
            
            // Asociar los valores de los parámetros a la consulta preparada
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':telephone', $telephone);

            // Ejecutar la consulta y verificar si se realizó correctamente
            if ($stmt->execute()) {
                // Enviar una cabecera HTTP indicando que el cliente fue creado
                header('HTTP/1.1 201 Cliente creado correctamente');
            } else {
                // Enviar una cabecera HTTP indicando que hubo un error
                header('HTTP/1.1 404 Cliente no se ha creado correctamente');
            }
        }

        // Método estático para eliminar un cliente por su ID
        public static function delete_client_by_id($id) {
            // Crear una instancia de la clase Database y obtener la conexión
            $database = new Database();
            $conn = $database->getConnection();

            // Preparar la consulta SQL para eliminar un cliente
            $stmt = $conn->prepare('DELETE FROM listado_clientes WHERE id=:id');
            
            // Asociar el ID del cliente al parámetro de la consulta
            $stmt->bindParam(':id', $id);

            // Ejecutar la consulta y verificar si se realizó correctamente
            if ($stmt->execute()) {
                // Enviar una cabecera HTTP indicando que el cliente fue borrado
                header('HTTP/1.1 201 Cliente borrado correctamente');
            } else {
                // Enviar una cabecera HTTP indicando que hubo un error
                header('HTTP/1.1 404 Cliente no se ha borrado correctamente');
            }
        }

        // Método estático para obtener todos los clientes de la base de datos
        public static function get_all_clients() {
            // Crear una instancia de la clase Database y obtener la conexión
            $database = new Database();
            $conn = $database->getConnection();

            // Preparar la consulta SQL para seleccionar todos los clientes
            $stmt = $conn->prepare('SELECT * FROM listado_clientes');

            // Ejecutar la consulta y verificar si se realizó correctamente
            if ($stmt->execute()) {
                // Obtener los resultados como un arreglo y codificarlos en JSON
                $result = $stmt->fetchAll();
                echo json_encode($result);

                // Enviar una cabecera HTTP indicando que la operación fue exitosa
                header('HTTP/1.1 201 OK');
            } else {
                // Enviar una cabecera HTTP indicando que hubo un error
                header('HTTP/1.1 404 Cliente no se ha podido consultar los clientes');
            }
        }

        // Método estático para actualizar los datos de un cliente
        public static function update_client($id, $email, $name, $city, $telephone) {
            // Crear una instancia de la clase Database y obtener la conexión
            $database = new Database();
            $conn = $database->getConnection();

            // Preparar la consulta SQL para actualizar un cliente
            $stmt = $conn->prepare('UPDATE listado_clientes 
                                     SET email=:email, name=:name, city=:city, telephone=:telephone 
                                     WHERE id=:id');
            
            // Asociar los valores de los parámetros a la consulta preparada
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':telephone', $telephone);
            $stmt->bindParam(':id', $id);

            // Ejecutar la consulta y verificar si se realizó correctamente
            if ($stmt->execute()) {
                // Enviar una cabecera HTTP indicando que el cliente fue actualizado
                header('HTTP/1.1 201 Cliente actualizado correctamente');
            } else {
                // Enviar una cabecera HTTP indicando que hubo un error
                header('HTTP/1.1 404 Cliente no se ha actualizado correctamente');
            }
        }
    }
?>
