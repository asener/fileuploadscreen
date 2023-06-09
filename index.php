<button type="button"  data-toggle="modal" style='display:none' data-target="#exampleModalaccept" id="exampleModalaccept_btn"></button>

<!-- Modal -->
<div class="modal fade" id="exampleModalaccept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header2" style="padding:1">
       
        <button type="button" style="padding:15px" class="close" data-dismiss="modal" aria-label="Close">
          
          <span aria-hidden="true">&times;</span>
        </button>
        <h3 style="text-align: center;
margin-top: 40px;">Weet je het zeker?</h3>
      </div>
      <div class="modal-body" style="text-align:center;clear:both">
        <p>
          
          <input type="checkbox" id="file_accept" name="file_accept" value="Bike" checked>
          <label for="file_accept">Ik ga akkoord met de huidige bestanden.</label>
          </p>
      </div>
      <div class="modal-footer2" style="padding: 15px;height: 60px;">
        <button type="button"   data-dismiss="modal" class="btn" style="float:left;width:45%;background-color: #fff;
border: 1px solid rgb(255,128,34);
border-radius: 5px;
-webkit-border-radius: 5px;text-transform:none">Nee, ga terug</button>
        <button type="button" onclick="close_table()" class="btn" style="float:right;width:45%;background: rgb(255,128,34);
border-radius: 5px;
-webkit-border-radius: 5px;color:#fff">Ja, doorgaan</button>
      </div>
    </div>
  </div>
</div>




<?php
  include("../connection.php");
  include("../fetch.php");
  $qid  = $_GET["qid"];
  $site = "snellermedia";
  
  $software_pms_price = 15;
  $hardware_pms_price = 30;
  
  
  $product_id_srg = "select product_id from quote_item where item_id = ?";
  $product_id = fetchOne_s($mysqli,$product_id_srg,$qid,"product_id");

  $product_name_srg = "select value from catalog_product_entity_varchar where entity_id = ? and attribute_id = 70 and store_id = 0";
  $product_name = fetchOne_s($mysqli,$product_name_srg,$product_id,"value");
  
  $c_srg = "select ifnull(customer_id,0) as customerid from quote where entity_id = (select quote_id from quote_item where item_id = ?)";
  $c = fetchOne_s($mysqli,$c_srg,$qid,"customerid");
  
  $qty_srg = "select qty from quote_item where item_id = ?";
  
  $qty = (int)fetchOne_s($mysqli,$qty_srg,$qid,"qty");
  
  $options_srg = "select value from quote_item_option where item_id = ? and code = 'custom_option'";
  $options_serialize = fetchOne_s($mysqli,$options_srg,$qid,"value");
  $options_array = unserialize($options_serialize);
  $options_arr = [];
  

  
  if (array_key_exists("options", $options_array))
  {
    $options_arr = $options_array["options"];
  }
   
  
  $doubleside_count = 0;
  foreach ($options_arr as $options_ar)
  {
    //$_atr     = $options_ar["atr"];
    $_atr_def = $options_ar["atr_def"];
    $_atr_val = $options_ar["atr_val"];
    
    
    $_atr_val = strtoupper($_atr_val);

    
    if (strpos($_atr_val, "DUBBELZIJDIG") !== false)
    {
      $doubleside_count = $doubleside_count + 1;
    }
  }
  


 // $height = $_GET["h"];
  $base_url = "https://".$_SERVER['SERVER_NAME'];

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  
  <link rel="stylesheet" href="<?= $base_url ?>/code/productionprocess/fileupload2/css/styles7.css" />

    <link rel="stylesheet" 
     href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css"/>

    <script type="application/javascript" src="<?= $base_url ?>/code/productionprocess/fileupload2/js/dropzone2.js"></script>
    
    <title>File Upload</title>
</head>
<body>
   <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalWaarschuwing" id="btn_myModalWaarschuwing" style="display:none"></button>

  <!-- Modal -->
  <div class="modal fade" id="myModalWaarschuwing" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <div style="width:100%;text-align:center">
            <h4 class="modal-title" style="color:#f60">Waarschuwing</h4>
          <h5>Controller onderstaande melding meelding(en)</h5>
          </div>
          
        </div>
        <div class="modal-body" style="margin-bottom:50px">
          <p style="-webkit-box-shadow: 0px 0px 10px 0px #dede; 
box-shadow: 0px 0px 10px 0px #dede;border-radius:10px;-webkit-border-radius:10px;padding:15px">
            <span style="color:#f60;font-weight:600">Lage resolutie</span>
            <br>
          
            <span style="clear:both;font-weight:400">De resolutie (dpi) van het is laag. Upload een bestand met een hogere resolutie of ga door als je tevreden bent huidige bestand.</span>
          </p>
          <p  style="-webkit-box-shadow: 0px 0px 10px 0px #dede; 
box-shadow: 0px 0px 10px 0px #dede;border-radius:10px;-webkit-border-radius:10px;padding:15px">
            <span style="color:#f60;font-weight:600">Verkeerde formaat</span>
            <br>
         
            <span style="clear:both;font-weight:400">Het bestand heeft een ander formaat dan het benodigde formaat. Upload een nieuw bestand met het juiste formaat en/of afloop. 
            Een andere optie is 'opvullen'. Het bestand wordt dan geschaald naar het benodigde formaat</span>
          </p>
          
          <p>
            <span  style="clear:both;font-weight:400">Raadpleeg de </span><a style="color:#f60 !important;cursor:pointer"  href="<?= $base_url ?>/klantenservice">klantenservice</a> <span  style="clear:both;font-weight:400"> voor meer informatie over het opmaken en uploaden van je bestanden.</span>
          </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn" style="background-color:#f60;color:#fff;text-transform:capitalize;width:100%" data-dismiss="modal">Sluiten</button>
        </div>
      </div>
      
    </div>
  </div>
  
<input type="hidden" id="inp_img" />

<input type="hidden" id="inpli_uid" />
<input type="hidden" id="inpli_name" />
<input type="hidden" id="inpli_size" />
<input type="hidden" id="inpli_width" />
<input type="hidden" id="inpli_height" />


<?php
    $width = "";
    $height = "";
    $formaat = "";
    
    foreach ($options_arr as $options_ar)
    {
      $_atr     = $options_ar["atr"];
      $_atr_def = $options_ar["atr_def"];
      $_atr_val = $options_ar["atr_val"];
      
      if ($_atr_def == "Breedte")
      {
        $width = $_atr_val;
      }
      if ($_atr_def == "Hoogte")
      {
        $height = $_atr_val;
      }
      if ($_atr_def == "Formaat")
      {
        $formaat = $_atr_val;
      }
    }


    if (strlen($width) == 0)
    {
        $size = $formaat;
        $size = str_replace("cm","",$size);
        $width = trim(explode("x",$size)[0]);
        $height = trim(explode("x",$size)[1]);
    }
    
    echo "<input type='hidden' id='inp_width' value='".$width."' />";
    echo "<input type='hidden' id='inp_height' value='".$height."' />";
    
    

    $table_html = "";
    $result = fetchAll($mysqli,"SELECT * FROM infogratic_uploadfilelist WHERE quote_id =".$qid." ORDER BY id asc");
    if (count($result) > 0)
    {
        $table_html = '<table class="table table-hover table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th></th> 
                                                                <th>Image</th>
                                                                <th>Qty</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>';
           
        $i = 1;
        
        foreach ($result as $res) 
        {
            $name = $res['file_link'];
            $name = explode("/", $name);
            $name = $name[count($name) - 1];
            $type_qty = (int)$res["type_qty"];
            $file_qty = (int)$res["file_qty"];
            $file_size = $res["file_size"];
            
            $li_name    = $res['li_name'];
            $li_size    = $res['li_size'];
            $li_width   = $res['li_width'];
            $li_height  = $res['li_height'];
     
                    
            
            $pms_textarea = trim($res["pms_textarea"]);
            $pms_case = trim($res["pms_case"]);		
            $_pms_case = "";
			if ($pms_case == 'Software Pms Control')
			{
				$_pms_case = "0";
			}
			if ($pms_case == 'Hardware Pms Control')
			{
				$_pms_case = "1";
			}
					
            $num_str = "";
            if ($type_qty > 0)
            {
                $num_str = $type_qty."-".$type_qty;
            }
            else
            {
                $num_str = $i;
            }

            $say = rand(10,10000);
					
			$software_display = "none";
            $hardware_display = "none";
            $textarea_display = "none";
            if (strlen($pms_textarea) > 0)
            {
                $_pms_case = "";
                if ($pms_case == 1)
                {
                    $software_display = "block";
                    $hardware_display = "none";
                    $_pms_case = "0";
                }
                if ($pms_case == 2)
                {
                    $software_display = "none";
                    $hardware_display = "block";
                    $_pms_case = "1";
                }
                $textarea_display = "block";
            }
			$translate_2 = "Software Pms Selected";
            $translate_3 = "Hardware Pms Selected";
					
			$table_html .= "<tr>
                              <td scope='col'>".$num_str."</td>
                              <td scope='col'>
                                                                        <input type='hidden' class='li_name' value='".$li_name."' />
                                                                        <input type='hidden' class='li_size' value='".$li_size."' />
                                                                        <input type='hidden' class='li_width' value='".$li_width."' />
                                                                        <input type='hidden' class='li_height' value='".$li_height."' />
                                                               
                                                                                            
									<input type='hidden' class='inp_size' value='".$file_size."' />
									<center><img style='max-width:120px;max-height:120px' src='".$res['thumbnail_file_link']."' /></center>
									<br>
									<a href='".$res['file_link']."' target='_blank' download class='btn btn-success' style='width:100%;margin-bottom:5px;color:white'>Download File</a>
									<input type='hidden' class='inp_pms_textarea' value='".$pms_textarea."' />
									<input type='hidden' class='inp_pms_case' value='".$_pms_case."' />	
                  <a class='btn btn-info' style='color:white;margin-bottom:5px;display:".$software_display.";'>".$translate_2."</a>
                  <a class='btn btn-info' style='color:white;margin-bottom:5px;display:".$hardware_display.";'>".$translate_3."</a>
                  <textarea style='display:".$textarea_display.";;width:100%;height:80px;' disabled>".$pms_textarea."</textarea>
                                                        
                                                        
                                                        
                              </td>
                             
                              <td scope='col'><center>".$file_qty."</center></td>
                        </tr>";    

            $i++;    
                        
        }
        $table_html .= '</tbody></table>'; 
    
                
        
    }
    echo '<div id="div_tbl_'.$qid.'" style="display:none">'.$table_html.'</div>';
?>
  <input type="hidden" id="translate_1" value="Pms" />
  <input type="hidden" id="translate_2" value="Software Pms" />
  <input type="hidden" id="translate_3" value="Hardware Pms" />
  <input type="hidden" id="active_pms" value="" />
  <input type="hidden" id="active_case" value="" />

  <input type="hidden" id="inp_qid" value="<?= $qid ?>" />
  <input type="hidden" id="inp_c" value="<?= $c ?>" />  
      <input type="hidden" id="inp_qty" value="<?= $qty ?>"/>
      <input type="hidden" id="inp_site" value="snellermedia"/>
    <input type="hidden" id="inp_doubleside_count" value="<?= $doubleside_count ?>"/>
  
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="document.getElementById('exampleModalaccept_btn').click()" style="    float: right;
    font-size: 21px;
    font-weight: 700;
    line-height: 1;
    text-shadow: 0 1px 0 #fff;
    filter: alpha(opacity=20);
    opacity: 1;
	color:rgb(0, 65, 97); background-color:#fff; -webkit-box-shadow: 0px 0px 5px -1px rgb(0 0 0 / 52%);
    box-shadow: 0px 0px 5px -1px rgb(0 0 0 / 52%);    padding: 5px 10px;" id="">&times;</button>
		<img src="<?= $base_url ?>/pub/media/icon/sneller-logo.png" style="width: 200px; transform: translateY(30px)"/>
        <h4 class="modal-title text-center" style="color: rgb(255,128,34); font-weight: bold; cursor: pointer;" id="myModalLabel" onclick="dropperOnen()">Bestanden</h4>
      </div>
  
  
  
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal5" style="display:none" id="open_mymodal5"></button>

<!-- Modal -->
<div id="myModal5" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" id="close_btn5">&times;</button>
        <h4 class="modal-title text-center" style="color:rgb(255,128,34)">Pms Control</h4>
         <button id="a_select" class="btn" style="display=block;width:100%;background-color:rgb(255,128,34); color:#fff; font-weight: bold;">Hardware Pms Selected</button> 
      </div>
      <div class="modal-body" style="height:350px">
        <div style="width:190px;height:300px;margin-top:10px;float:left">
            <a class="btn active-modal-btn btn-size" onclick="set_software()" id="a_software" style="height:125px;width:190px;line-height:35px;"><br>Software Pms Control<span>(&euro; <?= $software_pms_price ?>)</span></a>
            <a class="btn deactive-modal-btn btn-size" onclick="set_hardware()" id="a_hardware"  style="height:125px;width:190px;line-height:35px;"><br>Hardware Pms Control<span>(&euro; <?= $hardware_pms_price ?>)</span></a>
        </div>
        <div style="width:350px;float:left;height:300px;margin-left:20px">
            <textarea style="width:350px;height:250px;margin-top:10px; -webkit-box-shadow: 0px 0px 8px 1px rgba(0,65,97,0.35); 
		box-shadow: 0px 0px 8px 1px rgba(0,65,97,0.35); border: none; border-radius: 10px; outline: none;" id="modal_textarea"></textarea>
            <a class="btn btn-success" style="float:right;margin-top:10px; font-weight: bold;" onclick="update_pms(this)">Update</a>
      </div>
      </div>

    </div>

  </div>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="display:none" id="btn_file_error">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <h1 class="modal-title" id="exampleModalLabel">Fout in bestand</h1>
        <a style="color:gray;font-size:11px">Controleer onderstaande melding(en). Upload een aangepast bestand om door te gaan</a>
        <button type="button" class="close" style="position:absolute;right:10px;top:10px;" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height:180px">
        <div style="padding:10px;border:1px solid gray;border-radius:10px">
        <a style="font-size:12px;font-weight:bold;color:black">Oplage klopt niet</a>
        <br>
        <a style="font-size:11px;color:black">De toegewezen oplage komt niet overeen met het bestelde aantal.Pas de oplage aan of upload meer bestanda</a>
        </div>  
         <div style="width:100%;margin-top:10px;text-align:center">
            <span style="font-size:11px">Raadpleeg de <a href="#">klantenservice </a>voor meer informatie over het opmaken en uploaden van je bestanden.</span>   
         </div>   
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" style="width:100%" onclick="window.close()">Sluiten</button>
      </div>
    </div>
  </div>
</div>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2" style="display:none" id="btn_file_error2">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="text-align:center">
        <h1 class="modal-title" id="exampleModalLabel">Fout in bestand</h1>
        <a style="color:gray;font-size:11px">Controleer onderstaande melding(en). Upload een aangepast bestand om door te gaan</a>
        <button type="button" class="close" style="position:absolute;right:10px;top:10px;" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="height:180px">
        <div style="padding:10px;border:1px solid gray;border-radius:10px" id="exampleModal2_body">
       
       </div>  
          
      </div>
      <div class="modal-footer">
        
        <button type="button" class="btn btn-primary" style="width:100%" data-dismiss="modal">Sluiten</button>
      </div>
    </div>
  </div>
</div>

  
          <div class="block-upload">
  
            <div class="left-area d-flex" style="display: flex;align-items: center;">
                <div style="border-right: 1px solid rgb(0,65,97); padding: 0 15px">
                    Sleep jouw bestand (en) hierheen of klik op <br>
                    de knop om bestanden te uploaden.
                </div>
                <div style="border-right: 1px solid rgb(0,65,97); padding: 0 15px">
                    <b>Artikel:</b> <span style="font-weight: 500"><?= $product_name ?></span> <br>
                    <b>Benodigd Formaat:</b> <span style="font-weight: 500"><?= $width ?> x <?= $height ?> cm</span>
                </div>
                <div class="amount-holder" style="padding: 0 15px">
                    Oplage toegewezen: <span id="step-amount">0</span>/<span id="total_amount"><?= $qty ?></span>
                </div>
            </div>
            <div class="right-area" style="padding: 0 15px">
                  
                    <button class="btn" onclick="document.getElementById('dropzone_form').getElementsByTagName('form').item(0).click();" 
                            style="float:right;margin-left:-50px; background-color: rgb(255,128,34); color: #fff; font-weight: bold;">Upload je bestanden</button>
             
                

              
                
            </div>
    </div>
  
 <div id="dropzone_form">
    <form method="POST" action='/upload' class="dropzone dz-clickable"  id="dropper" enctype="multipart/form-data"></form>
  </div> 
  

  
  
  
  <div id="double_side_div" style="width: 0px; display: none; float: right; background-color: transparent; padding: 10px; border-left: 1px solid rgb(0, 65, 97); height: 596px;">
            <table class="table" id="table_double_side">
                <thead>
                    <tr>
                        <th></th>
                        <th>Voorkant</th>
                        <th>Achterkant</th>
                        <th>Aantal</th>
                    </tr>
                </thead> 
                <tbody>
              
              </tbody>
            </table>      
       
           <button class="btn btn-success" style="display:block;width:100%" onclick="add_line()">Add File</button> 
            
          </div>
  
 <div class="modal-footer">
     <div class="row no-gutters" style="margin-bottom: 30px;display:none">
         <div class="col-6 col-md-3" style="display: flex; justify-content: center; border-right: 1px solid rgb(0,65,35)">
             <div style="text-align: left; display: flex">
                 <div class="uploadImg" style="width: 20px; margin-right: 10px;box-shadow: 0 0 5px 2px rgb(0 65 97 / 13%);border-radius: 4px;padding: 1px;">
                     <img src="<?= $base_url ?>/pub/media/icon/opvullen.svg"/>
                 </div>
                 <div style="display: flex; align-items: center">
                     Opvullen
                    <span class="switcher active"></span>
                 </div>
             </div>
         </div>
         <div class="col-6 col-md-3" style="display: flex; justify-content: center; border-right: 1px solid rgb(0,65,35)">
             <div style="text-align: left; display: flex">
                 <div class="uploadImg" style="width: 20px; margin-right: 10px;box-shadow: 0 0 5px 2px rgb(0 65 97 / 13%);border-radius: 4px;padding: 1px;">
                     <img src="<?= $base_url ?>/pub/media/icon/spiegelen.svg"/>
                 </div>
                 <div style="display: flex; align-items: center">
                     Spiegelen
                    <span class="switcher active"></span>
                 </div>
             </div>
         </div>
         <div class="col-6 col-md-3" style="display: flex; justify-content: center; border-right: 1px solid rgb(0,65,35)">
             <div style="text-align: left; display: flex">
                 <div class="uploadImg" style="width: 20px; margin-right: 10px;box-shadow: 0 0 5px 2px rgb(0 65 97 / 13%);border-radius: 4px;padding: 1px;">
                     <img src="<?= $base_url ?>/pub/media/icon/roteren.svg"/>
                 </div>
                 <div style="display: flex; align-items: center">
                     Roteren
                    <select style="border: none; color: rgb(255,128,35); outline: none">
                        <option>0deg</option>
                        <option>45deg</option>
                        <option>90deg</option>
                    </select>
                 </div>
             </div>
         </div>
         <div class="col-6 col-md-3" style="display: flex; justify-content: center;">
             <div style="text-align: left; display: flex">
                 <div class="uploadImg" style="width: 20px; margin-right: 10px;box-shadow: 0 0 5px 2px rgb(0 65 97 / 13%);border-radius: 4px;padding: 1px;">
                     <img src="<?= $base_url ?>/pub/media/icon/opdelen.svg"/>
                 </div>
                 <div style="display: flex; align-items: center">
                     Opdelen
                    <select style="border: none; color: rgb(255,128,35); outline: none">
                        <option>Geen</option>
                        <option>Geen</option>
                        <option>Geen</option>
                    </select>
                 </div>
             </div>
         </div>
     </div>
            <div class="file-types-box">
                <h5>Wij ondersteunen de volgende bestandsformaten:</h5>
                <ul class="file-types"><li>.AI</li><li>.EPS</li><li>.JPG</li><li>.PDF</li></ul>
            </div>
          
            <div style="position: absolute;right: 30px;margin-top: -50px;">
              <button class="btn btn-default" onclick="window.close()">Verwijderen</button>
            <button class="btn" style="width: 140px; background-color: rgb(255,128,34); color: #fff; font-weight: bold;" id="btn_finish" type="button" onclick="document.getElementById('exampleModalaccept_btn').click()">Afronden</button>
            </div>
            
        </div> 
<script type="application/javascript" src="<?= $base_url ?>/code/productionprocess/fileupload2/js/upload11.js"></script>
</body>
</html>
