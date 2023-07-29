<?php


include("configuracion/crud.php");
require_once "enviar.php";

/*	
 * VERIFICACION DEL WEBHOOK
*/
$mensaje='';
//TOQUEN QUE QUERRAMOS PONER 
$token = 'HolaNovato';
//RETO QUE RECIBIREMOS DE FACEBOOK
$palabraReto = $_GET['hub_challenge'];
//TOQUEN DE VERIFICACION QUE RECIBIREMOS DE FACEBOOK
$tokenVerificacion = $_GET['hub_verify_token'];
//SI EL TOKEN QUE GENERAMOS ES EL MISMO QUE NOS ENVIA FACEBOOK RETORNAMOS EL RETO PARA VALIDAR QUE SOMOS NOSOTROS
if ($token === $tokenVerificacion) {
    echo $palabraReto;
    exit;
}

/*
 * RECEPCION DE MENSAJES
 */
//LEEMOS LOS DATOS ENVIADOS POR WHATSAPP
$respuesta = file_get_contents("php://input");
//CONVERTIMOS EL JSON EN ARRAY DE PHP
$respuesta = json_decode($respuesta, true);
//EXTRAEMOS EL TELEFONO DEL ARRAY
$telefonoCliente=isset($respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from']) ? $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['from']:'';
//EXTRAEMOS EL ID DE WHATSAPP DEL ARRAY
$id=isset($respuesta['entry'][0]['changes'][0]['value']['messages'][0]['id']) ? $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['id']:'';
//EXTRAEMOS EL TIEMPO DE WHATSAPP DEL ARRAY
$timestamp=isset($respuesta['entry'][0]['changes'][0]['value']['messages'][0]['timestamp']) ? $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['timestamp']:"";

//TIPO DE MENSAJE
$tipo=$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['type'];
$mensaje='';
//TEXTO INGRESADO DIRECTAMENTE POR EL USUARIO
if($tipo == 'text')
{
	//EXTRAEMOS EL MENSAJE DEL ARRAY
	$mensaje=isset($respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body']) ? $respuesta['entry'][0]['changes'][0]['value']['messages'][0]['text']['body']: ''; 
}

//OPCION SELECCIONADA DESDE UN INTEREACTIVE
if($tipo == 'interactive')
{
    //EXTRAEMOS EL MENSAJE DEL ARRAY
    $mensaje=$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['interactive']['list_reply']['id'];    
}

if($tipo == 'image')
{
	$id_media=$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['image']['id'];    
	
	    $token2 = 'EAAInAgERrvoBAHTJZBOT3VeTaCYqZAr72sZBl9dOJ5ZBHDTMu4wQizXmttDikGUB9o9gfUSO3UnmilhvDByjdL2WZAFbZCiJinJCYnMWUjgZBaAZB8LnlZCDE8O9cyfN8xIP534R7ctHY8qqyIuuiRpoUMENy7rpENJM5tpLSyXqmLvijZCyAZAJRQPxMKH5ONva2birTepQQaIVwZDZD';
    //NUESTRO TELEFONO
	
	    $url = 'https://graph.facebook.com/v16.0/' . $id_media;
download_image($url);
	
//	file_put_contents("debug_imagen.txt",$dati,FILE_APPEND);	
}




//SI HAY UN MENSAJE
//file_put_contents("text_usuario_eleccion.txt",json_encode($respuesta));



file_put_contents("debug.txt","\n",FILE_APPEND);
file_put_contents("debug.txt",json_encode($respuesta),FILE_APPEND);	


$idConversacion = 0;
$idEstadoActual = 0;




//SI EXISTE EL MENSAJE SIGNIFICA QUE ES ALGO QUE EL CLIENTE ENVIO
//CREAR LA CONVERSACION, SE DEBE VERRIFICAR QUE ANTES NO EXISTE UNA CONVERSACION "OPEN"
if($mensaje != '')
{
    
    
    
    $crud= new Crud();
    $conversacion=$crud->GetLastWAConversacionByIdSesion($telefonoCliente);
    
    if(is_null($conversacion) || $conversacion['estadoConversacion'] == 'CLOSED')
	{
	    
	    try 
        {
            $array = ["idSesion" => $telefonoCliente, "estadoConversacion" => "OPEN", "idEstadoActual" => $idEstadoActual,"mensaje" => json_encode($respuesta)];
            $resp=$crud->InsertWAConversacion($array);
            
            $idConversacion = $resp;
        
        } catch (Exception $e) {
            file_put_contents("error.txt",$e,FILE_APPEND);
            return 0;
        }   
	}
	else
	{
	    
	    $idConversacion = $conversacion['id'];
	    $idEstadoActual = $conversacion['idEstadoActual'];
	}
	
	//file_put_contents("debug.txt",'antes de enviarBienvenida' . $idEstadoActual,FILE_APPEND);
	
	//ESTADO INICIAL. DEBE MOSTRAR EL MENU INICIAL, AVAZAMOS AL ESTADO 1
    if($idEstadoActual == 0)
    {
    
        enviarBienvenida($telefonoCliente);
       
        try 
        {
            $array = ["id" => $idConversacion, "idEstadoActual" => 1];
            $resp=$crud->UpdateWAConversacion($array);
        
        } catch (Exception $e) {
            file_put_contents("error.txt",$e,FILE_APPEND);
            return 0;
        }   
        
    }
    
    
    //ESPERANDO SELECCION DEL USUARIO. DEBE MOSTRAR EL MENU INICIAL, AVAZAMOS AL ESTADO 2
    if($idEstadoActual == 1)
    {

        enviarOpcionSeleccionada($mensaje,$telefonoCliente);
       
        try 
        {
            //CREACION DEL TICKET
            if($mensaje == 1)
            {
                enviarIngreseAsunto($telefonoCliente);    
            }
            
            
            
            $array = ["id" => $idConversacion, "idEstadoActual" => 2];
            $resp=$crud->UpdateWAConversacion($array);
            
        
            
        
        } catch (Exception $e) {
            file_put_contents("error.txt",$e,FILE_APPEND);
            return 0;
        }   
        
    }

}


if($mensaje!=''){
	$texto = 'Fecha:'.date('d-m-Y H:i:s',$timestamp).' - Numero Recibido '.$telefonoCliente.' - Mensaje: .'.$mensaje;
    // file_put_contents("text.txt",$texto);
   // file_put_contents($id."_text.txt",json_encode($respuesta));
	
	
	//$respuesta="Bienvenido ".$telefonoCliente." a la prueba de mensaje";
	if(!is_numeric($mensaje))
	{
		$respuesta="Bienvenido ".$telefonoCliente." a la prueba de mensaje tienes los siguiente item de apoyo: \\n1- Crear Ticket \\n2-Consultar Estado Ticket \\n3- Ayuda";
	}
	if(strpos($mensaje, '3')!== FALSE)
	{
		$respuesta='Para mayor apoyo a tus dudas, comunicarse con los siguientes numeros: XXXXXXXXXXXX';
		
	} 



//file_put_contents("text.txt","\n",FILE_APPEND);
//file_put_contents("text.txt",$mensaje,FILE_APPEND);	
//file_put_contents("text.txt","\n",FILE_APPEND);
//file_put_contents("text.txt",$respuesta,FILE_APPEND);
	
	enviar($mensaje,$respuesta,$id,$timestamp,$telefonoCliente);
}
/*
if($tipo=='audio')
{
	
	$tipo=$respuesta['entry'][0]['changes'][0]['value']['messages'][0]['type'];
	$MEDIA_ID='';
		$curl = curl_init();

		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://graph.facebook.com/v16.0/",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "GET",
		CURLOPT_HTTPHEADER => array(
		"Authorization: Bearer EAAInAgERrvoBAEcO1uOKzpdo4iPzhRBBg7SA3fAiSOa5XivP2VZCkaZCz83cAZCKyKRtnZCRN6J6l6kvtpO9wtC224vo72Wt0ZAC54kQmdpqTPLZCn71maPTqYvNv6ZAQ1xztCro8dBnozam8xXneMLyrwNiGgtsqcs1Hv0KTlZAEZBSBZAsCQkOeD1VDm4oSZAEK2XSuLx3AEzOAZDZD"
		  ),
		 ));

		$response = curl_exec($curl);
		$data = json_decode($response, true);
}
*/

function download_image(){

 $token = 'EAAInAgERrvoBAHTJZBOT3VeTaCYqZAr72sZBl9dOJ5ZBHDTMu4wQizXmttDikGUB9o9gfUSO3UnmilhvDByjdL2WZAFbZCiJinJCYnMWUjgZBaAZB8LnlZCDE8O9cyfN8xIP534R7ctHY8qqyIuuiRpoUMENy7rpENJM5tpLSyXqmLvijZCyAZAJRQPxMKH5ONva2birTepQQaIVwZDZD';
 $telefono = '5511964534288';
    //IDENTIFICADOR DE NÚMERO DE TELÉFONO
 $telefonoID = '107285985665593';
 $url='https://graph.facebook.com/v16.0/'.$telefonoID.'/messages';
/*

curl -X  POST \
 'https://graph.facebook.com/v16.0/FROM-PHONE-NUMBER-ID/messages' \
 -H 'Authorization: Bearer ACCESS_TOKEN' \
 -H 'Content-Type: application/json' \
 -d '{
  "messaging_product": "whatsapp",
  "recipient_type": "individual",
  "to": "PHONE-NUMBER",
  "type": "image",
  "image": {
    "id" : "MEDIA-OBJECT-ID"
  }
}'


*/
    //DECLARAMOS LAS CABECERAS
    $header = array("Authorization: Bearer " . $token, "Content-Type: application/json",);
    //INICIAMOS EL CURL
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $mensaje);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    //OBTENEMOS LA RESPUESTA DEL ENVIO DE INFORMACION
    $response = json_decode(curl_exec($curl), true);
    //OBTENEMOS EL CODIGO DE LA RESPUESTA
    $status_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    //CERRAMOS EL CURL
    curl_close($curl);
 }
 
?>