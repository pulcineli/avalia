<?php
   include "includes/valida_sessao.php";
   include "includes/conecta_mysql_1.php";
   $codigo_servidor_avaliado = $_POST["servidor_avaliado"];
   
 ?>
<html>
  
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Start of the headers for CoffeeCup Web Form Builder -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"
    />
    <script type="text/javascript" src="common/js/form_init.js" data-name=""
    id="form_init_script">
    </script>
    <link rel="stylesheet" type="text/css" href="theme/transparent/css/default.css?version=814"
    id="theme" />
    <!-- End of the headers for CoffeeCup Web Form Builder -->
    <title>
      avalia_servidor
    </title>
  </head>

<?php
          //Informacoes sobre servidor avaliado
          
          $query='SELECT * FROM servidores where codigo="'.$codigo_servidor_avaliado.'"';
          $resultado = $conecta->query($query) OR trigger_error($conecta->error, E_USER_ERROR);
          $post_trab=$resultado->fetch_object();
          $avaliado_posto_trabalho = $post_trab->posto_trabalho;
          $avaliado_full_name=$post_trab->full_name;
          $resultado->free();
          
          //Dados sobre gestor
          $gestor_full_name = $full_name;
          $gestor_unidade = $unidade_gestor;
        
?>

  
  <body><!-- Start of the body content for CoffeeCup Web Form Builder -->
<style>#docContainer .fb_cond_applied{ display:none; }</style><noscript><style>#docContainer .fb_cond_applied{ display:inline-block; }</style></noscript><form class="fb-toplabel fb-100-item-column selected-object" id="docContainer"
style="margin: 0px; width: 960px;" action="grava_avaliacao.php" enctype="multipart/form-data"
method="POST" novalidate="novalidate" data-margin="custom" data-form="manual_iframe">
  <div class="fb-form-header" id="fb-form-header1">
    <a class="fb-link-logo" id="fb-link-logo1" style="max-width: 104px;" target="_blank"><img title="Alternative text" class="fb-logo" id="fb-logo1" style="width: 100%; display: none;" alt="Alternative text" src="common/images/image_default.png"/></a>
  </div>
  <div class="section" id="section1">
    <div class="column ui-sortable" id="column1">
      <div id="fb_confirm_inline" style="display: none; min-height: 200px;">
      </div>
      <div id="fb_error_report" style="display: none;">
      </div>
      <div class="fb-item fb-100-item-column" id="item3" style="opacity: 1;">
        <div class="fb-header">
          <h2 style="display: inline;">
            Sistema Experimental de Avali&ccedil;&atilde;o dos Servidores da CITEC
          </h2>
        </div>
      </div>
      <div class="fb-item fb-100-item-column" id="item18" style="opacity: 1;">
        <div class="fb-static-text fb-item-alignment-center">
          <p style="color: rgb(20, 19, 20); font-size: 20px;">
            Avalia&ccedil;&atilde;o Subjetiva
          </p>
        </div>
      </div>
      <div class="fb-item fb-100-item-column" id="item13" style="opacity: 1;">
        <div class="fb-static-text">
          <p style="color: rgb(10, 10, 10); font-size: 16px; font-style: normal; font-weight: normal;">
              <b>Avaliador:</b> <?php echo $gestor_full_name;?>
          </p>
        </div>
      </div>
      <div class="fb-item fb-100-item-column" id="item4" style="opacity: 1;">
        <div class="fb-static-text">
          <p style="color: rgb(15, 14, 15); font-size: 16px; font-weight: normal;">
              <b>Servidor Avaliado:</b> <?php echo $avaliado_full_name;?>
          </p>
        </div>
      </div>
        <div class="fb-item fb-100-item-column" id="item04" style="opacity: 1;">
        <div class="fb-static-text">
          <p style="color: rgb(0, 0, 0); font-size: 15px; font-weight: bold;">
              Associa&ccedil;&atilde;o Resquisito -> Numeral
          </p>
          <p style="color: rgb(15, 14, 15); font-size: 13px; font-weight: normal;">
              APRENDIZADO: 1-3
          </p>
          <p style="color: rgb(15, 14, 15); font-size: 13px; font-weight: normal;">
              APLICA&Ccedil;&Atilde;O: 4-6
          </p>
          <p style="color: rgb(15, 14, 15); font-size: 13px; font-weight: normal;">
              AUTONOMIA: 7-9
          </p>
                    <p style="color: rgb(15, 14, 15); font-size: 13px; font-weight: normal;">
              ORIENTA&Ccedil;&Atilde;O: 10-12
          </p>
        
              
        </div>
            
               <hr>
           
      <div class="fb-item fb-100-item-column" id="item20" style="opacity: 1;">
        <div class="fb-static-text fb-item-alignment-center">
               
          <p style="color: rgb(0, 0, 0); font-size: 20px; font-weight: bold;">
              Compet&ecirc;ncias Organizacionais e Espec&iacute;ficas para o posto de trabalho <?php echo $avaliado_posto_trabalho ?>
          </p>
        </div>
      </div>
        
   <?php
   
          $query='SELECT * FROM competencia WHERE posto_trabalho LIKE \'%'.$avaliado_posto_trabalho.'%\'';
          $resultado_2 = $conecta->query($query) OR trigger_error($conecta->error, E_USER_ERROR);
          $item_id=0; 
          
                    
          
              while ($competencia= $resultado_2->fetch_object()) {
                $nome_comp = $competencia->competencia;
                $comp_id = $competencia->id;
                
                //colocar valor esperado do posto de trabalho
          
                $sql = "SELECT DISTINCT `esperado_text` FROM `posto_trabalho` WHERE `unidade`='$avaliado_posto_trabalho' AND `id_competencia`='$comp_id'";
                //echo $sql;
                $resultado_3 = $conecta->query($sql) OR trigger_error($conecta->error, E_USER_ERROR);
                $recebe = $resultado_3->fetch_object();
                $esperado_text = $recebe->esperado_text;
          
          
                //--
                
                
                                  
                echo  "<div class=\"fb-item fb-100-item-column fb-side-by-side\" id=\"item12_$item_id\">";
                echo   "<div class=\"fb-grouplabel\">";
                //echo     "<label id=\"item12_label_$item_id\" style=\"font-size: 14px; display: inline;\">$nome_comp</label>";
                echo     "<label id=\"item12_label_$item_id\" style=\"font-size: 14px; display: inline;\">$nome_comp - $esperado_text</label>";
                echo    "</div>";
                echo "<div class=\"fb-radio fb-item-alignment-center\">";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"1\" /><span class=\"fb-fieldlabel fb-radio\" id=\"item12_".$item_id."_span\">1</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"2\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">2</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"3\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">3</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"4\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">4</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"5\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">5</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"6\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">6</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"7\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">7</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"8\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">8</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"9\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">9</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"10\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">10</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"10\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">11</span></label>";
                echo   "<label id=\"item12_".$item_id."_label\"><input name=\"".$comp_id."\" id=\"item12_".$item_id."_radio\" required type=\"radio\" value=\"12\" /><span class=\"fb-fieldlabel\" id=\"item12_".$item_id."_span\">12</span></label>";
                echo "</div>";
                echo "</div>";
                ++$item_id;
              }
    ?>       
  <div class="fb-footer fb-item-alignment-center" id="fb-submit-button-div"
  style="min-height: 1px;">
      <input type="hidden" name="avaliado_posto_trabalho" value=<?php echo $avaliado_posto_trabalho;?>>
      <input type="hidden" name="codigo_servidor_avaliado" value=<?php echo $codigo_servidor_avaliado;?>>
      <input type="hidden" name="avaliado_full_name" value=<?php echo $avaliado_full_name;?>>
    <!--<input class="fb-button-special non-standard" id="fb-submit-button" style="border-width: 2px; padding-right: 6px; font-family: sans-serif; background-image: -ms-linear-gradient(rgb(236, 236, 236), rgb(213, 213, 213)); background-color: rgb(220, 220, 227);"
    type="submit" data-regular="" value="Submeter Avalia&ccedil;&atilde;o"
    />-->
      
      <button> Submete Avalia&ccedil;&atildeo </button> 
  </div>
  
</form>
<!-- End of the body content for CoffeeCup Web Form Builder -->


</body>
</html>