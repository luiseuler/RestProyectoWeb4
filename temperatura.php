<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Authorization, Access-Control-Allow-Methods, Access-Control-Allow-Headers, Allow, Access-Control-Allow-Origin");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, HEAD");
header("Allow: GET, POST, PUT, DELETE, OPTIONS, HEAD");
require_once "conexion.php";
require_once "jwt.php";
if($_SERVER["REQUEST_METHOD"]=="OPTIONS"){
    exit();
}
$header = apache_request_headers();
$jwt = $header['Authorization'];
if(JWT::verify($jwt,"qwertyuiop")!=0){
    header("HTT/1.1 401 Unauthorized");
    exit();
}
$data = JWT::get_data($jwt,"qwertyuiop");

$metodo = $_SERVER["REQUEST_METHOD"];

switch($metodo){
    case "GET":
        if(isset($_GET['id'])){
            $c = conexion();
            $s = $c->prepare("SELECT * FROM temperatura WHERE id=:id");
            $s->bindValue(":id", $_GET['id']);
            $s->execute();
            $s->setFetchMode(PDO::FETCH_ASSOC);
            $r = $s->fetch();
        }else{
            $c = conexion();
            $s = $c->prepare("SELECT * FROM temperatura");
            $s->execute();
            $s->setFetchMode(PDO::FETCH_ASSOC);
            $r = $s->fetchAll();
        }
        echo json_encode($r);
        break;
    case "POST":
        
       
        break;
    case "PUT":
        break;
    case "DELETE":
        break;
    default:
        header("HTT/1.1 400 Bad Request");
}
