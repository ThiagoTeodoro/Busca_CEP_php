<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Interface de Exemplo</title>
        <script src="jquery-2.1.4.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            //Função para formatar os campos de acordo com mascara solicitada
            function formatar(mascara, documento) {
                var i = documento.value.length;              
                var saida = mascara.substring(0, 1);
                var texto = mascara.substring(i);
                if (texto.substring(0, 1) !== saida) {
                    documento.value += texto.substring(0, 1);
                }
            }
        </script>
        <style>
            
            .ImagenBotaoPesquisar {
                
                background-image: url("Search.png");
                width: 24px;
                height: 24px;
            }
            
            /*Por padrão a Div deve ficar Oculta*/
            #loading {
                
                background-image: url("Loading.gif");
                width: 256px;
                height: 256px;
                display: none; /* Ocultado a DIV */
                
            }
        </style>
        
    </head>
    <body>
        <!-- 
            Div de Loading, essa Div fica aparecendo enquanto o resultado
            da consulta não é obitdo pelo Ajax
        -->
        <div id="loading">
        
        </div>
        <!-- 
            Quando o usuário precionar qualquer tecla no campo
            chamamos a formatação para formatar o CEP de acordo com o formato
            padrão que é o 99999-999 também preciso limitar o campo a um número 
            máximo de caracteres em 9 que é o tamanho com a máscara.
        -->
        <form name="BuscaCEP" action="Exemplo.php">
            <span>CEP : </span><input type="text" name="CEP" onkeypress="formatar('#####-###', this)" maxlength="9" size="9" required/>
            <input type="button" name="PesquisarCEP" id="PesquisarCEP" class="ImagenBotaoPesquisar"/> <!-- O Accesskey="1" é para quando precionar o enter o botão ser acionado" --> 
            <br/>
            <br/>
            <span>Endereço : </span><input type="text" name="Endereco" size="150">
            <br/>
            <br/>
            <span>Cidade : </span><input type="text" name="Cidade" size="50" />
            <br/>
            <br/>
            <span>Estado : </span><input type="text" name="Estado" size="2" />            
        </form>
    </body>
    <script>
        //Envia CEP via POST para consutal e preenchimento.    
        $(function(){
                $("#PesquisarCEP").click(function(){ //Quando se clica no botão alterar senha
                    var CEP = $("input[name=CEP]").val();

                    $.ajax({
                        type: "POST",
                        data: { CEP:CEP },
                        url: "Exemplo.php", //Lembre-se SEMPRE, O CAMINHO é EM RELAÇÂO À PÁGINA PAI - Isso aqui é para onde ele ta enviando.
                        dataType: "html",
                        success: function(result)
                        {
                           // A Página Exemplo.php escreve com resultado os dados separando por virgula. Então eu vou quebra-los para preencher os campos
                           var Resultado = result;
                           Resultado = Resultado.split(',');


                           $("input[name=Endereco]").val(Resultado[0]);
                           $("input[name=Cidade]").val(Resultado[1]);
                           $("input[name=Estado]").val(Resultado[2]);


                        },
                        beforeSend: function(){
                            $('#loading').css({display:"block"});
                        },
                        complete: function(){
                            $('#loading').css({display:"none"});
                        }
                    });
                });
            });
    </script>
</html>
