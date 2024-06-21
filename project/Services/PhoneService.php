<?php

class PhoneService
{

    public function __construct()
    {
        require_once 'DataRepository.php';

    }
    public  function GetPhonesByUserId($userId){
        $_data = new DataRepository();
        $phones =[];
        $result_phones =$_data->GetAll("select * from phones where id_user=".$userId);
        while ($data=$result_phones->fetch_assoc()){
            $phone= new Phone();
         $phone->id =$data['id'];
         $phone->Name =$data['name'];
         $phone->id_user =$data['id_user'];
         $phones[] =$phone;

        }
        return $phones;
    }
}