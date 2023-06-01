<?php

class MySqlDatabase {
    private $connection;

    public function __construct($serverName, $userName, $password, $databaseName) {
        $this->connection = mysqli_connect(
            $serverName,
            $userName,
            $password,
            $databaseName);

        if (!$this->connection) {
            die('Connection failed: ' . mysqli_connect_error());
        }
    }

    public function __destruct() {
        mysqli_close($this->connection);
    }

    public function query($query) {
        $result = $this->connection->query($query);
        
        if ($result === false) {
            if (stripos($query, 'INSERT') === 0) {
                return $this->connection->insert_id;
            }
            throw new Exception("Error en la consulta: " . $this->connection->error);
        }
        if (stripos($query, 'SELECT') === 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return true;
    }

    public function queryBoolean($sql) {
        mysqli_query($this->connection, $sql);
    }
    public function insertUser($query, $userData){
        $stmt = $this->connection->prepare($query);

        $stmt->bind_param("sssssssiss",$userData['nickName'], $userData['password'], $userData['nombre'],
            $userData['email'], $userData['ubicacion'], $userData['imagenPerfil'], $userData['pais'],
            $userData['idRol'], $userData['idGenero'], $userData['ciudad']);
        $stmt->execute();
        $stmt->close();
    }

    public function getLastInsertId() {
        return mysqli_insert_id($this->connection);
    }

}