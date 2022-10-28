<?php
include_once '..//auth-file/config/cors.php';
include_once '..//auth-file/config/Database.php';
include_once '../vendor/autoload.php';
use \Firebase\JWT\JWT;


$obj = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input", true));
    $email = htmlentities($data->email);
    $password = htmlentities($data->password);

    $obj->select('users', '*', null, "email='{$email}'", null, null);
    $datas = $obj->getResult();
    foreach ($datas as $data) {
        $id = $data['id'];
        $email = $data['email'];
        $name = $data['name'];
        
        if(!password_verify($password,$data['password']))
        {
            echo json_encode([
                'status'=>0,
                'message'=>'Invalid Credentials',
        
            ]);
        }else{
            $payload=[
                'iss'=>'localhost',
                'aud'=>'localhost',
                'exp'=>time()+10000,
                'data'=>[
                    'id'=>$id,
                    'name'=>$name,
                    'email'=>$email,
                    
                ],
    
            ];
            $secret_key="Nirmal Avhad";
            $jwt=JWT::encode($payload,$secret_key,'HS256');
            echo json_encode([
                'status'=>1,
                'jwt'=>$jwt,
                'message'=>'Login Successful',
        
            ]);
        }
        
        
    }
    
}else{
    echo json_encode([
        'status'=>0,
        'message'=>'Access Denied',

    ]);
}