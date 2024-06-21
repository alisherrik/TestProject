<?php

class UserController{
    private $userService;

    public function __construct() {
        require_once 'Models/User.php';
        require_once 'Models/Phone.php';
        require_once 'Services/UserService.php';
        require_once 'Services/PhoneService.php';
       $this->userService = new UserService();
    }
    public function processRequest($method, $id = null) {
        switch ($method) {
            case 'GET':
                if ($id)
                {
                    try {
                        $user =$this->userService->GetById($id);
                        $this->sendResponse($user,200);
                    }catch ( Exception $exception){
                        $this->sendResponse($exception,400);
                    }
                }else
                {
                    try {
                        $users = $this->userService->GetAll();
                        $this->sendResponse($users, 200);
                    } catch (Exception $exception) {
                        $this->sendResponse($exception, 400);
                    }
                }
                break;
            case 'PUT':
                $input = json_decode(file_get_contents('php://input'), true);

                        $user = new User();
                        $user->id =$input["id"];
                        $user->Name =$input["name"];
                        $user->Age = $input["age"];
                      $result =  $this->userService->Edit($user);
                    $this->sendResponse($result,200);
                break;
            case 'POST':
                $input = json_decode(file_get_contents('php://input'), true);
                $user = new User();
                $user->Name =$input["name"];
                $user->Age = $input["age"];
                $result =  $this->userService->Add($user);
                $this->sendResponse($result,200);
            case 'DELETE':
                if ($id){
                    $result =$this->userService->Remove($id);
                    $this->sendResponse($result,200);
                }
                else{
                    $this->sendResponse("invalid Id",400);
                }

        }
    }

    private function sendResponse($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
    }
}