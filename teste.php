<hgroup id="logon">
    <div class="container-fluid">
      <div style="text-align: center">
        <br>
        <img src="imagens/EAJ_LOGO.png" width="100"><img src="imagens/GTI_LOGO_TRANS.png" width="100">
        <header>
          <h2>Login</h2>
        </header>
        <section class="body">
         <form method="post" action="autenticacao.php">
          <div class="form-group">
            <div class="col-sm-25">
              <input type="email" class="form-control" id="email" style="width:300px;" placeholder="Login">
            </div>
            <div class="col-sm-25">
              <label>Senha</label>
              <input name="senha" type="senha" placeholder="Sua senha">
            </div>
            <div class="col-sm-25">
              <label>Nome</label>
              <input name="nome" placeholder="login">
            </div>
            <div class="col-sm-25">
              <label>Cargo</label>
              <input name="cargo" placeholder="login">
            </div>
            <div class="col-sm-25">
              <label>Telefone</label>
              <input name="fone" placeholder="login">
            </div>
            <div class="col-sm-25">
              <label>Email</label>
              <input name="email" placeholder="login">
              <div class="col-sm-30">
                <input type="email" class="form-control" id="email" placeholder="Enter email">
              </div>
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
      </div>
    </div>
  </hgroup> 