<?php

/*
 * Classe que realiza a Busca do CEP
 */

/**
 * Descrição da Busca_CEP
 *
 * A Classe Busca_CEP foi elaborada para trabalhar com a página web de busca
 * de CEP http://www.qualocep.com. Essa página web, quando acessada 
 * na URL http://www.qualocep.com/busca-cep/(CEP) fornece os dados 
 * de endereço do CEP informado. O que essa classe faz é ler o HTML fornecido
 * pela página,procurar pela TAG de abertura <(Tag)> e pela tag de fechamento
 * </(Tag)> obter o conteúdo dentro dessas Tag's e trabalha-los para
 * preencher/exibir o endereço do CEP. 
 * 
 * IMPORTANTE!!!
 * 
 * As tag's aqui escolhidas poderiam ser outras, bem como também, a forma de 
 * trabalhar com a String HTML. 
 * Esse algoritmo foi inteiramente adaptado para a realidade da página na data 
 * de concepção do algoritmo. Como a página pode mudar, ou o usuário também pode
 * querer obter os dados de uma outra forma por outras tag’s, ou por outro meio 
 * de obtenção de conteúdo entre as tag’s, deixamos as configurações da classe 
 * no construtor bem explicitas, para que possam ser alteradas e entendidas de 
 * maneira tranquila. O que pode facilitar caso o usuário deseje mudar o 
 * funcionamento da classe. 
 * 
 * O conceito aplicado aqui é bem semelhante a WEB servisse. Porém estamos
 * trabalhando com código HTML de uma página e adaptando a nossa necessidade. 
 * O Código é passível de alteração e serve de exemplo para diversas situações.
 * 
 * 
 * @author Thiago Teodoro Rodrigues.
 * @version 1.1 - 17/11/2015
 * 
 */

class Busca_CEP {

    //Atributos da Classe
    private $URL_Site;
    private $Tag_Abertura;
    private $Tag_Fechamento;
    private $Rua;
    private $Cidade;
    private $UF;
    private $CEP;

    /**
     * Construtor da Classe Busca_CEP
     * 
     * O Construtor realiza várias funções, dentro da sua execução ele "seta"
     * as configurações necessárias para o funcionamento da Classe.
     * 
     * Após a "setagem" ele gera um $URL_Busca_CEP com base no CEP enviado,
     * para consulta fornecido com parâmetro. E chama o método Buscar_CEP()
     * da própria classe, passando como parâmetro a $URL_Busca_CEP.
     * 
     * O Método Buscar_CEP vai gerar a busca trabalhar seus resultados e
     * armazenar em Atributos da própria classe o resultado, feito isso 
     * a classe atinge seu objetivo e fornecer por GET veja bem apenas 
     * GET os dados do endereço encontrado.
     * 
     * IMPORTANTE!!!
     * 
     * O construtor checa a execução do método Buscar_CEP() que tem retorno
     * booleano, caso aconteça algum problema será informado pelo construtor.
     * 
     */
    public function __construct($CEP) {
        
        //Inicializando Variáveis {Boa prática}
        $this->URL_Site = '';
        $this->Tag_Abertura = '';
        $this->Tag_Fechamento = '';
        $this->Rua = '';
        $this->Cidade = '';
        $this->UF = '';
        $this->CEP = 0;
        
        //Configurando os atributos da Classe
        $this->URL_Site = 'http://www.qualocep.com/busca-cep'; //URL de Busca de CEP
        $this->Tag_Abertura = '<title>'; //Tabela que contém o que precisamos.
        $this->Tag_Fechamento = '</title>'; //Fim da Tabela que comtem o que precisamos.
        
        //Gerando $URL_Busca_CEP
        $URL_Busca_CEP = $this->URL_Site . "/" . $CEP;        
        
        //Executando a Busca do Enderço com Base no CEP enviado.
        $Resultado_Operacao = $this->Buscar_CEP($URL_Busca_CEP);
        
        //Checando o Resultado da Operação para emissão de erro.
        if($Resultado_Operacao != TRUE){
            
            //Falha na operação.
            print_r('<br/> Falha na operação de obtenção de dados de endereçamento do CEP informado.');
            
        }

    }
    
    
    /**
     * Método que executa a busca e trabalha os dados obtidos, para fornecer
     * os dados do CEP informado.
     * 
     */
    public function Buscar_CEP($URL_Busca_CEP){
        
        //Obtendo a página HTML resultante da Busca.
        $Pagina = file_get_contents($URL_Busca_CEP);
        
        //Procurando a posição de ínicio da Tag(Palavra) em $this->Tag_Abertura
        $Pos_Inicio_Tag_Abertura = strpos($Pagina, $this->Tag_Abertura);
        
        /*
         * Checando se foi encontrada a Tag de Abertura, caso ela não tenha
         * sido encontrada a váriavel $Pos_Inicio_Tag_Abertura vai receber
         * o boolean False.
         */
        if($Pos_Inicio_Tag_Abertura == FALSE){
            
            //Tag não encontrada no HTML de retorno do Web Site.
            print_r('A Tag de abertura para "Triagem" do conteúdo, não foi encontrada no HTML resultante do Web Site de Consulta de Cep : ' . $this->URL_Site);
            
            //Retornando False indicando falha na operação
            return FALSE;
            
        } else {
            
            //Tag encontrada de Abertura. Continuando processamento.
            
            /*
             * Como a função strpos me dá a posição de inicío de uma palavra,
             * se eu não quiser pegar essa palavra inclusive no resultado que
             * será trabalhado, que é o nosso caso, eu não preciso da tag no 
             * meu resultado, eu somo então, o tamanho da Tag(Palavra) 
             * encontrada a Posição em que ela foi encontrada, assim eu excluo a
             * tag do resultado da Substring que vou realizar posteriormente.
             *
             * Resumidamente, estamos apenas retirando a TAG informada, do 
             * conteúdo que será trabalhado, somando à posição inicio dela 
             * mesma o seu próprio tamanho, o que vai mover o ponteiro para
             * exatamente o término da tag.
             */
            $Pos_Inicio_Tag_Abertura = $Pos_Inicio_Tag_Abertura + strlen($this->Tag_Abertura);
            
            //Procurando a posição de ínicio da Tag(Palavra) em $this->Tag_Fechamento
            $Pos_Inicio_Tag_Fechamento = strpos($Pagina, $this->Tag_Fechamento);
            
            /*
             * Checando se foi encontrada a Tag de Fechamento, caso ela não 
             * tenha sido encontrada a váriavel $Pos_Inicio_Tag_Fechamento vai 
             * receber o boolean False.
             */
            if($Pos_Inicio_Tag_Fechamento == FALSE){
                
                //Tag não encontrada no HTML de retorno do Web Site.
                print_r('A Tag de fechamento para "Triagem" do conteúdo, não foi encontrada no HTML resultante do Web Site de Consulta de Cep : ' . $this->URL_Site);
                
                //Retornando False indicando falha na operação
                return FALSE;
                
            } else {
                
                //Tag encontrada de Abertura. Continuando processamento.
                
                /*
                 * Nota:
                 * 
                 * Como o strpos informa a posição de início de uma palavra
                 * na $Pos_Inicio_Fechamento, eu não vou precisar, somar seu
                 * tamanho para pular ela. Por que o início dela é exatamente
                 * onde eu quero parar com minha triagem de conteúdo. Por que
                 * se eu somar o tamanho da tag à $Pos_Inicio_Fechamento eu vou
                 * incluir a Tag de Fechamento ao resultado. O que não é o 
                 * que desejo nesse algorítimo.
                 */
                
                
                /*
                 * Agora vamos realizar o Substring do conteúdo entre as
                 * posições obtidas, ou seja, eu vou “Recortar” o que está
                 * entre as posições das tag's, a fim de trabalhar o resultado
                 * e fornecer os nomes de RUA UF e Cidade do CEP informado.
                 * 
                 * DETALHE, o substr do PHP trabalha da seguinte maneira,
                 * ele pega uma posição de início do “Recorte” e corta x 
                 * posições. Ou seja, eu preciso informar para ele quanto
                 * eu quero que ele corte a partir de uma posição. Para fazer
                 * isso antes de contar, eu preciso saber quantas letras 
                 * existem entre a posição da Tag de Abertura e a Posição
                 * da Tag de Fechamento. Para conseguir isso é simples, eu
                 * vou pegar a posição de onde começa a Tag de Fechamento 
                 * e subtrair a posição de onde TERMINA a Tag de 
                 * Abertura(É termina, por que eu somei o tamanho dela fazendo
                 * com que o ponteiro fosse para o fim da tag de abertura)
                 * dessa forma, eu vou saber exatamente quantas posições 
                 * existem entre uma Tag e outra e quando eu realizar o 
                 * substring vou ter exatamente o que está entre uma Tag e 
                 * outra. No fim é Matemática '-'
                 */
                
                /*
                 * Obtendo número de posições (Letras) Entre a Tag de Abertura e
                 * de Fechamento. Trabalha-se Fechamento primeiro - a Abertura
                 * por que caso contrário o número será negativo. Pois a 
                 * posição maior está na Posição do Fechamento e não da Abertura 
                 */
                $Numero_Posicoes_Entre_As_Tags = $Pos_Inicio_Tag_Fechamento - $Pos_Inicio_Tag_Abertura;
                
                /*
                 * Realizando Substring.
                 * 
                 * Cortando da Posição da Tag de Abertura, o Número de posições
                 * até a Tag de Fechamento. Assim como já explicamos.
                 */   
                $Texto_Entre_As_Tags = substr($Pagina, $Pos_Inicio_Tag_Abertura, $Numero_Posicoes_Entre_As_Tags);
                
                /*
                 * O site de busca de CEP : http://www.qualocep.com/busca-cep
                 * tem um padrão que atrapalha nosso Algorítimo, vamos então
                 * adaptar isso, todo resultado que está entre as tags
                 * <title> </title> começa com as palavras "Qual o CEP da", 
                 * nos precisamos remover isso do nosso resultado, para 
                 * então fragmentar o resultado por separador vírgula, 
                 * por que o site de busca coloca entre vírgulas os dados
                 * da Rua, Cidade, UF, CEP. Por tanto nossa primeira ação é
                 * remover as palavras "Qual o CEP da", vamos fazer isso 
                 * com o str_replace, vamos pedir para substituir por nada, 
                 * as ocorrências de "Qual o CEP da".
                 */
                
                /*
                 * Acompanhe o Funcionamento, procure por 'Qual o Cep da', 
                 * substitua por '', na String $Texto_Entre_As_Tags o resultado
                 * de tudo isso você guarta em $Texto_Entre_As_Tags.
                 */
                $Texto_Entre_As_Tags = str_replace('Qual o CEP da', '', $Texto_Entre_As_Tags);
                
                
                /*
                 * Pronto, agora, como site coloca entre vírgulas os nomes
                 * RUA, Cidade, UF, CEP vamos quebrar o resultado por vírgula
                 * usando explode().
                 */
                
                /*
                 * Acompanhe o funcionamento, atribua para o Vetor Dados, 
                 * separando por vírgula(',') os dados em $Texto_Entre_As_Tags
                 */
                $Dados = explode(',', $Texto_Entre_As_Tags);
                
                /*
                 * CHECANDO SE OS DADOS DE ENDEREÇO DO CEP, FORAM ENCONTRADOS.
                 * 
                 * Veja bem, eu poderia checar se a frase, resultante 
                 * do conteúdo entre as Tag's <title></title> é 
                 * 'Busca cep dos correios ou Download do banco de dados CEP 2015'
                 * porém essa frase pode mudar, pois o banco que é atualizado é o que 
                 * muda no final da frase, e isso não necessariamente vai ocorrer
                 * de ano em ano, ou seja não tem com checar essa Frase
                 * com precisão.
                 * 
                 * Como não tem como checar com precisão e ainda poderemos ter
                 * um outro erro, que a mudança de padrão do site, ou seja, 
                 * vai que o site muda um dia o conteúdo que ele fornece
                 * nas tag's <title></title>, mediante a essas possibilidades
                 * eu resolver a realizar a checagem pelo tamanho do vetor.
                 * Estou assumindo que se o vetor, depois de passar pelo explode
                 * for diferente de 4 então pode ter havido dois problemas.
                 * Ou os dados de endereço do cep não foram encontrados, ou 
                 * o Layout do Site utilizado não é compatível com o algorítimo
                 * ou mesmo o layout do site sofreu alterações.
                 * 
                 * Se esse erro ocorrer eu vou simplesmente emitir, a seguinte
                 * mensagem, 'Erro na obtenção dos dados de endereço do CEP. 
                 * Favor conferir a digitação do mesmo, ou digitar os dados
                 * manualmente'. 
                 *  
                 */
                if(count($Dados) == 4) {
                
                
                    /*
                     * Veja bem agora eu vou ter o seguinte no Vetor.
                     * Posições :
                     * 
                     * Posição 0 -> Dados da Rua
                     * Posição 1 -> Cidade
                     * Posição 2 -> UF
                     * Posição 3 -> CEP (** PRECISA TRATAR)
                     * 
                     * Agora basta atribuir paras as variáveis da Classe o resultado
                     * todas as posições estão prontas, é só atribuir, com exceção
                     * da posição 3 a posição do CEP, o site coloca nessa posição
                     * a palavra 'CEP '(Cep espaço) e depois vem com o número do 
                     * CEP. Por tanto, preciso remover com o strreplace essa palavra
                     * antes de fazer a atribuição. 
                     */

                    //A ORDEM DE ATRIBUIÇÃO AQUI TEM QUE SER ESSA, A ORDEM TEM IMPORTANCIA

                    //Atribuindo Dados da Rua para $this->Rua.
                        /*
                         *  O Primeiro Carácter depois da Virgula é um espaço então 
                         *  eu vou fazer um substring aqui pulando a posição 0 
                         *  ou seja pulando o espaço e ir até o final da palavra
                         *  que o próprio tamanho da palavra -1 por que o PHP 
                         *  trabalha com numério de posições que eu quero cortar
                         *  apartir de um ínicio. Para pular a posição 0 eu vou
                         *  começar na posição 1 = ) e vou até o tamanho da
                         *  da palavra -1, o -1 é por que eu pulei uma letra 
                         *  pulei o espaço que estava na 0.
                         */
                        $this->Rua = substr($Dados[0], 1, (strlen($Dados[0]) -1) );

                    //Atribuindo Dados da Cidade para $this->Cidade.
                        /*
                         *  O Primeiro Carácter depois da Virgula é um espaço então 
                         *  eu vou fazer um substring aqui pulando a posição 0 
                         *  ou seja pulando o espaço e ir até o final da palavra
                         *  que o próprio tamanho da palavra -1 por que o PHP 
                         *  trabalha com numério de posições que eu quero cortar
                         *  apartir de um ínicio. Para pular a posição 0 eu vou
                         *  começar na posição 1 = ) e vou até o tamanho da
                         *  da palavra -1, o -1 é por que eu pulei uma letra 
                         *  pulei o espaço que estava na 0.
                         */
                        $this->Cidade = substr($Dados[1], 1, (strlen($Dados[1]) -1) );

                    //Atribuindo Dados da UF para $this->UF.
                        /*
                         *  O Primeiro Carácter depois da Virgula é um espaço então 
                         *  eu vou fazer um substring aqui pulando a posição 0 
                         *  ou seja pulando o espaço e ir até o final da palavra
                         *  que o próprio tamanho da palavra -1 por que o PHP 
                         *  trabalha com numério de posições que eu quero cortar
                         *  apartir de um ínicio. Para pular a posição 0 eu vou
                         *  começar na posição 1 = ) e vou até o tamanho da
                         *  da palavra -1, o -1 é por que eu pulei uma letra 
                         *  pulei o espaço que estava na 0.
                         */
                        $this->UF = substr($Dados[2], 1, (strlen($Dados[2]) -1) );

                    /*
                     * Tratando o CEP
                     */

                    /*
                     * Removendo da Posição 3 a posição do Cep a palavra ' CEP ',
                     * observe que existem dois espaços que devem ser incluídos, 
                     * depois de remover eu atribuo o resultado para a própria
                     * Posição 3.
                     */
                    $Dados[3] = str_replace(' CEP ', '', $Dados[3]);

                    //Pronto agora posso atribuir para $this->CEP o Cep.
                    $this->CEP = $Dados[3];
                    
                    /*
                     * Operação concluida com sucesso, sinalizando sucesso da 
                     * operação retornando true.
                     */
                    return TRUE;
                
                } else {
                    
                    //Problema na obtenção dos dados de endereço do CEP.
                    print_r('Erro na obtenção dos dados de endereço do CEP informado. A separação do vetor, não foi bem-sucedida. Linha : 261 de Busca_CEP.php. Favor conferir a digitação do mesmo, ou digitar os dados de endereço manualmente.');
                    
                    //Retornando False indicando Falha na operação
                    return FALSE;
                    
                }
   
            }
         
        }
   
    }
    
    
    //Métodos de Acesso GET|SET
    
    /*
     * Nessa classe não vamos fazer método de acesso Get e Set para :
     * 
     * $this->Tag_Abertura;
     * $this->Tag_Fechamento;
     * $this->URL_Site;
     * 
     * O Construtor é quem popula e configura esse parâmetros.
     * 
     * Também não vamos implementar métodos set para :
     * 
     * $this->Rua;
     * $this->Cidade;
     * $this->UF;
     * $this->CEP;
     * 
     * Pois essas variáveis nunca devem ser alteradas a não ser pelo método 
     * buscar CEP, por tanto os únicos métodos de acesso delas são os métodos
     * GET.
     * 
     */
    
    //GET Rua
    public function getRua() {
        
        //Retornando os Dados da Rua
        return $this->Rua;
        
    }
    
    //GET Cidade
    public function getCidade() {
        
        //Retornando os Dados da Cidade
        return $this->Cidade;
        
    }
     
    //GET UF
    public function getUF() {
        
        //Retornando os Dados da UF
        return $this->UF;
    }
    
    //GET CEP
    public function getCEP(){
        
        //Retornando os Dados do CEP
        return $this->CEP;
        
    }
    
}
