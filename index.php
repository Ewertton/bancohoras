<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title> Ponto EAJ-GTI </title>

        <link href="css/bootstrap.min.css" rel="stylesheet">
    <?
    if (isset($_GET["erro"])=1) {
    ?>
     <script LANGUAGE="JavaScript" TYPE="text/javascript">
       alert ("ENTRE COM LOGIN E SENHA VÁLIDA")
     </script>
    <?
    }
    ?>
  </head>
  <body>
    
    <?php include 'header.php';?>

      <hgroup id="logon">
        <div class="container-fluid">
          <div style="text-align: center">
          <br>
            <!--<img src="imagens/EAJ_LOGO.png" width="100"><img src="imagens/GTI_LOGO_TRANS.png" width="100">-->
              <form class="form-inline" name="logar" method="post" action="autenticacao.php">
                  <h2> Controle de Ponto </h2>
                  <input type="text" class="form-control" name="login" placeholder="Usuário" required=""> &nbsp;
                  <input type="password" class="form-control" name="senha" placeholder="Senha" required="">
                  <input name="id" type="hidden" value="2"/>
                  <input class="btn btn-sm btn-success" type="submit"></font></>
              </form><br/>
              <h8>Caso não possua um cadastro no controle de ponto GTI faça um clicando em, <a href='cadastro.php'>cadastre-se</a>.<h8>
            <br><br>
          </div>
        </div>
      </hgroup>
          <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
          <!-- Include all compiled plugins (below), or include individual files as needed -->
          <script src="js/bootstrap.min.js"></script>
    </div>
  </body>
</html>
