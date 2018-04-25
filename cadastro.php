<html>
<head>
	<title>Banco de horas</title>
	<meta name="description" content="Como usar as tags header, footer e article em HTML5">
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="estilo.css"/>

</head>
<body>
	<?php include 'header.php';?>   
	<hgroup id="logon">
		<div class="container-fluid">
			<div>
				<br>
				
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<div class="col-md-10">
						<h1 class="page-header">Novo Usuário</h1>
					</div>

					<div class="col-md-12"> 
					<!-- ################## FORMULÁRIO DE CADASTRO ######################################################################## -->
						<form method="post" action="autenticacao.php">
							<div class="form-group" style="width:300px;" >
								<label>Login</label>
								<input name="login" class="form-control" placeholder="Login">
								<small id="login" class="form-text text-muted">We'll never share your password with anyone else.</small>
							</div>

							<div class="form-group" style="width:300px;" >
								<label for="exampleInputPassword1">Password</label>
								<input name="senha" class="form-control" type="password" placeholder="Senha">
								<small id="password" class="form-text text-muted">We'll never share your password with anyone else.</small>
							</div>

							<div class="form-group" style="width:300px;" >
								<label for="name">Nome</label>
								<input name="nome" class="form-control" placeholder="Nome">
							</div>

							<div class="form-group" >
								<label for="cargo">Cargo</label>
								<select style="width:300px;" name="cargo" class="form-control">
									<option value="bolsista">Bolsista</option>
									<option value="estagiario">Estagiario</option>
									<option value="admin">Administrador</option>
								</select>
							</div>

							<div class="form-group" style="width:300px;" >
								<label for="telefone">Telefone</label>
								<input name="fone" class="form-control" placeholder="telefone">
							</div>

							<div class="form-group" style="width:300px;" >
								<label for="exampleInputEmail1">Email address</label>
								<input name="email" class="form-control" placeholder="Email">
							</div>
							<!-- ########################################################################################## -->
							<div class="form-group" style="width:300px;" >
								<label for="turno">Turno</label>
								<select style="width:300px;" name="turno" class="form-control">
									<option>Selecione</option>
									<option>Matutino</option>
									<option>Vespertino</option>
									<option>Noturno</option>
								</select>
							</div>
							<!-- ########################################################################################## -->
							<div class="form-check">
								<input type="checkbox" class="form-check-input" id="exampleCheck1">
								<label class="form-check-label" for="exampleCheck1">Check me out</label>
							</div>
							<!-- ########################################################################################## -->
							<button type="submit" name="id" value="1" class="btn btn-primary">Submit</button>
							<!--<input name="id" type="hidden" value="1"/>
							<input name="submit" type="submit">-->
						</form>
						<footer>
							<p>Todos os direitos reservados. GTI - EAJ</p>
						</footer>
					</div>
				</div>
			</hgroup> 
		</div>
	</div>
</body>
</html>



<!--<form>
	<div class="form-group">
		<label for="exampleInputEmail1">Email address</label>
		<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
		<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
	</div>
	<div class="form-group">
		<label for="exampleInputPassword1">Password</label>
		<input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
	</div>
	<div class="form-check">
		<input type="checkbox" class="form-check-input" id="exampleCheck1">
		<label class="form-check-label" for="exampleCheck1">Check me out</label>
	</div>
	<button type="submit" class="btn btn-primary">Submit</button>
</form> -->