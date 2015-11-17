# Busca_CEP_php

Algor�timo que realiza buscas de CEP's brasileiros com base em Web Site de 
consulta.

Linguagens utilizadas : php, html, javascript.
T�cnicas utilizadas : Jquery, Ajax.

Vers�o 1.0 lan�ada em 16/11/2015
   * Sem notas de atualiza��o, algoritimo funcionando atrav�s da obten��o da
     pagina html do site : http://www.qualocep.com/busca-cep retirando o
     conte�do da tag <title></title> trabalhando o  mesmo, e devolvendo o
     endere�o obtido a partir do CEP informado.
     O algor�timo funciona a base da leitura da p�gina, identifica��o do
     conte�do alvo, tratamento e retorno dos endere�os.
	 
Vers�o 1.1 lan�ada em 17/11/2015
    * Corre��o de funcionamento do algor�timo.
      O Algor�timo n�o estava realizando a retirada do espa�o que existe entre
      a v�rgula e os dados de endere�o obtidos. 
      Esse erro foi corrigido e agora o Algor�timo fornece os dados sem o espa�o 
      no in�cio da Rua, Estado e UF.


@Autor Thiago Teodoro Rodrigues.