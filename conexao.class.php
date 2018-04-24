<?php
  class Conexao{

  function Conexao (){
  		$this->Conecta();
  }

  function Conecta (){
    /*O define É UTILIZADO APRA DEFINIR INFORMAÇÕES FIXAS
    PARA A CONEXÃO COM O BANCO DE DADOS
    */
    define( 'MYSQL_HOST', 'localhost' );
    define( 'MYSQL_USER', 'root' );
    define( 'MYSQL_PASSWORD', '' );
    define( 'MYSQL_DB_NAME', 'banco_horas_eaj_bolsistas' );
    /*$this->PDO É UMA VARIÁVEL QUE POR MEIO DA DESCRIÇÃO ($this->PDO) PODE SER
    REFERENCIADA EM QUALQUER PONTO DESSA CLASSE ATÉ MESMO DENTRO DAS FUNÇÕES
    -ELA PERMITE REALIZAR A CONEXÃO COM O BANCO DE DADOS
    */
    //$this->PDO = new PDO( 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD );

    /*try ESSA IMPLEMENTAÇÃO É OPCIONAL MAS PARA AGREGAR MAIS SEGURANÇÃO NO MOMENTO DA CONEXÃO
    -ELA RETONAR UMA ERRO CASO NÃO SEJA POSSIVEL EXECUTALA NO MOMENTO
    */
    try {
       $this->PDO = new PDO( 'mysql:host=' . MYSQL_HOST . ';dbname=' . MYSQL_DB_NAME, MYSQL_USER, MYSQL_PASSWORD );
       $this->PDO->exec("set names utf8");
    }
    catch ( PDOException $e ) {
       $erro ='Erro ao conectar com o MySQL: ' . $e->getMessage();
       echo '<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
              decisao = confirm("Erro ao conectar com o MySQL, DESEJA CRIAR O BANCO NOVO.");
              if (decisao){
              alert ("UM NOVO BANCO SERÁ CRIADO!");
                location.href="criar_banco.php";
              } else {
              alert ("VERIFIQUE ERROS DE CONEXÃO COM O MySQL, OU ENTRE EM CONTATO COM O ADMINISTRADOR!");
                location.href="index.php";
              }
              </SCRIPT>';
       exit;
    }
  }

  function Desconecta () {
  		$this->PDO = null;
  }

  function Consulta ($dados) {

    $sql = "SELECT id, Nome, Turno, Email, Telefone, Cargo FROM usuario WHERE login = :login AND Senha = :senha";
    /*prepare ESTA FUNÇÃO DO PDO RENDERIZA O sql QUE FOI CRIADO PARA SER UTILIZADO PELO PDO
    */

    $stmt = $this->PDO->prepare( $sql );

    /*bindParam APONTA CADA REFERENCIA DA VARIAVEL RECEBIDA PELA FUNÇÃO AO SEUS RESPECTIVOS DADOS
    */
    $stmt->bindParam( ':login', $dados['login']);
    $stmt->bindParam( ':senha', $dados['senha']);

    $stmt->execute();

    $result = $stmt->fetchAll();
    $usuario = "";

    foreach ($result as $row => $usuario) {
      $usuario;
    }

    //var_dump($usuario);

    if ($usuario!=null) {
      return $usuario;
      $this->Desconectar();
    } else{
      $usuario = '';
      return $usuario;
      $this->Desconectar();
    }

    $this->Desconectar();
  }

  /*FUNÇÃO CONSULTAGERAL PESQUISA TODOS OS USUARIOS DO BANCO E RETORNA
  AS INFORMAÇÕES MAIS INPORTANTES.
  */
  function ConsultAllUsersActive () {
    $sql = "SELECT P.Nome, P.id, M.Ano, M.Folgas, M.Horas_Extras, M.Direito_Folga, M.Horas_Trabalhadas FROM usuario P INNER JOIN usu_horas_totais M ON (P.id = M.id_usu_horas_totais)";

    $stm = $this->PDO->prepare( $sql );

    $stm->execute();

    $result = $stm->fetchAll();

    $tabela = '<table>
      <tr>
        <td><b>id</b></td>
        <td><b>Nome</b></td>
        <td><b>Horas Trabalhadas</b></td>
        <td><b>Horas Extras</b></td>
        <td><b>Folga Semanal</b></td>
        <td><b>Ano</b></td>
      </tr> ';
    foreach ($result as $row => $all_dados) {
      $tabela .=
        '<tr>
          <td>'.$all_dados["id"].'</td>
          <td>'.$all_dados['Nome'].'</td>
          <td>'.$all_dados['Horas_Trabalhadas'].'</td>
          <td>'.$all_dados['Horas_Extras'].'</td>
          <td>'.$all_dados['Direito_Folga'].'</td>
          <td>'.$all_dados['Ano'].'</td>
        </tr>';
    }
    $tabela .= '</table>';

    return $tabela;
  }

  function ConsultAllUsers (){
    $sql = "SELECT * FROM usuario";

    $stm = $this->PDO->prepare( $sql );

    $stm->execute();

    $result = $stm->fetchAll();

    $tabela = '<table>
      <tr>
          <td><b>id</b></td>
          <td><b>Nome</b></td>
      </tr> ';
    foreach ($result as $row => $all_dados) {
      $tabela .=
        '<tr>
          <td>'.$all_dados["id"].'</td>
          <td>'.$all_dados['Nome'].'</td>
        </tr>';
    }

    $tabela .= '</table>';
    return $tabela;
  }

  function ConsultaBolsi ($id) {

    $sql = "SELECT * FROM usu_horas_totais WHERE usuario_id = $id";

    /*prepare ESTA FUNÇÃO DO PDO RENDERIZA O sql QUE FOI CRIADO PARA SER UTILIZADO PELO PDO
    */
    $stm = $this->PDO->prepare( $sql );

    $stm->execute();

    $result = $stm->fetchAll();

    $tabela = '<table>
      <tr>
          <td><b>Mês</b></td>
          <td><b>Folgas</b></td>
          <td><b>Horas Trabalhadas</b></td>
          <td><b>Horas Extras</b></td>
          <td><b>Folga Semanal</b></td>
          <td><b>Ano</b></td>
      </tr> ';
    foreach ($result as $row => $all_dados) {
      $tabela .=
        '<tr>
          <td>'.$all_dados['Mes'].'</td>
          <td>'.$all_dados['Folgas'].'</td>
          <td>'.$all_dados['Horas_Trabalhadas'].'</td>
          <td>'.$all_dados['Horas_Extras'].'</td>
          <td>'.$all_dados['Direito_Folga'].'</td>
          <td>'.$all_dados['Ano'].'</td>
        </tr>';
    }

    $tabela .= '</table>';
    return $tabela;
  }

  function ConsultaHora ($id) {

    $consulta = $this->PDO->query("");

    /*prepare ESTA FUNÇÃO DO PDO RENDERIZA O sql QUE FOI CRIADO PARA SER UTILIZADO PELO PDO
    */

    /*bindParam APONTA CADA REFERENCIA DA VARIAVEL RECEBIDA PELA FUNÇÃO AO SEUS RESPECTIVOS DADOS
    */

    $result = $stmt->execute();

    $result = $stmt->fetchAll();
    $dados = "";

    return $dados;

    $this->Desconectar();

  }

  /*
  *fUNÇÃO INSERIR RECEBE UMA VARIAVEL ACUMULADA,
  *QUE CONTEM AS DIVERSAS INFORMAÇÕES DO USUÁRIO.
  */
  function Inserir ($dados){

    /*sql UTILIZADO PARA INSERIR OS DADOS ESTE DECLARA AS REFERENCIAS
    DENTRO DE SEUS VALUES QUE SERÃO APONTADOS LOGO ABAIXO PELOA FUNÇÃO
    bindParam DO PDO.
    */
    $sql = "INSERT INTO usuario (id, Nome, Cargo, Turno, Senha, Email, Telefone, Login)
    VALUES ('',:nome, :cargo, :turno, :senha, :email, :telefone, :login)";
    /*prepare ESTA FUNÇÃO DO PDO RENDERIZA O sql QUE FOI CRIADO PARA SER UTILIZADO PELO PDO
    */

    $stmt = $this->PDO->prepare( $sql );

    /*bindParam APONTA CADA REFERENCIA DA VARIAVEL RECEBIDA PELA FUNÇÃO AO SEUS RESPECTIVOS DADOS
    */
    $stmt->bindParam( ':nome', $dados['nome']);
    $stmt->bindParam( ':cargo', $dados['cargo']);
    $stmt->bindParam( ':turno', $dados['turno']);
    $stmt->bindParam( ':senha', $dados['senha']);
    $stmt->bindParam( ':email', $dados['email']);
    $stmt->bindParam( ':telefone', $dados['telefone']);
    $stmt->bindParam( ':login', $dados['login']);

    /*execute() COMO O SEU PRÓPIO NOME DIZ ELE EXECUTA O sql DO prepare
    */
    $result = $stmt->execute();

    if (!$result) {
        /*erroInfo RETORNA UMA ERRO CASO O $resuLT SEJA null
        */
        $erro = var_dump( $stmt->errorInfo() );
        echo "<script>
          alert('ERRO AO GRAVAR DADOS! : $erro');
          history.back();
        </script>";
        //echo "<script></script>";
        exit;
    } else {
      echo "<script>
        alert('DADOS GRAVADOS COM SUCESSO!');
        window.location = 'index.php';
      </script>";
      exit;
    }
    /*rowCount CONTA AS LINHAS INSERIDAS NA ULTIMA CONEXAO CASO SEJA MAIOR QUE 0
    RETORNA A FRASE ESCRITA
    */
    //echo $stmt->rowCount() . "linhas inseridas";

    $this->Desconectar();
  }

  function CheckLogin($loginUser){

    $sql = "SELECT Login FROM usuario WHERE Login = :login";
    $stmt = $this->PDO->prepare( $sql );
    $stmt->bindParam( ':login', $loginUser);
    $stmt->execute();
    $result = $stmt->fetchAll();
    $login = '';

    foreach ($result as $row => $login) {
      $login['Login'];
    }

    if (empty($result)) {
      return 1;
    } else{
      return 0;
    }
  }

  function Deletar(){

  }

  function Alterar(){

  }

  /*INSERIR PONTO PARA O USUÁRIO, RECEBE O ID DE QUALQUER USUÁRIO CADASTRADO E
  INSERE DATA HORA DE ENTRADA E SITUAÇÃO NO BANCO DE DADOS.
  */

  function insertPointNow ($id_user, $situation) {
    /*SQL DE INSERÇÃO DO PONTO DE ENTRADA DO BOLSISTA.
    */
    $sql = "INSERT INTO usu_ponto(id_usu_ponto, usuario_id, Data_Ponto, Hora_Ponto, Situacao)
    VALUES ('',:id,:data,:hora,:situacao)";

    $insertPoint = new GerarHora();

    $HoraAtual = $insertPoint->HoraAtual();
    $DataAtual = $insertPoint->DataAtual();
    $Situacao = $situation;

    $stmt = $this->PDO->prepare( $sql );

    $stmt->bindParam( ':id', $id_user);
    $stmt->bindParam( ':data', $DataAtual);
    $stmt->bindParam( ':hora', $HoraAtual);
    $stmt->bindParam( ':situacao', $Situacao);

    $result = $stmt->execute();

    if (!$result) {
      return 0;
      $this->Desconectar();
    } else {
      return "ok";
      $this->Desconectar();
    }
  }
}
?>
