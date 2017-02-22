<?php

 //PARA AVALIAR
 // $codigoProduto = filter_input(INPUT_GET, 'identProduto1');
 //$nomeProduto = filter_input(INPUT_GET, 'nomeProduto1');
  

include "includes/valida_sessao.php";
include "includes/conecta_mysql_1.php";
include "includes/config.inc.php";



$avaliado_posto_trabalho = $_POST["avaliado_posto_trabalho"];
$codigo_servidor_avaliado = $_POST["codigo_servidor_avaliado"];
$unidade_gestor = strtolower($unidade_gestor);


//pega nome
$query='SELECT * FROM servidores WHERE codigo=\''.$codigo_servidor_avaliado.'\'';
$resultado_servidor = $conecta->query($query) OR trigger_error($conecta->error, E_USER_ERROR);
$servidor = $resultado_servidor->fetch_object();
$avaliado_full_name = $servidor->full_name;
$date = date('Y-m-d H:i:sa');
$codigo_gestor = $nome_usuario;



    $query='SELECT * FROM competencia WHERE posto_trabalho LIKE \'%'.$avaliado_posto_trabalho.'%\'';
    $resultado = $conecta->query($query) OR trigger_error($conecta->error, E_USER_ERROR);
    echo "<p>Resultado para <b>$avaliado_full_name</b>";    
    while($competencia= $resultado->fetch_object()) {
            $comp_id = $competencia->id;
            $comp_name = $competencia->competencia;
            
            if(IsSet($_POST["$comp_id"])){
            
                $result_avalia = $_POST["$comp_id"];
                echo "<p> $comp_name: $result_avalia";
                            
                //Grava no banco informacoes sobre resultado
                $sql_insert = "INSERT INTO resultado (codigo, id_comp, result_comp, periodo_avalia, cod_avaliador, posto_trabalho, datatime_avaliacao) VALUES (?,?,?,?,?,?,?)";
                $statement = $conecta->prepare($sql_insert);
                
                //bind parameters for markers, where (s = string, i = integer, d = double,  b = blob)
                $statement->bind_param('siissss',$codigo_servidor_avaliado, $comp_id, $result_avalia, $periodo_avalia, $codigo_gestor, $avaliado_posto_trabalho, $date);

                if($statement->execute()){
                    $statement->insert_id ;
                }else{
                    die('Error : ('. $conecta->errno .') '. $conecta->error);
                }
                $statement->close();
                
                
                //Atualzia status do servidor
                
                                
                }
             


                
                
                                        
            }
                $sql_update = "UPDATE `servidores` SET `".$unidade_gestor."` = '1' WHERE `servidores`.`codigo` = '".$codigo_servidor_avaliado."'";
                //echo "<p> ".$sql_update."";
                if (!mysqli_query($conecta, $sql_update)){
                    echo "<p>";
                    die('Error : ('. $conecta->errno .') '. $conecta->error);
                }
            
            
            
        
            
        
        //        $nome_comp = $competencia->competencia;
          //      $comp_id = $competencia->id;


//echo $comp_id;
  //              $resultado_3 = $conecta->query("SELECT competecia FROM competencia WHERE id=\"".$comp_id."\"") OR trigger_error($conecta->error, E_USER_ERROR);




echo "<p><a href=\"seleciona_servidor.php\">Avaliar outro servidor</a> ";
echo "<p><a href=\"logout.php\">Sair</a>";




?>