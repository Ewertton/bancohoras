<?php
  $con = mysqli_connect('127.0.0.1','root','','','3306');
  $sql1 = 'CREATE DATABASE `banco_horas_eaj_bolsistas`;';

  //Forneço o ponteiro de conexão $con e o comando SQL vai no segundo parâmetro
  $inserir1 =  mysqli_query($con, $sql1);

  if ($inserir1) {
    echo nl2br("BANCO CRIADO COM --------------------------------------------SUCESSO! \n");
  } else {
    echo nl2br("ERRO AO CRIAR BANCO! \n");
  }

  $sql2 = 'CREATE TABLE `banco_horas_eaj_bolsistas`.`usuario` (
    `id` int(5) NOT NULL AUTO_INCREMENT,
    `Nome` char(50) DEFAULT NULL,
    `Cargo` char(20) DEFAULT NULL,
    `Turno` char(20) DEFAULT NULL,
    `Senha` varchar(200) DEFAULT NULL,
    `Email` char(50) DEFAULT NULL,
    `Telefone` char(10) DEFAULT NULL,
    `Login` varchar(20) NOT NULL,
     PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;';

  //Forneço o ponteiro de conexão $con e o comando SQL vai no segundo parâmetro
  $inserir2 =  mysqli_query($con, $sql2);

  if ($inserir2) {
    echo nl2br("TABELA USUÁRIO CRIADO COM -----------------------------SUCESSO!\n");
  } else {
    echo nl2br("ERRO AO CRIAR TABELA!\n");
  }


  $sql3 = 'CREATE TABLE `banco_horas_eaj_bolsistas`.`usu_horas_totais` (
    `id_usu_horas_totais` int(5) NOT NULL,
    `usuario_id` int(5) NOT NULL,
    `Mes` char(10) DEFAULT NULL,
    `Horas_Trabalhadas` time DEFAULT NULL,
    `Horas_Extras` time DEFAULT NULL,
    `Folgas` int(5) DEFAULT NULL,
    `Direito_Folga` char(2) DEFAULT NULL,
    `Ano` int(5) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;';

  //Forneço o ponteiro de conexão $con e o comando SQL vai no segundo parâmetro
  $inserir3 =  mysqli_query($con, $sql3);

  if ($inserir3) {
    echo nl2br("TABELA USU_HORAS_TOTAIS CRIADO COM -------------SUCESSO! \n");
  } else {
    echo nl2br("ERRO AO CRIAR TABELA!\n");
  }

  $sql4 = 'CREATE TABLE `banco_horas_eaj_bolsistas`.`usu_ponto` (
    `id_usu_ponto` int(5) NOT NULL,
    `usuario_id` int(5) NOT NULL,
    `Data_Ponto` varchar(10) DEFAULT NULL,
    `Hora_Ponto` time DEFAULT NULL,
    `Situacao` char(10) DEFAULT NULL
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1;';

  //Forneço o ponteiro de conexão $con e o comando SQL vai no segundo parâmetro
  $inserir4 =  mysqli_query($con, $sql4);

  if ($inserir4) {
    echo nl2br("TABELA USU_PONTO CRIADO COM -------------------------SUCESSO!\n");
  } else {
    echo nl2br("ERRO AO CRIAR TABELA!\n");
  }

  $sql5 = 'INSERT INTO `banco_horas_eaj_bolsistas`.`usuario` (`id`, `Nome`, `Cargo`, `Turno`, `Senha`, `Email`, `Telefone`, `Login`) VALUES
  ("", "ADMINISTRADOR", "adm", "", "0a2a58cccf143acc6c360e892af6137e", "", "", "administradorEajUFRN"),
  ("", "teste", "b", "", "09151a42659cfc08aff86820f973f640", "", "", "TESTE");';

  //Forneço o ponteiro de conexão $con e o comando SQL vai no segundo parâmetro
  $inserir5 =  mysqli_query($con, $sql5);

  if ($inserir5) {
    echo nl2br("USUÁRIOS FAKE INSERIDOS COM ---------------------------SUCESSO! \n
                Login:  administradorEajUFRN  Senha: administrador123 Cargo: ADMINISTRADOR\n
                Login:  TESTE                   Senha: teste1234   Cargo: BOLSISTA\n
                Vá para para página de login e utilize os usuários acima para testar o software.");
  } else {
    echo nl2br("ERRO AO INSERIR USUÁRIOS FAKE!\n");
  }
?>
