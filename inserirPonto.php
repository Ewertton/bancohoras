<?php

  include_once 'conexao.class.php';
  include_once 'GerarHora.php';

  $Conexao = new Conexao();
  $insertPoint = new GerarHora();

  function get_post_action($name) {
      $params = func_get_args();
      foreach ($params as $name) {
          if (isset($_POST[$name])) {
              return $name;
          }
      }
  }

  if(!empty($_POST['id'])) {
    $id = $_POST['id'];
    switch (get_post_action('insert', 'exit')) {
      case 'insert':
                      checkPoinEnter ($id);
                      insertPoint($id);
                      echo "<script>window.location = 'bolsistas.php';</script>";
          break;
      case 'exit':
                    checkPoinExit ($id);
                    exitPoint($id);
                    echo "<script>window.location = 'bolsistas.php';</script>";
          break;
      default:
          problema();
    }
  }else{
     problema();
  }
  function insertPoint($id) {

    /*checkPoint() É UMA FUNÇÃO QUE VERIFICA SE O USUÁSRIO JÁ MARCOU SEU PONTO
    PARA AQUELE DIA. E IMPEDE QUE O USUÁRIO MARQUE MAIS DE UM PONTO.
    */
    checkPoinEnter($id);

    /*SQL DE INSERÇÃO DO PONTO DE ENTRADA DO BOLSISTA.
    */
    $sql = "INSERT INTO usu_ponto(id_usu_ponto, usuario_id, Data_Ponto, Hora_Ponto, Situacao)
    VALUES ('',:id,:data,:hora,:situacao)";


    $HoraAtual = $GLOBALS['insertPoint']->HoraAtual();
    $DataAtual = $GLOBALS['insertPoint']->DataAtual();
    $situacao = 1;

    /*prepare ESTA FUNÇÃO DO PDO RENDERIZA O sql QUE FOI CRIADO PARA SER UTILIZADO PELO PDO
    */
    $stmt = $GLOBALS['Conexao']->PDO->prepare( $sql );

    /*bindParam APONTA CADA REFERENCIA DA VARIAVEL RECEBIDA PELA FUNÇÃO AO SEUS RESPECTIVOS DADOS
    */
    $stmt->bindParam( ':id', $id);
    $stmt->bindParam( ':data', $DataAtual);
    $stmt->bindParam( ':hora', $HoraAtual);
    $stmt->bindParam( ':situacao', $situacao);

    /*execute() COMO O SEU PRÓPIO NOME DIZ ELE EXECUTA O sql DO prepare
    */
    $result = $stmt->execute();

    if (!$result) {
      /*erroInfo RETORNA UMA ERRO CASO O $resuLT SEJA null
      */
      var_dump( $stmt->errorInfo() );
      $GLOBALS['Conexao']->Desconectar();
      problema();
    }
  }
  /*FUNÇÃO QUE INSERE A SAIDA DO USUÁRIO E ATUALIZA AS HORAS EXTRAS E HORAS
  TRABALHADAS.
  */
  function exitPoint ($id) {
    /*COPIEI TODA O CODIGO DA FUNÇÃO DE insertpoint(0) PARA
    REORGANIZAR E FAZER COM QUE ELA INSIRA REALMENTE A HORA QUE O
    BOLSISTA TRABALHOU.
    */
    checkPoinExit($id);
    /*SQL DE INSERÇÃO DO PONTO DE SAIDA DO BOLSISTA.
    */
    $sql = "INSERT INTO usu_ponto(id_usu_ponto, usuario_id, Data_Ponto, Hora_Ponto, Situacao)
    VALUES ('',:id,:data,:hora,:situacao)";

    $HoraAtual = $GLOBALS['insertPoint']->HoraAtual();
    $DataAtual = $GLOBALS['insertPoint']->DataAtual();
    $situacao = 0;

    /*prepare ESTA FUNÇÃO DO PDO RENDERIZA O sql QUE FOI CRIADO PARA SER UTILIZADO PELO PDO
    */
    $stmt = $GLOBALS['Conexao']->PDO->prepare( $sql );

    /*bindParam APONTA CADA REFERENCIA DA VARIAVEL RECEBIDA PELA FUNÇÃO AO SEUS RESPECTIVOS DADOS
    */
    $stmt->bindParam( ':id', $id);
    $stmt->bindParam( ':data', $DataAtual);
    $stmt->bindParam( ':hora', $HoraAtual);
    $stmt->bindParam( ':situacao', $situacao);

    /*execute() COMO O SEU PRÓPIO NOME DIZ ELE EXECUTA O sql DO prepare
    */
    $result = $stmt->execute();

    if (!$result) {
      /*erroInfo RETORNA UMA ERRO CASO O $resuLT SEJA null
      */
      $stmt->errorInfo();
      $GLOBALS['Conexao']->Desconectar();
      problema();
    }
    calculateHour($id);
    echo "<script>window.location = 'bolsistas.php';</script>";
    }

  function calculateHour ($id) {

    $mes = $GLOBALS['insertPoint']->MesAtual();
    $ano = $GLOBALS['insertPoint']->AnoAtual();


    $sql_usu_horas_totais = "SELECT * FROM usu_horas_totais WHERE usuario_id = $id  AND Mes = $mes AND Ano = $ano";

    /*prepare ESTA FUNÇÃO DO PDO RENDERIZA O sql QUE FOI CRIADO PARA SER UTILIZADO PELO PDO
    */
    $stmt_usu_horas_totais = $GLOBALS['Conexao']->PDO->prepare( $sql_usu_horas_totais );

    /*execute() COMO O SEU PRÓPIO NOME DIZ ELE EXECUTA O sql DO prepare
    */
    $stmt_usu_horas_totais->execute();
    $result_usu_horas_totais = $stmt_usu_horas_totais->fetchAll();

    /*AS VARIÁVEIS ESTÃO RECEBENDO ZERO NESTE PONTO PARA
    ASEGURAR QUE AMBAS ESTEJAM SEM VALORES NUMERICOS ALEATÓRIOS.
    */
    $hex = 0;
    $htrab = 0;

    /*CASO O USUÁRIO NÃO POSSUA HORAS CADASTRADAS PARA ESTE MÊS O ISTEMA TERA QUE RESGATAR AS HORAS DO MêS
    PASSADO PARA INSERIR COM AS DESTE MêS, NESTE CASO O RESULT RETORNARÁ empty().
    */
    if (empty($result_usu_horas_totais)) { //<--NÃO TEM HORAS NESTE MêS
      //return false;

      //echo "NÃO TEM HORAS NO MêS DE";

      /*CASO O USUÁRIO ESTEJA NO MÊS DE JANEIRO(1), PARA RESGATAR OS VALORES DO MÊS ANTERIOR
      SERÁ NECESSÁRIO ADICIONAR 13 AO MÊS ATUAL E REDUZIR UM (1) DO ANO ATUAL.
      "DESSA FORMA SERÁ POSSIVEL MANTER A LÓGICA DE RESGATE DAS HORAS ANTERIORES SEMPRE".
      */
      //RENOVNADO AS VARIÁVEIS.
      $mes = $GLOBALS['insertPoint']->MesAtual();
      $ano = $GLOBALS['insertPoint']->AnoAtual();

      if($mes == 1 ){
        $mes = 13;
        $ano = $ano - 1;
      }

      $mes_passado = $mes - 1;//,--MÊS AGORA SE REFERA AO MÊS ANTERIOR

      /*SQL DE CONSULTA DAS HORAS EXTRAS DO MÊS PASSADO PARA SOMAR AS DO MÊS ATUAL.
      */
      $sql_usu_horas_totais = "SELECT * FROM usu_horas_totais WHERE usuario_id = $id AND Mes = $mes_passado AND Ano = $ano";

      /*prepare ESTA FUNÇÃO DO PDO RENDERIZA O sql QUE FOI CRIADO PARA SER UTILIZADO PELO PDO
      */
      $stmt_usu_horas_totais = $GLOBALS['Conexao']->PDO->prepare( $sql_usu_horas_totais );

      /*execute() COMO O SEU PRÓPIO NOME DIZ ELE EXECUTA O sql DO prepare
      */
      $stmt_usu_horas_totais->execute();
      $result_usu_horas_totais = $stmt_usu_horas_totais->fetchAll();

      /*CASO O USUÁRIO NÃO TENHA POSSUA NENHUM REGISTRO AINDA.
      */
      if (empty($result_usu_horas_totais)) {
        $hex_usu_horas_totais = '0:00:00';
        $htrab_usu_horas_totais = '0:00:00';
      }

      /*ARMAZENA OS VALORES DAS HORAS EXTRAS E HORAS TRABALHADAS EM VARIAVEIS.
      */
      foreach ($result_usu_horas_totais as $row => $all_dados) {
        $hex_usu_horas_totais = $all_dados["Horas_Extras"];
        $htrab_usu_horas_totais = $all_dados["Horas_Trabalhadas"];
        $folgas_usu_horas_totais = $all_dados["Folgas"];
        $direitoF_usu_horas_totais = $all_dados["Direito_Folga"];
        $Ano_usu_horas_totais = $all_dados["Ano"];
      }

      $HORAS = checkExtraHour($id, $hex_usu_horas_totais, $htrab_usu_horas_totais );
      /*SQL PARA INSERIR AS HORAS PARA O MÊS ATUAL.
      */
      // echo "Horas extras";
      // var_dump($hex);
      // echo "\n";
      $sql = "INSERT INTO usu_horas_totais(id_usu_horas_totais, usuario_id, Mes, Horas_Trabalhadas, Horas_Extras, Folgas, Direito_Folga, Ano)
      VALUES ('',:usuario_id, :Mes,:Horas_Trabalhadas, :Horas_Extras, :Folgas, :Direito_Folga, :Ano)";

      $stmtNM = $GLOBALS['Conexao']->PDO->prepare( $sql );

      $stmtNM->bindParam( ':usuario_id', $id);
      $stmtNM->bindParam( ':Mes', $mes);
      $stmtNM->bindParam( ':Horas_Trabalhadas', $HORAS['horas_totais']);
      $stmtNM->bindParam( ':Horas_Extras', $HORAS['extras']);
      $stmtNM->bindParam( ':Folgas', $folgas);
      $stmtNM->bindParam( ':Direito_Folga', $direitoF);
      $stmtNM->bindParam( ':Ano', $ano);

      $result = $stmtNM->execute();

      if (!$result) {
        problema($id);
        exit;
      }
    }/*CASO ELE POSSUA HORAS CADASTRADAS
    // A CONDIÇÃO SERÁ ESTA.*/else {

    foreach ($result_usu_horas_totais as $row => $all_teste) {
      $hex_usu_horas_totais = $all_teste["Horas_Extras"];
      $htrab_usu_horas_totais = $all_teste["Horas_Trabalhadas"];
      $folgas_usu_horas_totais = $all_teste["Folgas"];
      $direitoF_usu_horas_totais = $all_teste["Direito_Folga"];
      $ano_usu_horas_totais = $all_teste["Ano"];
    }

    $HORAS = checkExtraHour($id, $hex_usu_horas_totais, $htrab_usu_horas_totais );

    $sql = "UPDATE usu_horas_totais SET  Horas_Trabalhadas = :Horas_Trabalhadas, Horas_Extras = :Horas_Extras WHERE usuario_id = $id AND Ano = $ano AND Mes = $mes";

    $stmtNM = $GLOBALS['Conexao']->PDO->prepare( $sql );
    $stmtNM->bindParam( ':Horas_Trabalhadas', $HORAS['horas_totais']);
    $stmtNM->bindParam( ':Horas_Extras', $HORAS['extras']);

    $result = $stmtNM->execute();
  }
    if (!$result) {
      problema($id);
      exit;
    }
  }

  function checkExtraHour ($id, $horas_extras_usu_totais, $horas_trab_usu_totais) {

    $horas_extras_usu_totais_segundos = time_to_sec($horas_extras_usu_totais);
    $horas_trab_usu_totais_segundos = time_to_sec($horas_trab_usu_totais);

    $hour_Extra_Limit_Dia_segundos = 14400;//<- 4h carga horária normal por dia.
    $hour_Extra_Limit_Total_segundos = 57600;//<- 16h horas extra limite por pessoa. //alterar

    $sql_Diferenca_Entre_Horas = "SELECT TIMEDIFF((SELECT Hora_Ponto FROM usu_ponto WHERE usuario_id = $id AND Data_Ponto = DATE_FORMAT(NOW(),'%d-%m-%Y') AND Situacao = 0), (SELECT Hora_Ponto FROM usu_ponto WHERE usuario_id = $id AND Data_Ponto = DATE_FORMAT(NOW(),'%d-%m-%Y') AND Situacao = 1))";
    $stmt_Diferenca_Entre_Horas = $GLOBALS['Conexao']->PDO->prepare( $sql_Diferenca_Entre_Horas );
    $stmt_Diferenca_Entre_Horas->execute();
    $result_Diferenca_Entre_Horas = $stmt_Diferenca_Entre_Horas->fetchAll();
    $time_Diff = "";

    foreach ($result_Diferenca_Entre_Horas as $row => $time_Diff) {
      $time_Diff[0];
    }

    //TODO:PODE DAR ERRO QUANDO O SISTEMA FOR CONSULTAR A DIFERENÇA ENTRE A ENTRADA E A SAIDA, POR MOTIVO DE SEGURANÇÃ TRATAR ESSE ERRO.
    $time_Diff = $time_Diff[0];
    $time_Diff_to_segundos = time_to_sec($time_Diff);//convertendo uma string '00:00:00' em segundos.
    // echo "Diferença entre horas segundos";
    // var_dump($timeDiff);
    /*CALCÚLO DAS HORAS EXTRAS TRABALHADAS POR DIA (hex + hexTrabPorDia),
    CADA BOLSISTA TRABALHA 4h POR DIA, A CARGA HORÁRIA EXCEDENTE
    SERÁ ACRESCENTADO AO SEU BANCO DE HORAS, PORÉM CADA BOLSISTA PODERÁ
    ARMAZENAR SOMENTE 16h.
    *///TODO: Criar uma variável global para base de subtração que é 4h, atualmente.

    if ($time_Diff_to_segundos > $hour_Extra_Limit_Dia_segundos) {

      $hora_extra_diferenca_segundos = ($time_Diff_to_segundos - $hour_Extra_Limit_Dia_segundos);//<-DIFERENÇA ENTRE HORAS, SALDO POSITIVO.
      $horas_extras_usu_totais_segundos = $horas_extras_usu_totais_segundos + $hora_extra_diferenca_segundos;//<-SOMA DA DIFERENÇA POSITIVA MAIS O ACUMULADO.
      $horas_trab_usu_totais_segundos = ($horas_trab_usu_totais_segundos + $time_Diff_to_segundos);

    } else {
      $hora_extra_diferenca_segundos = 0;
      $horas_trab_usu_totais_segundos = ($horas_trab_usu_totais_segundos + $time_Diff_to_segundos);
    }


    if ($horas_extras_usu_totais_segundos >= $hour_Extra_Limit_Total_segundos) {
      /*O EXPEDIENTE NORMAL REFERE A 4:00H TRABALHADAS.
      O EXPEDIENTE DO BOLSISTA PODE SOFRER ALTERAÇÕES, CASO SEJA NECESSÁRIO.
      TODO: SE NECESSÁRIO ALTERAR ESTA FUNÇÃO PARA ACRECENTAR EXATAMENTE A HORA QUE O
      BOLSISTA TRABALHOU: data: 04/01/2017 ESTOU TRABALHANDOP NISSO 14/02/2017.
      */
      echo "<script>alert('HORAS EXTRAS EXEDIDAS PARA O MÊS TOTAL 16h !');</script>";
      echo "<script>window.location = 'bolsistas.php';</script>";
      /*DESSA FORMA O USUÁRIO NÃO EXCEDERÁ O LIMITE DE HORAS EXTRAS E
      SEMPRE TERÁ 16:00:00 CADASTRADAS.
      */
      $horas_extras_usu_totais_segundos = $hour_Extra_Limit_Total_segundos;
      }

      $HORAS['extras'] = $horas_extras_usu_totais_horas = sec_to_time($horas_extras_usu_totais_segundos);
      $HORAS['horas_totais'] = $horas_trab_usu_totais_horas = sec_to_time($horas_trab_usu_totais_segundos);

      return $HORAS;
  }

  /*ESTA FUNÇÃO RETORNARÁ UMA FALHA PARA CASO O PONDO DO FUNCIONÁRIO NÃO SEJA
      INSERIDO NO BANCO COM EXITO.
  */
  function problema () {
    echo "<script>alert('ERRO AO MARCAR PONTO !');</script>";
    echo "<script>window.location = 'bolsistas.php';</script>";
    exit;
  }

  function checkPoinEnter ($id) {

    $sql_consulta_ponto_ja_inserido = "SELECT * FROM usu_ponto WHERE usuario_id = $id AND Data_Ponto = DATE_FORMAT(NOW(), '%d-%m-%Y') AND Situacao = 1";
    $stmt_consulta_ponto_ja_inserido = $GLOBALS['Conexao']->PDO->prepare( $sql_consulta_ponto_ja_inserido );
    $stmt_consulta_ponto_ja_inserido->execute();
    $result_consulta_ponto_ja_inserido = $stmt_consulta_ponto_ja_inserido->fetchAll();

    if (empty($result_consulta_ponto_ja_inserido)) {
      echo "<script>alert('PONTO MARCADO ENTER!');</script>";
    } else {
      echo "<script>alert('VOCÊ JÁ MARCOU SEU PONTO HOJE !');</script>";
      echo "<script>window.location = 'bolsistas.php';</script>";
      exit;
    }

  }

  function checkPoinExit ($id) {

    $sql_consulta_ponto_ja_inserido = "SELECT * FROM usu_ponto WHERE usuario_id = $id AND Data_Ponto = DATE_FORMAT(NOW(), '%d-%m-%Y') AND Situacao = 0";
    $stmt_consulta_ponto_ja_inserido = $GLOBALS['Conexao']->PDO->prepare( $sql_consulta_ponto_ja_inserido );
    $stmt_consulta_ponto_ja_inserido->execute();
    $result_consulta_ponto_ja_inserido = $stmt_consulta_ponto_ja_inserido->fetchAll();

    if (empty($result_consulta_ponto_ja_inserido)) {
      echo "<script>alert('PONTO MARCADO EXIT!');</script>";
    } else {
      echo "<script>alert('VOCÊ NÃO PODE MARCAR MAIS PONTO DE SAIDA PARA HOJE !');</script>";
      echo "<script>window.location = 'bolsistas.php';</script>";
      exit;
    }
  }
  /*CONVERTE UMA STRING NO FORMATO '00:00:00' EM SEGUNDOS.
  */
  function time_to_sec($time) {
  	$hours = substr($time, 0, -6);
  	$minutes = substr($time, -5, 2);
  	$seconds = substr($time, -2);

  	return $hours * 3600 + $minutes * 60 + $seconds;
  }
  /*CONVERTE UMA STRING DE INTEIRO EM HORAS NO FORMATO '00:00:00'
  */
  function sec_to_time($seconds) {
  	$hours = floor($seconds / 3600);
  	$minutes = floor($seconds % 3600 / 60);
  	$seconds = $seconds % 60;

  	return sprintf("%d:%02d:%02d", $hours, $minutes, $seconds);
  }

?>
