<?php

// Para comprobar que existe el coreo se podría usar: http://www.php.net/manual/es/function.checkdnsrr.php


$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars(str_replace(" ","",$_POST['email']));
$mensaje = htmlspecialchars($_POST['mensaje']);

function comprobar_email($email){
        //compruebo unas cosas primeras
        if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
           if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
              //miro si tiene caracter .
              if (substr_count($email,".")>= 1){
                 //obtengo la terminacion del dominio
                 $term_dom = substr(strrchr ($email, '.'),1);
                 //compruebo que la terminación del dominio sea correcta
                 if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                    //compruebo que lo de antes del dominio sea correcto
                    $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                    $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                    if ($caracter_ult != "@" && $caracter_ult != "."){
                       return true;
                    }
                    else {
                        return false;
                    }
                 }
              }
           }
        }
}


if (empty($name) || empty($mensaje)) {
    echo "Rellene todos los campos del formulario, Volver al <a href=\"form.html\">FORM</a>";
}
else
{
    if (strlen ($name) > '100') {
    echo "El Nombre no debe superar los 100 caracteres";
    }
    else
    {
        if (strlen ($mensaje) > '600') {
         echo "Mensaje muy grande";
         }
         else
         {
            if (comprobar_email($email)) {

                $remitente = "contacto@tuhost.com"; /* Correo a donde se enviara el mensaje */
                $destinatario = "web@tuhost.com"; /* Correo que envia el mensaje, es util para que no envie siempre el mensaje a correo no deseado */

                $headers = "MIME-Version: 1.0 \r\n";
                $headers .= "From: $destinatario \r\n";
                $headers .= "Reply-To: $remitente \r\n";
                $headers .= "Return-path: $remitente \r\n";
                $headers .= "Content-type: text/html; charset=iso-8859-1 \r\n";

                $body = "
                <table><tr><td width=\"150\" valign=\"top\"><strong>Nombre:</strong></td><td> ".$name."</td></tr>"."
                <tr><td valign=\"top\"><strong>Email:</strong></td><td> ".$email."</td></tr>"."
                <tr><td valign=\"top\"><strong>Mensaje:</strong></td><td>".$mensaje."</td></tr></table>";

                mail($remitente,"Probando",$body, $headers);
                echo "Mensaje enviado con Exito";
            } else
            {
                echo "Esta mal escrito el mail, porfavor volver a <a href=\"form.html\" >FORM</a>";
            }
        }
    }
}


?>
