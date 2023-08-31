Esta e uma api do desafio de backend da Pic-pay
Em que foi pedido que se construi-se um servico usando um framework para cadastro de 2 tipos de usuarios: varejistas e clientes
que tem os mesmos attributos, como email, nome e documento de identificacao
E neste servico deve ser possivel realizar transacoes entre os usuarios, sendo que os varejistas apenas recebem valores e nao podem transferir
E pedido tambem que se valide o saldo do usuario a quando da realizacao da operacao

Para alem destes pontos, e necessario que se consulte uma api externa para poder finalizar a transacao, api essa que nos devolve uma resposta de autorizacao para efectivacao da transacao
devendo ser validada, a transacao so ocorre caso a resposta seja positiva

Depois de se verificar a resposta da Api externa e necessario que se faca o uso de um servico para envio de notificacoes ao usuario que recebe o valor da transacao.


Acima deixei ficar descricao do desafio e passo a explanar as tecnologias e forma de implementacao usadas:

O framework usado para o desenvolvimento da solucao e o laravel na sua versao: 8.83.27
E a versao do php e: 8.0.28

Optei no uso da programacao orientada a servicos, em que cada um deles, executa uma tarefa em especifico, alido a arquitetura mvc que nos e disponibilizada pelo framework

Sendo assim defini 2 models, um para guardar informacao de transacoes e outro a informacao dos usuarios
Foram definidos tambem os seus repositorios, services e migrations para geracao dos atributos na base de dados

Servico de cadastro e usuarios:
Neste servico e injectado um repositorio do proprio usuario em que sao implementados mdetodos de criacao, actualizacao, busca, listagem e para eliminar. implementando tambem as validacoes necessarias conforme a a descricao do desafio

Servico de Transacoes
E injectado um o repositorio de transacoes, o servico de email e o servico de usuaios
Este servico recebe atributos como o valor que sera transacionado e os usuarios que realizaram a transacao
E relizada uma chamada http para consulta do servico externo disponiblizado no desafio com o link: 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6'
Apos a  validacao da reposta, efectua-se a transacao

E chamado um servico de email interno que recebe os dados da composicao do email e envia uma notificacao para o usuario
