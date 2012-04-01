
<?php  
    if($_POST['topapp_hidden'] == 'Y') {  
        //Form data sent  
        $affi_config = $_POST['topapp_affi'];  
        update_option('topapp_affi', $affi_config);  
  
        $cat_config = $_POST['topapp_cat'];  
        update_option('topapp_cat', $cat_config);  
        
        
        $titre_widget = $_POST['topapp_titre_widget'];
        update_option('topapp_titre_widget', $titre_widget);
  		
  		$soutien = $_POST['topapp_soutien'];
        update_option('topapp_soutien', $soutien);
  		       
  		       
  		      
  		$plugin_dir_path = dirname(__FILE__);
  		  $cache_file = $plugin_dir_path.'/cache/xml_cached.rss'; 
  		  unlink($cache_file);
  		       
  		        ?>  
        <div class="updated"><p><strong><?php _e('Options saved.','topapp' ); ?></strong></p></div>  
        <?php  
    									} 
    
    else {  
        //Normal page display  
       	$titre_widget = get_option ('topapp_titre_widget');
        $affi_config = get_option('topapp_affi');  
        $cat_config = get_option('topapp_cat');  
        $soutien = get_option ('topapp_soutien');
     	                
        
        
    }  


?> 
<div class="wrap">   
<?php echo "<h2>" . __( 'Top App Configuration', 'topapp' ) . "</h2>"; ?>  

<div id="poststuff" class="metabox-holder">

	
<div id="forms" class="meta-box"><div id="formdiv" class="postbox " >
<div class="handlediv" title="Cliquer pour inverser."><br /></div><h3 class='hndle'><span>Configuration</span></h3>
<div class="inside">
  <table class="form-table">

	    <form name="topapp_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">  
        <input type="hidden" name="topapp_hidden" id="topapp_hidden" value="Y">  
       <tr>
       <th> <?php _e("Lien d'affiliation : ",'topapp' ); ?></th><td><input type="text" name="topapp_affi" id="topapp_affi" value="<?php echo $affi_config; ?>" size="20"> <br /><span class="description"><?php _e("Mettez votre lien d'affiliation sous la forme : http://clk.tradedoubler.com/click?p=23753&a=2076412&url=",'topapp');?></span></td></tr>
       <tr> 
       <th><?php _e("Top à afficher : ",'topapp' ); ?></th><td><select name="topapp_cat"> <option>iPhone</option><option>iPad</option>   </select><br/> <span class="description"><?php _e("Sélection du Top à afficher : ","topapp");?><strong><?php echo $cat_config;?></strong</span></td>  </tr>  
     <tr>
     <th><?php _e("Nous supporter : ",'topapp' ); ?></th><td><select name="topapp_soutien"><option><?php _e("Oui","topapp");?></option><option><?php _e("Non","topapp");?></option> </select>
     <br/> <span class="description"><?php _e(" Affiche un lien sous le widget : ","topapp");?><strong><?php echo $soutien;?></strong</span></td></tr>

  </table>
        
         
        <p class="submit">  
        <input type="submit" name="Submit" value="<?php _e('Mettre à jour les options', 'topapp' ) ?>" />  
        </p>  
    </form>  
  


<br class="clear" />
</div>
</div>


      

</div>  

