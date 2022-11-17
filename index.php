<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .parlamentares{
            width: 100%;
            display: grid;
            grid-template-columns: repeat(6,1fr);
            grid-template-rows: auto;
            grid-row-gap: 20px;
            margin-top: 20px;
        }
        .deputado{
            border: solid 1px #000;
            background-color: #fff;
            margin: auto;
            border-radius: 5px;
            text-align: center;
            padding: 5px 5px 5px 5px;
            width: 150px;
            max-width: 150px;
        }
        .imagem img{
            width: 114px;
            height: 152px;
        }
    </style>
</head>
<body>
    <h2>Escolha o Partido na qual deseja Visualizar seus Parlamentares</h2>
    <form action="" method="post" name="formulario" id="formulario">
        <select name="partido" id="partido">
            <option value=""></option>
        </select>
        <input type="submit" value="Limpar" id="botao">
    </form>

    <div class="parlamentares">
        
    </div>

    <!-- Iniciando JS de Consumo da API -->
    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script>
        $.ajax({
            url: "https://dadosabertos.camara.leg.br/api/v2/partidos/?pagina=1&itens=500",
            type: "GET",
            dataType: "json",
            success: function (data) {
                $(data.dados).each(function(index, element){
                    $('select').append('<option value='+element.id+'>'+element.sigla+'</option>');
                });
            },
            error: function(data){
                alert("Algum erro ocorreu, consulte o log.");
            }
        });

        $('#partido').change(function(){
            var idPartido = $('#partido').val();

            $.ajax({
                url: "https://dadosabertos.camara.leg.br/api/v2/partidos/"+idPartido,
                type: "GET",
                dataType: "json",
                success: function(data){
                    $(data.dados).each(function(index, element){
                        const urlDeputados =element.status.uriMembros;

                        $.ajax({
                            url: urlDeputados,
                            type: "GET",
                            dataType: "json",
                            success: function(data){
                                $('.deputado').remove();
                                $(data.dados).each(function(index, element){
                                    
                                    $('.parlamentares').append('<div class="deputado"><div class="imagem"> <img src='+element.urlFoto+' alt=""></div> <div> <p> '+element.nome+' </p> </div> <div class="partido"> <p>'+element.siglaPartido+'</p> </div> <div class="estado"> <p>'+element.siglaUf+'</p> </div> </div>');
                                });
                            }
                        });

                    });
                }
            }); 
        });
        
    </script>
</body>
</html>