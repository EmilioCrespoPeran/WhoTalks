<?php
namespace model;

/**
 * Gestor general para la base de datos.
 */
class DBMS {

    // Variables para la conexion con la base de datos
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db = "whotalks";
    private $connection;

    /**
     * Conecta con la base de datos
     */
    private function connect() {
        $this->connection = mysqli_connect($this->host, $this->user, $this->pass, $this->db);
    }

    /**
     * Realiza una consulta con la base de datos
     * @param string $sql Consulta SQL
     */
    protected function query($sql) {
        $this->connect();
        $results = null;

        if($this->connection) {
            // Ejecuta la consulta
            $results = mysqli_query($this->connection, $sql);
            $this->close();
            return $results;
        }
        else {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    /**
     * Desconecta con la base de datos
     */
    private function close() {
        mysqli_close($this->connection);
    }

}
