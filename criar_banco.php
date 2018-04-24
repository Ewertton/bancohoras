<?php
  $con = mysqli_connect('127.0.0.1','root','','','3306');

  if(!$con){
      echo "Ops! <br/>";
  }
  else{
    $sqlVerificando = 'SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = "banco_horas_eaj_bolsistas"';

    //Forneço o ponteiro de conexão $con e o comando SQL vai no segundo parâmetro
    $inserir =  mysqli_query($con, $sqlVerificando);

    if ($inserir) {
      echo'<SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
             decisao = confirm("EXISTE UM BANCO DE DADOS NO MySQL COM ESTA INSTANCIA, CONTINUAR APAGARÁ TODOS OS DADOS, DESEJA CONTINUAR?.");
             if (decisao){
             alert ("UM NOVO BANCO SERÁ CRIADO!");
               location.href="banco_de_dados.php";
             } else {
             alert ("VERIFIQUE ERROS DE CONEXÃO COM O MySQL, OU ENTRE EM CONTATO COM O ADMINISTRADOR!");
               location.href="index.php";
             }
             </SCRIPT>';
    } else {
      echo nl2br("NÃO EXISTE BANCO COM ESSE NOME, CRIANDO NOVO!\n");
    }

    // Se conectou posso fazer uma busca por dados.
    //Vejamos um comando SQL para selecionar os dados de nossa tabela.
    $sql = 'DROP DATABASE IF EXISTS `banco_horas_eaj_bolsistas`;';

    //Forneço o ponteiro de conexão $con e o comando SQL vai no segundo parâmetro
    $inserir =  mysqli_query($con, $sql);

    if ($inserir) {
      echo nl2br("BANCO EXCLUIDO COM ----------------------------------------SUCESSO!\n");
    } else {
      echo nl2br("NÃO EXISTE BANCO COM ESSE NOME, CRIANDO NOVO!\n");
    }
  }
?>
