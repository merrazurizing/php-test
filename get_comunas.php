<?php 

require("conexion.php");
$region=$_POST['region'];


	$consulta="SELECT comuna_id,comuna_nombre
    FROM comuna
    INNER JOIN provincia ON provincia.provincia_id = comuna.fk_provincia_id
    INNER JOIN region ON region.region_id = provincia.fk_region_id
    where region.region_id = '$region'
    ORDER BY comuna.comuna_nombre ASC 
    ;";

	$result=pg_query($conexion,$consulta);



    
	while ($ver=pg_fetch_assoc($result)) {
		echo "<option value=".$ver['comuna_id'].">".$ver['comuna_nombre']."</option>";  
	}


?>