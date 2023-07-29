<?php

include("fn_conect.php");

class Crud{
	
    public function __construct(){}
    public function __destruct(){}	

    

        
    public function GetLastWAConversacionByIdSesion($idSesion){

        $link=Conectar();
        $sql="SELECT * from WAConversacion where idSesion=$idSesion order by fechaCreacion desc LIMIT 1";
        $q=mysqli_query($link,$sql);
        $r=mysqli_fetch_assoc($q);
        mysqli_close($link);
        return $r;
    }
    
    public function InsertWAConversacion($arr){

        
        try 
        {

            //file_put_contents("error.txt",implode($arr),FILE_APPEND);
 
            $link=Conectar();    
            
            
            $sql="INSERT INTO WAConversacion (idSesion, estadoConversacion ,idEstadoActual, fechaCreacion, mensaje) 
            VALUES ('".$arr['idSesion']."','".$arr['estadoConversacion']."','".$arr['idEstadoActual']."',NOW(),'".$arr['mensaje']."')";
            $prepare = mysqli_prepare($link, $sql);
            
            //$sql="INSERT INTO WAConversacion (idSesion, idEstadoActual, fechaCreacion)  values (200,200,NOW())";
            //$prepare = mysqli_prepare($link, $sql);
            
            //mysqli_stmt_bind_param($prepare, 'iis', $n, $d, NOW());
    
            //$n=$arr['idSesion'];
            //$d=$arr['idEstadoActual'];
            
    
            $q=mysqli_stmt_execute($prepare);
            $lastId=mysqli_stmt_insert_id($prepare);
            mysqli_close($link);
    
    
            if($q){return $lastId;}else{return 0;}
            
            return 0;
        
        } catch (Exception $e) {
            file_put_contents("error.txt",$e,FILE_APPEND);
            return 0;
        }   

    }
    
    
     public function UpdateWAConversacion($arr){
         

        //file_put_contents("mensajes.txt","pase a UpdateWAConversacion",FILE_APPEND);         
                

        $link=Conectar();
        $sql="UPDATE WAConversacion SET idEstadoActual=? WHERE id=?";
        $prepare = mysqli_prepare($link, $sql);
        mysqli_stmt_bind_param($prepare, 'ii', $ea, $id);

        $ea=$arr['idEstadoActual'];
        $id=$arr['id'];
        
        
        //file_put_contents("mensajes.txt","\nEstado Actual: ".$ea,FILE_APPEND);
        //file_put_contents("mensajes.txt","\Id Conversacion: ".$id,FILE_APPEND); 
        //file_put_contents("mensajes.txt",$id,FILE_APPEND); 

        $q=mysqli_stmt_execute($prepare);

        mysqli_close($link);
        if($q){return 1;}else{return 0;}

    }	

}


?>