$(document).ready(function(){

    $("#pesquisa").on('keyup', function(){
        var texto = $(this).val();
       
        $.ajax({
            method:"POST",
            url:"config/pesquisa.php",
            data:{
                text: texto
            },
            success: function(txt){
                $('#item_das_pesquisas').css('display', 'block');
                $("#pesquisa").css('border-bottom', '0');
                $("#pesquisa").css('border-left', '0');
                $("#pesquisa").css('border-right', '0');
                $('#item_das_pesquisas').html(txt);

                if(texto == ""){
                    $('#item_das_pesquisas').css('display', 'none');
                }
            }
        });
    });

    $("#form").submit(function(e){
        e.preventDefault();
        var select = $("#idLocal").val();
        var nome = $('#exampleFormControlInput').val();
        var patri = $("#exampleFormControlInpu").val();
        var desc = $('#exampleFormControlTextarea1').val();

        $.ajax({
            method:"POST",
            url:"config/addObj.php",
            data:{
                idLocal: select,
                nome: nome,
                patrimonio: patri,
                desc: desc
            },
            success: function(txt){
                window.location.href='objetos.php';
            }
        }); 
    });
    $('#predioOne').on('click', function(){
        $('#area_rel').slideDown('fast');
        $('#area_rel').load('config/relatorio/relOne.php');
    });
    $('#predioTwo').on('click', function(){
        $('#area_rel').slideDown('fast');
        $('#area_rel').load('config/relatorio/relTwo.php');
    });
    $('#predioTree').on('click', function(){
        $('#area_rel').slideDown('fast');
        $('#area_rel').load('config/relatorio/relTree.php');
    });

    CKEDITOR.replace('exampleFormControlTextarea1');
    CKEDITOR.replace('editadesc');


});