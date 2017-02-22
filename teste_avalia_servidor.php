<?php
include "includes/valida_sessao.php";
include "includes/conecta_mysql_1.php";
$codigo_servidor = $_POST["servidor_avaliado"];
  
?>

<html>
  
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Start of the headers for CoffeeCup Web Form Builder -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"
    />
    <title>
      avalia servidor
    </title>
  
  </head>
  
  <body>


<?php

//echo "<h2>$codigo_servidor</h2>";

          $query='SELECT * FROM servidores where codigo="'.$codigo_servidor.'"';
          //echo $query;
          $resultado = $conecta->query($query) OR trigger_error($conecta->error, E_USER_ERROR);
          $post_trab=$resultado->fetch_object();
          
          $posto_trabalho=$post_trab->posto_trabalho;
          $full_name=$post_trab->full_name;
          //echo "<p>$posto_trabalho <p> $full_name<p>";
                  
          $query='SELECT * FROM competencia WHERE posto_trabalho LIKE \'%'.$posto_trabalho.'%\'';
          //echo $query;
          $resultado = $conecta->query($query) OR trigger_error($conecta->error, E_USER_ERROR);
                 
              while ($competencia= $resultado->fetch_object()) {
                $nome_comp = $competencia->competencia;
                echo "<h3>$nome_comp";
                
                }     

              
          //}        
                  
         
          $resultado->free();
          mysqli_close($conecta); 
?>

  </body>
</html>



