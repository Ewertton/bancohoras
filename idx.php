<html>
 <head>
 <title>Banco de horas</title>
 <meta name="description">
 <meta charset="utf-8">
 <link rel="stylesheet" type="text/css" href="estilo.css"/>

 <script type="text/javascript">

 </script>
 <?
 if (isset($_GET["erro"])=1) {
 ?>
  <SCRIPT LANGUAGE="JavaScript" TYPE="text/javascript">
    alert ("Preencha todos os campos")
  </SCRIPT>
 <?
 }
 ?>
</head>
 <body>
  <header>
   <h2>Login</h2>
  </header>
  <section class="body">
    <form method="post" action="autenticacao.php">
      <label>Login</label>
      <input name="login" placeholder="login"/>
      <label>Senha</label>
      <input name="senha" type="text" placeholder="Sua senha"/>
      <input name="id" type="hidden" value="2"/>
      <input name="submit" type="submit"/>
    </form>
  </section>
  <footer>
   <p>Todos os direitos reservados. GTI - EAJ</p>
  </footer>

 </body>

</html>
