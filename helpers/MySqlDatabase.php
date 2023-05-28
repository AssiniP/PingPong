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

    public function query($sql) {
        $result = mysqli_query($this->connection, $sql);
        return mysqli_fetch_all($result, MYSQLI_BOTH);
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
}