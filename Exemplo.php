<?php

//SINALIZANDO CHARSET DA PAGINA
header('Content-Type: text/html; charset=UTF-8');

//Incluindo a Classe de Bausca de CEP.
include_once './Busca_CEP.php';

//Checando a váriavel CEP enviada via POST
if(isset($_POST["CEP"])){
    
    //Variavel existe, processando...
    
    //Retirando o Traço - do CEP enviado e armazenando em CEP
    $CEP = str_replace('-', '', $_POST["CEP"]);
    
    //Consultando CEP
        //Instanciando Objeto do Tipo Busca_CEP e já enviando o $CEP para Consulta;
        $Bucador_de_CEP = new Busca_CEP($CEP);
        
        /*
         * Escrevendo o retorno ná página para que o Ajax o colete no Result e
         * separe o Result pelo delimitador virgula, preenchendo assim os campos
         * de endereço com o os dados do CEP Obtido. Para isso a String montada
         * e escrita aqui deve ser separada da seguinte maneira :
         * Rua,Cidade,Estado
         */
        print_r($Bucador_de_CEP->getRua() . ',' . $Bucador_de_CEP->getCidade() . ',' . $Bucador_de_CEP->getUF());
    
} else {
    
    //Váriavel não existe.
    print_r('Não foi enviado nenhum CEP para consulta.');
    
}
