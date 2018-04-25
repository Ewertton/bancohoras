<html>
<head>
<?php
session_start(); //Inicia a cessão
//TODO: Mudar esssea session para o cargo do usuário questão de segurança
$_SESSION['Login'];
//TODO: Mudar essa session para o ID do usuário, questão de segurança
$_SESSION['Senha'];

$login = $_SESSION['Login'];
$senha = $_SESSION['Senha'];
?>
<!--Hora atual no monitor javascript-->
<script type="text/javascript">
  function startTime() {
    var today=new Date();
    var h=today.getHours();
    var m=today.getMinutes();
    var s=today.getSeconds();
    // add a zero in front of numbers<10
    m=checkTime(m);
    s=checkTime(s);
    var hora = document.getElementById('txt').innerHTML=h+":"+m+":"+s;
    t=setTimeout('startTime()',500);
  }

  function checkTime(i){
   if (i<10) {
       i="0" + i;
     }
    return i;
  }
  </script>
  <h1><script></script></h1>
</head>

<body onload="startTime()">
<!--HORA DO COMPUTADOR-->
<h1><div id="txt"></div></h1>
<h1>Administrador</h1>

<?php
  include_once("conexao.class.php");
  include_once("GerarHora.php");

  $hora = new GerarHora();
  $hora = $hora->HoraAtual();
  //echo $hora;

  $Obj = new Conexao();

  $dados['senha'] = $senha;
  $dados['login'] = $login;

  $all_users = $Obj->ConsultAllUsers();

  $all_users_Active = $Obj->ConsultAllUsersActive();

  echo "<h4>USUÁRIOS ATIVOS<h4>";
  echo $all_users_Active;

  echo "<h4>TODOS OS USUÁRIOS<h4>";
  echo $all_users;
  /*WHILE MOSTRA TODAS AS INFORMAÇÕES DOS USUÁRIOS.
  */

  // while ($linha = $all_users->fetch(PDO::FETCH_ASSOC)) {
  //   // aqui eu mostro os valores de minha consulta
  //   $dados = $Obj->ConsultaHora("{$linha['id']}");
  //
  //
  //
  //   echo "{$linha['id']}  {$linha['Nome']} ";
  //
  //
  //
  // }
  /*Se você tiver um loop para exibir os dados ele deve ficar aqui*/
?>

</body>
</html>
