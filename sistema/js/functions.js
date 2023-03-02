$(document).ready(function(){

    //--------------------- SELECCIONAR FOTO PRODUCTO ---------------------
    $("#foto").on("change",function(){
        var uploadFoto = document.getElementById("foto").value;
        var foto       = document.getElementById("foto").files;
        var nav = window.URL || window.webkitURL;
        var contactAlert = document.getElementById('form_alert');
        
        if(uploadFoto !='')
        {
            var type = foto[0].type;
            var name = foto[0].name;
            if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png')
            {
                contactAlert.innerHTML = '<p class="errorArchivo">El archivo no es válido.</p>';                        
                $(".preview img").remove();
                $(".delete").addClass('notBlock');
                $('#foto').val('');
                return false;
            }else{  
                contactAlert.innerHTML='';
                $(".preview img").remove();
                $(".delete").removeClass('notBlock');
                var objeto_url = nav.createObjectURL(this.files[0]);
                $(".preview").append("<img src="+objeto_url+">");                        
            }
        }else{
            alert("No selecciono foto");
            $(".preview img").remove();
        }              
    });

    $('.delete').click(function(){
        $('#foto').val('');
        $(".delete").addClass('notBlock');
        $(".preview img").remove();
    });
});
