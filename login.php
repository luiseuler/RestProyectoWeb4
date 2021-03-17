<?php
require_once "conexion.php";
require_once "jwt.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET['user']) && isset($_GET['pass'])){
        $c = conexion();
        $s = $c->prepare("SELECT * FROM usuarios WHERE user=:u AND pass=:p");
        $s->bindValue(":u", $_GET['user']);
        $s->bindValue(":p", $_GET['pass']);
        $s->execute();
        $s->setFetchMode(PDO::FETCH_ASSOC);
        $r = $s->fetch();
        if($r){
            $jwt = JWT::create(array("user"=>$_GET['user']),"qwertyuiop");
            $r = array("login"=>"s", "token"=>$jwt);
        }else{
            $r = array("login"=>"n", "token"=>"Error de usuario");
        }
        header("HTTP/1.1 200 OK");
        echo json_encode($r);
    }else{
        header("HTT/1.1 400 Bad Request");
    }
}else{
    header("HTT/1.1 400 Bad Request");
}


