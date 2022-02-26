<?php
  class Database {
    public $connection;

    public function __construct() {
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "sistema_facturacion";

      $this->connection = new mysqli($servername, $username, $password, $dbname);

      if ($this->connection->connect_error) {
        throw new Exception($this->connection->connect_error);
      }
    }

    public function delete($query) {
      $result = $this->connection->query($query);

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      return true;
    }

    public function update($query) {
      $result = $this->connection->query($query);

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      return true;
    }

    public function insert($query) {
      $result = $this->connection->query($query);

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      return true;
    }

    public function selectOne($query) {
      $result = $this->connection->query($query);

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      $row = $result->fetch_assoc();

      if (!$row) {
        throw new Exception();
      }

      return $row;
    }

    public function select($query) {
      $result = $this->connection->query($query);

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      $resultArray = [];

      while($row = $result->fetch_assoc()) {
        $resultArray[] = $row;
      }

      return $resultArray;
    }
  }
?>