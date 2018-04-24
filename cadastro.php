<html>
 <head>
 <title>Banco de horas</title>
 <meta name="description" content="Como usar as tags header, footer e article em HTML5">
 <meta charset="utf-8">
 <link rel="stylesheet" type="text/css" href="estilo.css"/>

</head>
<body>
<header>
  <h2>Login</h2>
</header>
<section class="body">
  <form method="post" action="autenticacao.php">
    <div>
    <label>Login</label>
      <input name="login" placeholder="login">
    </div>
    <div>
    <label>Senha</label>
      <input name="senha" type="senha" placeholder="Sua senha">
    </div>
    <div>
    <label>Nome</label>
      <input name="nome" placeholder="login">
    </div>
    <div>
    <label>Cargo</label>
      <input name="cargo" placeholder="login">
    </div>
    <div>
    <label>Telefone</label>
      <input name="fone" placeholder="login">
    </div>
    <div>
    <label>Email</label>
      <input name="email" placeholder="login">
    </div>
    <div>
    <label>Turno</label>
      <input name="turno" placeholder="Turno">
    </div>
      <input name="id" type="hidden" value="1"/>
    <input name="submit" type="submit">
  </form>
</section>
<footer>
  <p>Todos os direitos reservados. GTI - EAJ</p>
</footer>
</body>
</html>
