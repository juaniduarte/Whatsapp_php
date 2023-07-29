<?php



function enviarBienvenida($telefonoCliente) {

        
    //TOKEN QUE NOS DA FACEBOOK
    $token = 'EAAInAgERrvoBAHTJZBOT3VeTaCYqZAr72sZBl9dOJ5ZBHDTMu4wQizXmttDikGUB9o9gfUSO3UnmilhvDByjdL2WZAFbZCiJinJCYnMWUjgZBaAZB8LnlZCDE8O9cyfN8xIP534R7ctHY8qqyIuuiRpoUMENy7rpENJM5tpLSyXqmLvijZCyAZAJRQPxMKH5ONva2birTepQQaIVwZDZD';
    //NUESTRO TELEFONO
    $telefono = '5511964534288';
    //IDENTIFICADOR DE NÚMERO DE TELÉFONO
    $telefonoID = '107285985665593';
    //URL A DONDE SE MANDARA EL MENSAJE
    $url = 'https://graph.facebook.com/v16.0/' . $telefonoID . '/messages';
    //CONFIGURACION DEL MENSAJE
    $mensaje = ''
        . '{'
        . '"messaging_product": "whatsapp", '
        . '"recipient_type": "individual",'
        . '"to": "' . $telefonoCliente . '", '
        . '"type": "interactive", '
        . '"interactive": {
			"type": "list",
			"header": 	{
						"type": "text",
						"text": "Menú de Opciones"
						},
			"body": {
						"text": "Lista de Opciones"
					},
			"action":	{
							"button": "Seleccionar",
							"sections": 
									[
											{
											"title": "Opciones GLPI",
											"rows": [
														{
															"id": "1",
															"title": "Creación Ticket",
															"description": "Description 1.1"
														},
														{
															"id": "2",
															"title": "Estado Ticket",
															"description": "Description 1.2"
														}
													]
										},
										{
											"title": "Ayuda / Soporte",
											"rows": [
															{
															"id": "3",
															"title": "Title 2.1",
															"description": "Description 2.1"
															},
														{
														"id": "4",
														"title": "Title 2.2",
														"description": "Description 2.2"
														}
													]
										}
									]
						}

			} '
        . '}';
                

        

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


function enviarOpcionSeleccionada($message,$telefonoCliente) {

        
    //TOKEN QUE NOS DA FACEBOOK
    $token = 'EAAECg1cEk4EBABCGUyUOq2rtCufpLRgeRZBYNco806cgXYqiS4ua1BDLtcTV2rQoTjCwW14zDZBxv07ZBhlupxJeBqp0ZAgZBnhdWXtgkXLZCH8tia8ytVBeprd4LDS6KhrP8M4DiXN23twhzSCWF2Y04yaASAlk6wnR0X0aW7C31Y3uoYg6ZB43vEakWPnIfUIngIGKYYZA9gZDZD';
    //NUESTRO TELEFONO
    $telefono = '56976685657';
    //IDENTIFICADOR DE NÚMERO DE TELÉFONO
    $telefonoID = '117922591260332';
    //URL A DONDE SE MANDARA EL MENSAJE
    $url = 'https://graph.facebook.com/v16.0/' . $telefonoID . '/messages';
    //CONFIGURACION DEL MENSAJE
   $mensaje = ''
            . '{'
            . '"messaging_product": "whatsapp", '
            . '"recipient_type": "individual",'
            . '"to": "' . $telefono . '", '
            . '"type": "text", '
            . '"text": '
            . '{'
            . '     "body":"Usted selecciono la opción: ' .  $message . '",'
            . '     "preview_url": true, '
            . '} '
            . '}';
                

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


function enviarIngreseAsunto($telefonoCliente) {

        
    //TOKEN QUE NOS DA FACEBOOK
    $token = 'EAAECg1cEk4EBABCGUyUOq2rtCufpLRgeRZBYNco806cgXYqiS4ua1BDLtcTV2rQoTjCwW14zDZBxv07ZBhlupxJeBqp0ZAgZBnhdWXtgkXLZCH8tia8ytVBeprd4LDS6KhrP8M4DiXN23twhzSCWF2Y04yaASAlk6wnR0X0aW7C31Y3uoYg6ZB43vEakWPnIfUIngIGKYYZA9gZDZD';
    //NUESTRO TELEFONO
    $telefono = '56976685657';
    //IDENTIFICADOR DE NÚMERO DE TELÉFONO
    $telefonoID = '117922591260332';
    //URL A DONDE SE MANDARA EL MENSAJE
    $url = 'https://graph.facebook.com/v16.0/' . $telefonoID . '/messages';
    //CONFIGURACION DEL MENSAJE
   $mensaje = ''
            . '{'
            . '"messaging_product": "whatsapp", '
            . '"recipient_type": "individual",'
            . '"to": "' . $telefono . '", '
            . '"type": "text", '
            . '"text": '
            . '{'
            . '     "body":"Ingrese Asunto:",'
            . '     "preview_url": true, '
            . '} '
            . '}';
                

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

/*
 * RECIBIMOS LA RESPUESTA
*/
function enviar($recibido, $enviado, $idWA,$timestamp,$telefonoCliente) {
    

    
 //   require_once './conexion.php';
    //CONSULTAMOS TODOS LOS REGISTROS CON EL ID DEL MANSAJE
 /*   $sqlCantidad = "SELECT count(id) AS cantidad FROM registro WHERE id_wa='" . $idWA . "';";
    $resultCantidad = $conn->query($sqlCantidad);
    //OBTENEMOS LA CANTIDAD DE MENSAJES ENCONTRADOS (SI ES 0 LO REGISTRAMOS SI NO NO)
    $cantidad = 0;
    //SI LA CONSULTA ARROJA RESULTADOS
    if ($resultCantidad) {
        //OBTENEMOS EL PRIMER REGISTRO
        $rowCantidad = $resultCantidad->fetch_row();
        //OBTENEMOS LA CANTIDAD DE REGISTROS
        $cantidad = $rowCantidad[0];
    }
	*/
    //SI LA CANTIDAD DE REGISTROS ES 0 ENVIAMOS EL MENSAJE DE LO CONTRARIO NO LO ENVIAMOS PORQUE YA SE ENVIO
    if ($cantidad == 0) {
        //TOKEN QUE NOS DA FACEBOOK
        $token = 'EAAECg1cEk4EBAEkVv7eGdE3wXx2PWDi59E6Bod1ZBMUZAWZAZBJhRNvCvbAjsYid0w00uLex1yarc4LPYkYEnqge7o3U0Ax2BbqXiUo5h9EN8eoJHKbbembokf3uMZAYAa1EWzjZCX0qgHTZAtOhqjHhPts7uGnJqDFCANK4fQ6XI4RwOyyhLoMAAd4w6IZCcHPRAqSEORk4NQZDZD';
        //NUESTRO TELEFONO
        $telefono = '56976685657';
        //IDENTIFICADOR DE NÚMERO DE TELÉFONO
        $telefonoID = '117922591260332';
        //URL A DONDE SE MANDARA EL MENSAJE
        $url = 'https://graph.facebook.com/v16.0/' . $telefonoID . '/messages';
        //CONFIGURACION DEL MENSAJE
       $mensaje = ''
                . '{'
                . '"messaging_product": "whatsapp", '
                . '"recipient_type": "individual",'
                . '"to": "' . $telefono . '", '
                . '"type": "interactive", '
                . '"interactive": {
					"type": "list",
					"header": 	{
								"type": "text",
								"text": "Menú de Opciones"
								},
					"body": {
								"text": "Lista de Opciones"
							},
					"action":	{
									"button": "Seleccionar",
									"sections": 
											[
													{
													"title": "Opciones GLPI",
													"rows": [
																{
																	"id": "1",
																	"title": "Creación Ticket",
																	"description": "Description 1.1"
																},
																{
																	"id": "2",
																	"title": "Estado Ticket",
																	"description": "Description 1.2"
																}
															]
												},
												{
													"title": "Ayuda / Soporte",
													"rows": [
																	{
																	"id": "3",
																	"title": "Title 2.1",
																	"description": "Description 2.1"
																	},
																{
																"id": "4",
																"title": "Title 2.2",
																"description": "Description 2.2"
																}
															]
												}
											]
								}

					} '
                . '}';
                


        

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

/*
        //INSERTAMOS LOS REGISTROS DEL ENVIO DEL WHATSAPP
        $sql = "INSERT INTO registro "
            . "(mensaje_recibido    ,mensaje_enviado   ,id_wa        ,timestamp_wa        ,     telefono_wa) VALUES "
            . "('" . $recibido . "' ,'" . $enviado . "','" . $idWA . "','" . $timestamp . "','" . $telefonoCliente . "');";
        $conn->query($sql);
        $conn->close();*/
    }
}

?>