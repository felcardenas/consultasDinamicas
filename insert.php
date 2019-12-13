<?php

include 'conexion.php';

mysqli_select_db($conexion,BBDD);
mysqli_set_charset($conexion,"utf-8");


if(isset($_POST)){

    $cantidadVariables = count($_POST);// CUENTA LA CANTIDAD DE VARIABLES PASADAS POR POST
    $nombreVariables = array_keys($_POST);// ARRAY QUE OBTIENE NOMBRE DE LAS VARIABLES
    $valorVariables = array_values($_POST);// ARRAY OBTIENE EL VALOR DE LAS VARIABLES
    //$tabla = $valorVariables[$cantidadVariables-1]; //OBTIENE EL NOMBRE DE LA TABLA
    $tabla = mysqli_real_escape_string($conexion,$_POST['tabla']);
    
    //INICIALIZA VARIABLES
    $cadenaColumnas = "";
    $cantidadColumnas= "";
    $cadenaVariables = "'";
    
    //CICLO PARA CONCATENAR... SE RECORRE LA CANTIDAD DE VARIABLES ENVIADAS
    for($i=0;$i<$cantidadVariables-1;$i++){
            
            //SE ESCAPAN LAS VARIABLES PARA EVITAR INYECCIÓN SQL
            $valorVariables[$i] = mysqli_real_escape_string($conexion,$valorVariables[$i]);

            if($i != ($cantidadVariables-2)){// "-2" CORRESPONDE A CANTIDAD QUE VARIABLES QUE NO SON CAMPOS EN LA TABLA, SI NO OTROS DATOS
                
                //CONCATENA LOS NOMBRES DE LAS COLUMNAS 
                $cadenaColumnas .= $nombreVariables[$i].",";
                //CONCATENA LAS VARIABLES
                $cadenaVariables .= $valorVariables[$i]."','";
                 
                
            }else{

                //CONCATENA LOS NOMBRES DE LAS COLUMNAS EN LA ÚLTIMA VUELTA
                $cadenaColumnas .= $nombreVariables[$i]."";
                //CONCATENA LAS VARIABLES EN LA ULTIMA VUELTA 
                $cadenaVariables .= $valorVariables[$i]."'";
               
                
            }

    }    

    $cadenaColumnas = mysqli_real_escape_string($conexion,$cadenaColumnas);
    //$cadenaVariables = mysqli_real_escape_string($conexion, $cadenaVariables);
    
    //SE CONCATENA TODA LA QUERY
    $sql = "INSERT INTO ". $tabla ." (".$cadenaColumnas.") VALUES (".$cadenaVariables.");";
    echo $sql;

    //SE EJECUTA LA QUERY
    if(mysqli_query($conexion,$sql)){
        echo "Agregado";
    }else{
        echo "No agregado";
    }
    

}else{
    echo "Error";
}

//SE CIERRA LA QUERY
mysqli_close($conexion);

?>