<html>
<head>

<?php
  include_once 'conexao.class.php';
  include_once 'GerarHora.php';
  //include_once 'inserirPonto.class.php';

  $hora = new GerarHora();
  $hora = $hora->HoraAtual();
  //echo $hora;

  $Obj = new Conexao();

  session_start(); //Inicia a cessão
  //TODO: Mudar esssea session para o cargo do usuário questão de segurança
  $_SESSION['Login'];

  //TODO: Mudar essa session para o ID do usuário, questão de segurança
  $_SESSION['Senha'];

  $dados['login'] = $_SESSION['Login'];
  $dados['senha'] = $_SESSION['Senha'];

  $usuario = $Obj->Consulta($dados);

  /*NOME DO USUÁRIO PARA POR NO CANTO SUPERIOR DIREITO.
  */
  echo "Bolsistas: ";
  echo $usuario['Nome'];
  echo $id = $usuario['id'];
  echo $usuario['Cargo'];
  $all_hours = $Obj->ConsultaBolsi($id);

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

  function checkTime(i) {
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

  <?php
    /*
    *all_hours -> É UMA VARIÁVEL QUE CONTEM UMA TABELA,
    ESSA TABLE COMTEM TODAS AS INFORMAÇÕE COMO BANCO DE HORAS,
    HORAS EXTRAS E OUTRAS INFORMAÇÕES NECESSÁREFERENCIAS.
    */
    echo $all_hours;
    $id = $usuario['id'];
  ?>

  <form method='post' action="inserirPonto.php">
        <input type='hidden' name='id' value=<?php echo $id; ?>>
        <input type='submit' required  name='insert' value='ENTRADA'>
        <input type='submit' required  name='exit' value='SAIDA'>
  </form>


</body>

</html>
