<?php
require("conexion.php");

$nombre = $_POST["nombre"];
$alias = $_POST["alias"];
$email = $_POST["email"];
$rut = $_POST["rut"];
$region = $_POST["region"];
$comuna = $_POST["comuna"];
$candidato = $_POST["candidato"];
$recomendaciones = $_POST["recomendaciones"];

$consulta1 = "INSERT INTO public.formulario(
	formulario_votante, formulario_candidato, recomendaciones)
	VALUES ('$nombre', '$candidato', '$recomendaciones');
	INSERT INTO public.votante(
	nombre, alias, email, rut, region, comuna, fk_candidato_id)
	VALUES ( '$nombre', '$alias', '$email', '$rut', '$region', '$comuna','$candidato');
	";
$result = pg_query($conexion,$consulta1);
 ?>