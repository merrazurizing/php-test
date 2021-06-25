<?php 

require("conexion.php");
$comuna=$_POST['comuna'];


	$consulta="SELECT candidato_id,candidato_nombre FROM candidato
    where fk_comuna_id='$comuna'
    ORDER BY candidato_id ASC ;
    ;";

	$result=pg_query($conexion,$consulta);

    
	while ($ver=pg_fetch_assoc($result)) {
		echo "<option value=".$ver['candidato_id'].">".$ver['candidato_nombre']."</option>";  
	}

?>
