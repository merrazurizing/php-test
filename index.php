<?php
    require("conexion.php");
?>


<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="Validaciones.js"></script>
    <title>Desis</title>
</head>
<body>
    <div class="container">
        <div class="body_form row mt-5 justify-content-center mx-auto" style="width: 65%;">
            <h5>FORMULARIO DE VOTACION</h5>
            <form class="py-4" id="formulario_votacion">
                <div class="row g-2 pr-2 pl-2 pt-2">
                    <label class="col-md" >Nombre y Apellido</label>
                    <input class="col-md" type="text" id="nombre" name="nombre" required placeholder="">
                </div>
                <div class="row g-2 pr-2 pl-2 pt-2">
                    <label class="col-md" >Alias</label>
                    <input class="col-md" type="text" id="alias" name="alias" required oninput="checkAlias(this)" placeholder="">
                </div>
                <div class="row g-2 pr-2 pl-2 pt-2">
                    <label class="col-md" >Email</label>
                    <input class="col-md" type="text" id="email" name="email" required oninput="checkEmail(this)" placeholder="">
                </div>
                <div class="row g-2 pr-2 pl-2 pt-2">
                    <label class="col-md">Rut</label>
                    <input class="col-md" type="text" id="rut" name="rut" required oninput="checkRut(this)" placeholder="">
                </div>
                <div class="row g-2 pr-2 pl-2 pt-2">
                    <label class="col-md">Region</label>
                    <select class="col-md" name="region" id="region">
                    <option value="">Seleccionar region</option>
                    <?php
                        $consulta="SELECT * FROM region ORDER BY region_id ;";
                        $resultado=pg_query($conexion,$consulta);
                        while($row=pg_fetch_assoc($resultado)){
                            echo "<option value=".$row["region_id"].">".$row["region_nombre"]."</option>";             
                        } 
                    ?>
                    </select>
                </div>

                <div class="row g-2 pr-2 pl-2 pt-2">
                    <label class="col-md">Comuna</label>
                    <select class="col-md" id="comuna">
                        <option value="">Seleccione region Primero</option>
                    </select>
                </div>

                <div class="row g-2 pr-2 pl-2 pt-2">
                    <label class="col-md">Candidato</label>
                    <select class="col-md" id="candidato">
                        <option value="">Seleccione comuna Primero</option>
                    </select>
                </div>
               
                <div class="row g-2 pr-2 pl-2 pt-2">
                    <label class="col-md">Como se entero de nosotros</label>
                    <div class="col-md" id="checkbox_group">
                        <label class="checkbox"><input type="checkbox" id="web" class="checkbox" value="web"> Web</label>
                        <label class="checkbox"><input type="checkbox" id="tv" class="checkbox" value="tv"> TV</label>
                        <label class="checkbox"><input type="checkbox" id="rss" class="checkbox" value="rss"> Redes Sociales</label>
                        <label class="checkbox"><input type="checkbox" id="amigos" class="checkbox" value="amigos"> Amigos</label>
                    </div>
                </div> 
                <div class="row g-2 pr-2 pl-4 pt-2">
                    <button type="submit" id="enviar">Enviar</button>
                </div>
            </form>  
        </div>
    </div>

</body>
</html>


<script>
$(document).ready(function(){
    $('#region').on('change', function(){
        var region_id = $(this).val();
        if(region_id){
            $.ajax({
                type:'POST',
                url:'get_comunas.php',
                data:'region='+region_id,
                success:function(html){
                    $('#comuna').html(html);
                    $('#candidato').html('<option value="">Seleccione comuna</option>'); 
                }
            }); 
        }else{
            $('#comuna').html('<option value="">Seleccione region Primero</option>');
            $('#candidato').html('<option value="">Seleccione comuna Primero</option>'); 
        }
    });
    
    $('#comuna').on('change', function(){
        var comuna_id = $(this).val();
        if(comuna_id){
            $.ajax({
                type:'POST',
                url:'get_candidatos.php',
                data:'comuna='+comuna_id,
                success:function(html){
                    $('#candidato').html(html);
                }
            }); 
        }else{
            $('#candidato').html('<option value="">Seleccione comuna Primero</option>'); 
        }
    });
    
});
</script>

<script type="text/javascript">
  $(document).ready(function(){

    $('#enviar').click(function(){
      var datos=$('#formulario_votacion').serialize();

      var nombre = document.getElementById("nombre").value;
      var alias = document.getElementById("alias").value;
      var email = document.getElementById("email").value;
      var rut = document.getElementById("rut").value;
      var region = document.getElementById("region").value;
      var comuna = document.getElementById("comuna").value;
      var candidato = document.getElementById("candidato").value;

      var insert = [];
    $('.checkbox').each(function() {
        if ($(this).is(":checked")) {
            insert.push($(this).val());
        }
    });
    insert = insert.toString();

      datos={ 'nombre': nombre , "alias":alias ,"email":email ,"rut":rut ,"region":region ,"comuna":comuna ,"candidato":candidato ,"recomendaciones": insert};
      $.ajax({
        type:"POST",
        url:"guardar_formulario.php",
        data:datos,
        success:function(data){
            alert(data);
            location.reload();
        }
      });

      return false;
    });
  });
</script>
