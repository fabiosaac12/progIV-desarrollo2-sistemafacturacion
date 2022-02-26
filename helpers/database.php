<?php
  class Database {
    public $connection;

    public function __construct() {
      $servername = "localhost";
      $username = "root";
      $password = "";
      $dbname = "sistema_facturacion";

      $this->connection = new PDO("mysql:host=$servername; dbname=$dbname", $username, $password);

      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->connection->exec("SET CHARACTER SET UTF8");
    }

    public function delete($query) {
      $result = $this->connection->prepare($query);

      $result->execute();

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      return true;
    }

    public function update($query) {
      $result = $this->connection->prepare($query);

      $result->execute();

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      return true;
    }

    public function insert($query) {
      $result = $this->connection->prepare($query);

      $result->execute();

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      return true;
    }

    public function selectOne($query) {
      $result = $this->connection->prepare($query);

      $result->execute();

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      $row = $result->fetch(PDO::FETCH_ASSOC);

      if (!$row) {
        throw new Exception();
      }

      return $row;
    }

    public function select($query) {
      $result = $this->connection->prepare($query);

      $result->execute();

      if (!$result) {
        throw new Exception($this->connection->error);
      }

      $resultArray = [];

      while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $resultArray[] = $row;
      }

      return $resultArray;
    }
  }
?>