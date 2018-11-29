<?php 

include('php/conexion.php');

  print_r($_POST);

    if (isset($_POST['nombres'])) {
        
    $idpregunta = $_POST['idPregunta'];
    $idopcion = $_POST['idOpcion'];
    $idgrupopregunta = $_POST['IdGrupoPregunta'];

  	$nombres = $_POST['nombres'];
    $nroboleta = $_POST['nroboleta'];
    $email = $_POST['email'];
    $sms = $_POST['sms'];
    $edad = $_POST['edad'];
    $tienda = $_POST['tienda'];

    $ahora = date("Y-m-d H:i:s");

    $subject = "CORREO";
    $message = "hola";
    $to = "cnahuina@gmail.com";

    $cabeceras = 'MIME-Version: 1.0' . "\r\n";
    $cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $cabeceras .= 'From: Mi Nombre<'.$email.'>';

    //if (mail($to, $subject, $message, $cabeceras)) {
    $smt = $pdo->prepare("INSERT INTO datos (nombres, email, nro,edad,nroBoleta,idtienda) VALUES (?,?,?,?,?,?)");

      $smt->execute([$nombres, $email, $sms,$edad, $nroboleta, $tienda ]);
 

    $smt = $pdo->prepare("SELECT id FROM datos ORDER BY id DESC LIMIT 1;");
    $smt->execute();
    $result = $smt->fetch(PDO::FETCH_OBJ);
    
    $idDatos = $result === false ? 1 : $result->id;

    $smt1 = $pdo->prepare("INSERT INTO respuesta (id,idGrupoPregunta,idPregunta) VALUES (?,?,?);");
    $result = $smt1->execute([$idDatos, $idgrupopregunta, $idpregunta]);


    $smt1 = $pdo->prepare("SELECT idrespuesta FROM respuesta ORDER BY idrespuesta DESC LIMIT 1;");
    $smt1->execute();

    $result = $smt1->fetch(PDO::FETCH_OBJ);
    $idRespuesta = $result === false ? 1 : $result->idrespuesta;
    

    $smt2 = $pdo->prepare("INSERT INTO detalle_respuesta (idrespuesta,idOpcion,fecha) VALUES (?,?,?)");
    $result = $smt2->execute([$idRespuesta, $idopcion,$ahora ]);



      
    }
    //header("location: index.php");