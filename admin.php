<?php
  include "includes/valida_sessao.php";
  include "includes/conecta_mysql_1.php";
  include "includes/functions.php";
  include "includes/config.inc.php";
  
$objetiva  = ( isset($_POST['objetiva']) )  ? "checked" : NULL;


# Visualizando os dados
//var_dump($_POST);


  
  if ($nome_usuario != "admin"){
      echo "<h2 align=\'center\'>Você não possui autoriza&ccedil;ão para acessar essa página";
      exit;
  }  
  
  
  //echo "Logou: $nome_usuario";
  //Zerar pagina
  
  //unset($_GET['avalia']);
  
    ?>
<html>

	<head>
		<title>Admin Page</title>
		<!--<style type="text/css">
			div {
				width: 400px;
				margin: 30px auto;
				border: 1px solid #999;
				padding: 25px;
				border-radius: 7px;
				box-shadow: 2px 2px 3px 1px #999;
			}
		</style>-->
                <script type="text/javascript" src="common/js/confirma_admin.js"> 
                </script>

        </head>
	<body>
            
            <div input align="center">
			<form  action="?avalia=0" method="POST" onsubmit="return confirma()">
				<input id=1 nome="botao" type="submit" value="Recome&ccedil;a Avalia&ccedil;&atilde;o" />
			</form>
                        <form action="?avalia=1" method="POST" onsubmit="return confirma()">
				<input id=2 nome="botao" type="submit" value="Encerra Avalia&ccedil;&atilde;o" />
			</form>
                        <form action="admin.php" method="POST">
                            <input type="checkbox" name="objetiva" value="on" <?php echo $objetiva; ?>> Objetiva
                            <p align="center"><input id=2 nome="botao" type="submit" value="Recalcular" />
                            <p>
			</form>
                    <!--<form action="?avalia=3" method="POST">
				<input id=3 nome="resultado" type="submit" value="Resultado" />
                </form><input type="submit" value="" />-->
		</div>
           
           <p align="center"><a href="logout.php">Logout</a></p>
           
           <?php
		if ( isset( $_GET['avalia']) && ($_GET['avalia'] == 0 OR $_GET['avalia'] == 1 )) {
                    recomeca_avalia($_GET['avalia']);
                    unset($_GET['avalia']);
		}
 
               //Quantidade de avaliadores para calculo da média
                  
                 
                  $sql= "SELECT DISTINCT * FROM `resultado` WHERE `periodo_avalia`='$periodo_avalia'";
                  $busca1 = $conecta->query($sql) OR trigger_error($conecta->error, E_USER_ERROR); 
                  $Existe_avaliacao = $busca1->num_rows;
                                  
                  if($Existe_avaliacao == 0){
                      
                      echo "<p><h2 align=\"center\">Nenhuma Avalia&ccedil;&atilde;o Realizada</h2>";
                      exit;
                      
                  }
 
            ?>
            
            
            
		
             <h2 align="center">Resultado para Avalia&ccedil;&atilde;o <?php echo $periodo_avalia?></h2>
                <!-- <hr>-->
                    <table align="center" cellspacing="3">
                        <tr bgcolor="#d6d6d6">
                        <td><b>Servidor</b></td>
                        <td><b>Posto de Trabalho</b></td>
                        <td><b>Resultado</b></td>
                        <td><b>Fun&ccedil;&atilde;o</b></td>
						<td><b>Avaliadores</b></td>
                     </tr>              
                    
                    
                
                     
               <?php      
               
                                
                  $sql = "SELECT DISTINCT `resultado`.`posto_trabalho`, `resultado`.`codigo`, `servidores`.`full_name` from `resultado`, `servidores` WHERE `resultado`.`codigo` = `servidores`.`codigo` AND `periodo_avalia`='$periodo_avalia'";
                  //echo "<p><b>Pega servidores avaliados:</b> $sql";
                  $busca_codigo = $conecta->query($sql) OR trigger_error($conecta->error, E_USER_ERROR);
                  $codigo = "";
                  while ($fetch_codigo = $busca_codigo->fetch_object()){
                          
                          //echo "<P>i : $i - Funcao : $func[$i]";
                          $valor_resultado = 0;   
                          $codigo = $fetch_codigo->codigo;
                          $full_name = $fetch_codigo->full_name;
                          $posto_trabalho = $fetch_codigo->posto_trabalho;
                          $sql = "SELECT DISTINCT `id_comp` from `resultado` WHERE `codigo` = '$codigo' AND `periodo_avalia` = '$periodo_avalia'";
                          //echo "<p><b>pega competencia para codigo:</b> $sql";
                          $busca_id_comp = $conecta->query($sql) OR trigger_error($conecta->error, E_USER_ERROR);
                          while ($fetch_id_comp = $busca_id_comp->fetch_object()){  
                               $id_comp = $fetch_id_comp->id_comp; 
                               $valor_resultado = $valor_resultado + resultado($id_comp,$codigo);
                               //echo "<p>resultado id_comp $id_comp -> $valor_resultado";
                          }

                               
                          
                          
                          mysqli_free_result($busca_id_comp);
                          
                          if ($objetiva != NULL){
                              $valor_resultado = $valor_resultado + resultado_objetiva($codigo);
                              //echo "<p>Valor da objetiva para <b>$full_name</b>: ".resultado_objetiva($codigo)."";
                              $valor_resultado = number_format($valor_resultado, 2, '.', '.');
                          }else{
                              $valor_resultado = number_format($valor_resultado, 2, '.', '.');
                          }
                          
                          
                          
                          //Insere resultado final no BD
                          
                            $sql = "SELECT * FROM `resultado_final` WHERE `codigo`='$codigo' AND `periodo_avalia` = '$periodo_avalia'";  
                            //echo "<p>$sql";
                            $b_result_final = $conecta->query($sql) OR trigger_error($conecta->error, E_USER_ERROR); 
                            $existe = $b_result_final-> num_rows;                       
                            if ($existe == 0){
                                $sql_insert = "INSERT INTO `resultado_final` (`id`, `codigo`, `resultado_final`, `periodo_avalia`, `full_name`, `posto_trabalho`) VALUES (NULL, '$codigo', '$valor_resultado', '$periodo_avalia' , '$full_name' , '$posto_trabalho')";
                                if (!mysqli_query($conecta, $sql_insert)){
                                    echo "<p>";
                                    die('Error : ('. $conecta->errno .') '. $conecta->error);
                                }
                          
                            }else{
                                $sql_update = "UPDATE `resultado_final` SET `resultado_final` = '$valor_resultado' WHERE `codigo` = '$codigo' AND `periodo_avalia` = '$periodo_avalia'";
                                if (!mysqli_query($conecta, $sql_update)){
                                    echo "<p>";
                                    die('Error : ('. $conecta->errno .') '. $conecta->error);
                                }
                            }
 
         
                     } 
                                       
                      mysqli_free_result($busca_codigo);
                      
                      //Inicia array de funcoes
                            
                      
                      $func[0] = " ";
                      
                      for ($i=0;$i<=$num_servidores;++$i){
                                            
                          switch ($i) {
                              case $i<=$qt_fc4:
                                  $func[$i] = "FC-4";
                              break;
                      
                              case $i<=($qt_fc4+$qt_fc3):
                                  $func[$i] = "FC-3";
                              break;
                      
                              case $i<=($qt_fc4+$qt_fc3+$qt_fc2):
                                  $func[$i] = "FC-2";
                              break;
                          
                              default:
                                  $func[$i] = " ";
                              break;
                          }
                      }
                        
      
          
                      $sql_resultado_final = "SELECT * FROM `resultado_final` WHERE `periodo_avalia`='$periodo_avalia' ORDER BY `resultado_final` DESC";
                      $busca_resultado_final = $conecta->query($sql_resultado_final) OR trigger_error($conecta->error, E_USER_ERROR);
                      $i=1;
                      while ($fetch_resultado_final = $busca_resultado_final->fetch_object()){  
                          $codigo_avaliado = $fetch_resultado_final->codigo;
						  $sql= "SELECT DISTINCT `cod_avaliador` FROM `resultado` WHERE `codigo`='$codigo_avaliado' AND `periodo_avalia`='$periodo_avalia'";
						  $busca1 = $conecta->query($sql) OR trigger_error($conecta->error, E_USER_ERROR); 
                          $Qt_avaliadores = $busca1->num_rows;
						  
						  $full_name = $fetch_resultado_final->full_name;
                          $resultado_final = $fetch_resultado_final->resultado_final;
                          $posto_trabalho = $fetch_resultado_final->posto_trabalho;
                                                        
                          echo "<tr align=\"center\" bgcolor=\"#eeeeee\">";
                          echo "<td align=\"left\">$full_name</td>";
                          echo "<td align=\"center\">$posto_trabalho</td>";
                          echo "<td align=\"center\">$resultado_final</td>";
                          echo "<td align=\"center\">$func[$i]</td>";
						  echo "<td align=\"center\">$Qt_avaliadores</td>";
                          echo "</tr>";
                          $i++;
                               
                      }
                          
                      mysqli_free_result($busca_resultado_final);  
                      
                   
                      
                      
                      
                          
                      
                      
                      
                      
                      
                
                
                //$saida = resultado(1,'c054191');
                //echo "<p><h2 align='center'>$saida</h2>";
                
                          
                      
                ?>
                </table>
           <!-- <hr>-->
                  
           
	</body>

</html>
