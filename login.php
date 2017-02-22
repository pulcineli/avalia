<?php
// obtem os valores digitados
$username = $_POST["username"];
$senha = $_POST["password"];
header("Content-type: text/html; charset=utf-8");
include "includes/conecta_mysql.php";

?>
<html>
  
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset=UTF-8">
  </head>  
  
  <body>

<?php

$resultado = mysqli_query($con, "SELECT * FROM usuarios where username='$username'");
$linhas = mysqli_num_rows ($resultado);
if($linhas==0)  // testa se a consulta retornou algum registro
{
	echo "<p align=\"center\">Usu&aacute;rio <b>$username</b> n&atilde;o encontrado.</p>";
	echo "<p align=\"center\"><a href=\"index.html\">Voltar</a></p>";
	
}
else
{
	$dados = mysqli_fetch_array($resultado);
	$senha_banco = $dados["senha"];
        $nome = $dados["nome"];
	$unidade = $dados["gestor"];
        
        if ($senha != $senha_banco) // confere senha
	{
		echo "<p align=\"center\">A senha est&aacute; incorreta!</p>";
		echo "<p align=\"center\"><a href=\"index.html\">Voltar</a></p>";
		
	}
	else   // usuario e senha corretos. Vamos criar os cookies
    {
	session_start();
        header("Content-type: text/html; charset=utf-8");
        $_SESSION['nome_usuario'] = $username;
        $_SESSION['senha_usuario'] = $senha;
        $_SESSION['full_name'] = $nome;
        $_SESSION['unidade_gestor'] = $unidade;
        // direciona para a pagina inicial dos usuarios cadastrados
        if ($username=='admin'){
            header ("Location: admin.php");
        }else{
            header ("Location: seleciona_servidor.php");
        }
    }
}
mysqli_close($con);
?>

  </body>
</html>