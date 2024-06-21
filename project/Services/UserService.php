<?php

class UserService
{
    private $_data;
    public function __construct()
    {
        require_once 'DataRepository.php';
        require_once 'PhoneService.php';

    }

    public function GetAll(){
        $_data = new DataRepository();
        $Users=[];
        $result = $_data->GetAll("SELECT * FROM users ");
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
               $user = new User();
               $user->id =$row["id"];
               $user->Name =$row["name"];
               $user->Age =$row["age"];
               $phones = new PhoneService();
               $user->Phones[]  =$phones->GetPhonesByUserId($row['id']);
               $Users[]=$user;
            }
        }
        return $Users;
    }
    public function GetById($id){
        $user =new User();
        $this->_data = new DataRepository();
        $result =$this->_data->GetAll("Select * from users where id=".$id);
        while ($row = $result->fetch_assoc()){
            $user->Name =$row['name'];
            $user->id =$row['id'];
            $user->Age =$row['age'];

            $phones = new PhoneService();
            $user->Phones[]  =$phones->GetPhonesByUserId($row['id']);

        }
        return $user;
    }
    public function Edit($user){
        $this->_data = new DataRepository();
        try {
            $sql ="Update users set name='".$user->Name."', age =".$user->Age." where id=".$user->id;
            $this->_data->GetAll($sql);

        } catch ( Exception $exception){

        }
        return $this->GetById($user->id);

    }
    public  function  Add($user){
        $this->_data = new DataRepository();
       $sql ="Insert into users Set name='".$user->Name."', age =".$user->Age;
       $this->_data->GetAll($sql);
       $sql ="select * from users order by users.`id` desc limit 1";
       $new_user = new User();
      $result =$this->_data->GetAll($sql);
      while ($item =$result->fetch_assoc()){
          $new_user->id =$item['id'];
          $new_user->Age =$item['age'];
          $new_user->Name =$item['name'];
      }
       return $new_user;
    }
    public function Remove($id){
        $this->_data = new DataRepository();
        $sql ="Delete from users where id =". $id;
        try{
            $this->_data->GetAll($sql);
            return "Deleted succesful";
        }catch (Exception $ex){
            return $ex->getMessage();
        }
    }
}