<?php
    // Definición de la clase Database para gestionar la conexión a una base de datos
    class Database {
        // Propiedades privadas que almacenan los datos de conexión
        private $host = 'localhost'; // Dirección del servidor de la base de datos
        private $user = 'root';      // Usuario de la base de datos
        private $password = '';      // Contraseña del usuario
        private $database = 'apirest'; // Nombre de la base de datos

        // Método público que establece la conexión a la base de datos y la devuelve
        public function getConnection() {
            // Construcción de la cadena DSN para conectar a MySQL usando PDO
            $hostDB = "mysql:host=" . $this->host . ";dbname=" . $this->database . ";";

            try {
                // Creación de una nueva instancia de PDO con la configuración especificada
                $connection = new PDO($hostDB, $this->user, $this->password);

                // Configuración de atributos para manejar errores con excepciones
                $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                // Devuelve la conexión exitosa
                return $connection;
            } catch (PDOException $e) {
                // Captura de errores y terminación del script con un mensaje de error
                die("ERROR: " . $e->getMessage());
            }
        }
    }
?>
