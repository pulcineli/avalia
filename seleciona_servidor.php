<?php
include 'includes/valida_sessao.php';
include 'includes/conecta_mysql_1.php';
?>
<html>
  
  <head>
    <meta http-equiv="Content-Type" content="text/html" charset=UTF-8">
    <!-- Start of the headers for CoffeeCup Web Form Builder -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"
    />
   <!-- <script type="text/javascript" src="common/js/form_init.js" data-name=""
    id="form_init_script">
    </script>-->
    <script type="text/javascript" src="common/js/valida_seleciona_servidor.js" data-name=""
    id="form_valida_script">
    </script>
    <link rel="stylesheet" type="text/css" href="theme/transparent/css/default.css?version=634"
    id="theme" />
    <!-- End of the headers for CoffeeCup Web Form Builder -->
    <title>
      seleciona servidor
    </title>
    
    
    
    
  </head>
  
  <body><!-- Start of the body content for CoffeeCup Web Form Builder -->
  <?php header("Content-type: text/html; charset=utf-8"); ?>

      <p><a align="left" href="logout.php">Sair</a></p>
      
<style>#docContainer .fb_cond_applied{ display:none; }</style><noscript><style>#docContainer .fb_cond_applied{ display:inline-block; }</style></noscript><form name="form_seleciona" class="fb-toplabel fb-100-item-column selected-object" id="docContainer"
style="margin: 0px; width: 960px;" action="avalia_servidor.php" enctype="multipart/form-data" method="POST" novalidate="novalidate" data-form="manual_iframe" data-margin="custom" onsubmit="return valida()">
    
    
    
        <div class="section" id="section1">
    <div class="column ui-sortable" id="column1">
      <div id="fb_confirm_inline" style="display: none; min-height: 200px;">
      </div>
      <div id="fb_error_report" style="display: none;">
      </div>
      <div class="fb-item fb-100-item-column" id="item3" style="opacity: 1;">
        <div class="fb-header">
          <h2 style="display: inline;">
            Sistema Experimental de Avali&ccedil;&atilde;o dos Servidores
          </h2>
        </div>
      </div>
      <div class="fb-item fb-100-item-column" id="item13" style="opacity: 1;">
        <div class="fb-static-text">
          <p style= "font-weight: normal;">
            <?php
               header("Content-type: text/html; charset=utf-8");
               echo "Nome do Avaliador - $full_name" ;
               echo "<p> Gestor da $unidade_gestor</p>";
            ?>            
          </p>
        </div>
      </div>
      <div class="fb-item fb-100-item-column" id="item4" style="opacity: 1;">
        <div class="fb-static-text">
          <p style="font-weight: normal">
            Escolha o servidor a ser avaliado
          </p>
        </div>
      </div>
      <div class="fb-item fb-100-item-column fb-one-column" id="item12">
        <div class="fb-grouplabel">
          <label id="item12_label_0" style="display: inline;">Servidores ainda n&atilde;o avalidos</label>
        </div>
        <div class="fb-radio">
          <?php
          header("Content-type: text/html; charset=utf-8");
          
          $query='SELECT * FROM servidores where '.$unidade_gestor.' = "0" ORDER BY full_name ASC';
          //echo $query;
          $resultado = $conecta->query($query) OR trigger_error($conecta->error, E_USER_ERROR);
          if ($resultado-> num_rows == 0){
               echo "<h2 align='center'> N&atilde;o h&aacute; mais servidores a serem avaliados por voc&ecirc;</h2>";
               exit;    
          }else{ 
               $label=0;
               while ($servidor = $resultado->fetch_object()){
                   $full_name = $servidor->full_name;
                   $codigo = $servidor->codigo;
                   echo "<label id=\"item12_".$label."_label\"><input name=\"servidor_avaliado\" id=\"item12_".$label."_radio\" type=\"radio\" value=\"$codigo\" /><span class=\"fb-fieldlabel\" id=\"item12_".$label."_span\">$full_name</span></label>";
                   ++$label;        
                }     

                $resultado->free();
          }
           mysqli_close($conecta); 
	          
        ?>
        </div>
      </div>
    </div>
  </div>
    
  
    
  <div class="fb-footer fb-item-alignment-center" id="fb-submit-button-div"
  style="min-height: 0px;">
   <!-- <input class="fb-button-special non-standard" id="fb-submit-button" style="border-width: 2px; padding-right: 6px; font-family: sans-serif; background-image: -ms-linear-gradient(rgb(236, 236, 236), rgb(213, 213, 213)); background-color: rgb(235, 235, 235);"
           type="submit" data-regular="" value="Iniciar Avali&ccedil;&atilde;o" />-->
      <button> Iniciar Avali&ccedil;&atilde;o </button> 
  </div>
    
  
  </form>
<!-- End of the body content for CoffeeCup Web Form Builder -->
</body>
</html>