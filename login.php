<?php
include_once("conexao.php");

// session_start inicia a sessão
session_start();
// as variáveis login e senha recebem os dados digitados na página anterior
$login = $_POST['login'];
$senha = $_POST['senha'];

$_SESSION['login'] = $login;
$_SESSION['senha'] = $senha;

//echo $_SESSION['login'];
//echo $_SESSION['senha'];

// A vriavel $result pega as varias $login e $senha, faz uma pesquisa na tabela de usuarios
//$result = mysql_query("SELECT * FROM 'Usuarios' WHERE 'Login' = '$login' AND 'senha'= '$senha'");
$result = mysql_query("SELECT * FROM 'Usuarios'");

/* Logo abaixo temos um bloco com if e else, verificando se a variável $result foi bem sucedida, ou seja se ela estiver encontrado algum registro idêntico o seu valor será igual a 1, se não, se não tiver registros seu valor será 0. Dependendo do resultado ele redirecionará para a pagina site.php ou retornara  para a pagina do formulário inicial para que se possa tentar novamente realizar o login */

//$dados= mysql_fetch_array($result);
//$contagem = mysql_num_rows($result);

//echo $dados;

if(mysql_num_rows ($result) > 0 ) {
//$_SESSION['login'] = $login;
//$_SESSION['senha'] = $senha;

echo $result;
//header('location:ponto.php');

} else {
	unset ($_SESSION['login']);
	unset ($_SESSION['senha']);
	//header('location:index.html');
}

?>
