<?php
  include_once("conexao.class.php");

  $Obj = new Conexao();

  $_consulta["login"] = $_POST["login"];
  $_consulta["senha"] = $_POST["senha"];

  //FILTRO DE FORMULÁRIOS__

  //FORMULÁRIO DE CADASTRO O CÓDIGO ABAIXO SERÁ EXECUTADO
  if($_POST['id'] == "1"){
    //TODO-13/10/16 - AUTENTICAR O CADASTRO E INSERIR OS DADOS NO BAMCO
    //DADOS DO CADASTRO
    //TODO - 13/10/16 - TRATAMENTO DE VARIÁVEIS VAZIAS
    $dados['email'] = $_POST['email'];
    $dados['telefone'] = $_POST['fone'];
    $dados['cargo'] = $_POST['cargo'];
    $dados['nome'] = $_POST['nome'];
    $dados['login'] = $_POST['login'];
    $senha = $_POST['senha'];
    $dados['turno'] = $_POST['turno'];
    $dados['senha'] = md5($senha);

    /*VERIFICA SE O USUÁRIO ESTÁ TENTANDO SE CADASTRAR COM UM LOGIN JÁ EXISTENTE.
    */
    $checkLogin = $Obj->CheckLogin($dados['login']);

    if ($checkLogin == 0) {
      echo "<script>alert('POR FAVOR ESCOLHA OUTRO LOGIN !');
      history.back();
      </script>";
      exit;
    }else{
      echo "<script>alert('USUÁRIO CADASTRADO CO SUCESSO !');</script>";
      $Obj->Inserir($dados);
    }
  }

  //FORMULÁRIO DE LOGIN O CÓDIO ABAIXO SERÁ EXECUTADO
  if($_POST['id'] == "2"){

    //DADOS DE ACESSO DO USUÁRIO
    $dados['login'] = $_POST['login'];
    $dados['senha'] = md5($_POST['senha']);

    $usuario = $Obj->Consulta($dados);

    //echo $usuario['Nome'];
    //CASO HOUVER AUGUM USUÁRIO COM ESSAS INFORMAÇÕES NO BANCO  SERÁ INICIADA UMA CESSÃO
    if($usuario != "" || $usuario != NULL){

      //FILTRO PARA SABER SE O USUÁRIO É UM ADM OU UM USUÁRIO COMUN
      if ($usuario['Cargo'] == "b" || $usuario['Cargo'] == "bolsista" || $usuario['Cargo'] == "BOLSSITA" || $usuario['Cargo'] == "Bolssista") {
        session_start();

        $_SESSION['Login'] = $dados['login'];
        $_SESSION['Senha'] = $dados['senha'];

        header("location: bolsistas.php");
      } else if ($usuario['Cargo'] == "a" || $usuario['Cargo'] == "administrados" || $usuario['Cargo'] == "Administrados" || $usuario['Cargo'] == "ADM" || $usuario['Cargo'] == "adm" || $usuario['Cargo'] == "Adm") {
        session_start();

        $_SESSION['Login'] = $dados['login'];
        $_SESSION['Senha'] = $dados['senha'];

        header("location: admin.php");
      } else if ($usuario['Estagiario'] == "e" || $usuario['Cargo'] == "estagiario" || $usuario['Cargo'] == "Estagiario") {
        session_start();

        $_SESSION['Login'] = $dados['login'];
        $_SESSION['Senha'] = $dados['senha'];

        header("location: bolsistas.php");
      }
       else{
        //header("location: admin.php");
        echo "<script>alert('PROBLEMA COM SEU CADASTRO! -> entre em contato com o administrados <-');</script>";
        header("location: index.php?erro=1");
      }
    }else{
      echo "<script>alert('USUÁRIO NÃO ENCONTRADO !');</script>";
      header("location: index.php?erro=1");
      //header("HTTP/1.0 404 Not Found");
    }
  }
?>
