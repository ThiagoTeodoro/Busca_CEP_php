# Busca_CEP_php

Algorítimo que realiza buscas de CEP's brasileiros com base em Web Site de 
consulta.

Linguagens utilizadas : php, html, javascript.
Técnicas utilizadas : Jquery, Ajax.

Versão 1.0 lançada em 16/11/2015
   * Sem notas de atualização, algoritimo funcionando através da obtenção da
     pagina html do site : http://www.qualocep.com/busca-cep retirando o
     conteúdo da tag <title></title> trabalhando o  mesmo, e devolvendo o
     endereço obtido a partir do CEP informado.
     O algorítimo funciona a base da leitura da página, identificação do
     conteúdo alvo, tratamento e retorno dos endereços.
	 
Versão 1.1 lançada em 17/11/2015
    * Correção de funcionamento do algorítimo.
      O Algorítimo não estava realizando a retirada do espaço que existe entre
      a vírgula e os dados de endereço obtidos. 
      Esse erro foi corrigido e agora o Algorítimo fornece os dados sem o espaço 
      no início da Rua, Estado e UF.


@Autor Thiago Teodoro Rodrigues.