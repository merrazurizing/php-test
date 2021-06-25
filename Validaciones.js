
function checkRut(rut) {
    // Despejar Puntos
    var valor = rut.value.replace('.','');
    // Despejar Guión
    valor = valor.replace('-','');
    
    // Aislar Cuerpo y Dígito Verificador
    cuerpo = valor.slice(0,-1);
    dv = valor.slice(-1).toUpperCase();
    
    // Formatear RUN
    rut.value = cuerpo + '-'+ dv
    
    // Si no cumple con el mínimo ej. (n.nnn.nnn)
    if(cuerpo.length < 7) { rut.setCustomValidity("RUT Incompleto"); return false;}
    
    // Calcular Dígito Verificador
    suma = 0;
    multiplo = 2;
    
    // Para cada dígito del Cuerpo
    for(i=1;i<=cuerpo.length;i++) {
    
        // Obtener su Producto con el Múltiplo Correspondiente
        index = multiplo * valor.charAt(cuerpo.length - i);
        
        // Sumar al Contador General
        suma = suma + index;
        
        // Consolidar Múltiplo dentro del rango [2,7]
        if(multiplo < 7) { multiplo = multiplo + 1; } else { multiplo = 2; }
  
    }
    
    // Calcular Dígito Verificador en base al Módulo 11
    dvEsperado = 11 - (suma % 11);
    
    // Casos Especiales (0 y K)
    dv = (dv == 'K')?10:dv;
    dv = (dv == 0)?11:dv;
    
    // Validar que el Cuerpo coincide con su Dígito Verificador
    if(dvEsperado != dv) { rut.setCustomValidity("RUT Inválido"); return false; }
    
    // Si todo sale bien, eliminar errores (decretar que es válido)
    rut.setCustomValidity('');
}

function checkEmail(email) {
    // Patron en expresion regular (regex)
    var pattern = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

    // Ver si corresponde al patron
    if (email.value.match(pattern)) {
        email.setCustomValidity('');
    }
    // Si email esta Vacio
    else if (email.value == "") {
        email.setCustomValidity("Email Vacio")
    }
    // Si no corresponde al patron
    else {
        email.setCustomValidity("Porfavor Ingresar mail valido")
    } 
}

function checkAlias(alias){
    var alpha_numeric=/^[0-9a-zA-Z]+$/;
    if(alias.value.match(alpha_numeric)){
        if(alias.value.length > 5)
            alias.setCustomValidity('');
        else
            alias.setCustomValidity("Porfavor Ingresar Alias valido")
    }else{
        alias.setCustomValidity("Porfavor Ingresar Alias valido")
    }

}


$(document).ready(function () {
    $('#enviar').click(function() {
      checked = $("input[type=checkbox]:checked").length;

      if(checked < 2) {
        alert("Seleccione al menos 2 checkboxs");
        return false;
      }

    });
});


