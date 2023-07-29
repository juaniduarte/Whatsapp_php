<?php
// Establecer credenciales de autenticación

$token = 'TOKEN_API_WHASAPP_FACEBOOK';
$dat=url($token);
ObtenerImagen3($dat,$token);


function url($token)
{
	// Cambiar Token y Numero de Telefono
	
 
 $telefono = '5511964534288'; // NUMERO TELEFONO TUYO REGISTRADO
    //IDENTIFICADOR DE NÚMERO DE TELÉFONO ENTREGADO POR WHATSAPP facebook
 $telefonoID = '107285985665593';
 $url='https://graph.facebook.com/v16.0/'.$telefonoID.'/messages';
 
 $idmedia='494408999437846';
// Arreglo con los parámetros necesarios para la API de WhatsApp
$params = array(
      'messaging_produc' => 'whatsapp',
    'recipient_type' => 'individual',
    'to' => $telefono,
    'type' => 'image',
    'image' => Array
        (
            'id' => $idmedia
        )
);

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://graph.facebook.com/v16.0/'. $idmedia,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_BINARYTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Bearer '.$token,
    'Content-Type: application/json'
  ),
));
 
$response = curl_exec($curl);
curl_close($curl);
//echo $response."<hr>";
//Obtenemos informacion de la imagen enviada
$dati = json_decode($response);
// Inicializar cURL
file_put_contents("text_imagen.txt",json_encode($dati));
return $dati;
}



function ObtenerImagen3($dati,$token)
{
  require_once 'http_request/vendor/autoload.php'; 
$request = new HTTP_Request2();
$request->setUrl($dati->url);
$request->setMethod(HTTP_Request2::METHOD_GET);
$request->setConfig(array(
  'follow_redirects' => TRUE
));
$request->setHeader(array(
  'Authorization' => 'Bearer '.$token
));
try {
  $response = $request->send();
  $media_type=$dati->mime_type;
  $tipo=explode('/',$media_type);
  $extension = obtener_extension($media_type);
  
  
  if ($response->getStatus() == 200) {
    //echo $response->getBody();
    
    $save_as = 'download_file/archivo_'.$tipo[0].time().'.'.$extension;
    $fp = fopen($save_as,'x');
    fwrite($fp, $response->getBody());
    fclose($fp);
    
/*	$body = (string)$response->getBody();
	$base64 = base64_encode($body);
	echo $base64;*/
  }
  else {
    echo 'Unexpected HTTP status: ' . $response->getStatus() . ' ' .
    $response->getReasonPhrase();
  }
}
catch(HTTP_Request2_Exception $e) {
  echo 'Error: ' . $e->getMessage();
}
    


}



function obtener_extension($mime_type) {
  // Array de tipos MIME y extensiones correspondientes
  $mime_extension_map = array(
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp',
    'application/pdf' => 'pdf',
	'application/msword' => 'doc',
    'application/vnd.ms-powerpoint' => 'ppt',
    'application/vnd.ms-excel' => 'xls',
	'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'docx',
	'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'pptx',
	'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'xlsx',
	'video/mp4' => 'mp4',
	'video/3gp' => '3gp',
	'text/plain' => 'txt',
	'audio/aac'=>'acc',
	'audio/mp4'=>'mp4',
	'audio/mpeg'=>'mpeg',
	'audio/amr'=>'amr',
	'audio/ogg'=>'ogg',

    // agregar más tipos MIME y extensiones aquí...
  );

  // Buscar la extensión correspondiente para el tipo MIME
  if (isset($mime_extension_map[$mime_type])) {
    return $mime_extension_map[$mime_type];
  } else {
    return false;
  }
}





//WebChatBot
//WebChatBot_2023


?>