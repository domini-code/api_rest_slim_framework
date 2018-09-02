<?php
  class db{
    private $dbHost ='localhost';
    private $dbUser = 'myUser';
    private $dbPass = 'NrTX577Fo9IiZEl9';
    private $dbName = 'apiRest';
    //conección 
    public function conectDB(){
      $mysqlConnect = "mysql:host=$this->dbHost;dbname=$this->dbName";
      $dbConnecion = new PDO($mysqlConnect, $this->dbUser, $this->dbPass);
      $dbConnecion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $dbConnecion;
    }
  }
