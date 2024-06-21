<?php

class DataRepository
{
    private $User = "root";
    private $Pass = "";
    private $Name = "pr";
    public $dbLink = null; //the placeholder for the database object.

    public function __construct()
    {
        $this->dbConnect();
    }
    public function  GetAll($query){
        return  $this->dbLink->query($query);
    }
    private function dbConnect()
    {
        $this->dbLink = new mysqli("localhost", $this->User, $this->Pass, $this->Name);

///simplified
        return true;
    }

}
