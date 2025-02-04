<?php

// Hak Cipta VM AGC Di Lindungi Oleh Tuhan Yang Maha Esa //
// Jika anda menyebarkan dan mendapatkan plugins ini secara ilegal, semoga rezeki anda terhambat //

$pluginname	= "VM AGC";
$shortname	= "vmagc";
//delete_option( 'vmagc_license_active' );

$vm_agc_options = array (

	array(  "name" => "IMAGE for HOMEPAGE and SIZE FILTER",
            "type" => "title",
			"desc" => "",
        ),

	array(  "name" => "IMAGE for HOMEPAGE and SIZE FILTER",
            "type" => "instruction",
			"desc" => "To trigger it, paste this to your index or home template <code>&lt;?php vm_agc_before_content(); ?&gt;</code>",
        ),

	array(  "type" => "open"),

	array( 	"name" => "License Key",
			"desc" => "Enter Your License Key (from ExclusiveBot.Net)",
			"id" => $shortname."_license_active",
			"std" => "",
            "type" => "license"),

	array( 	"name" => "Keyword",
			"desc" => "Enter Main Keyword, and homepage will displaying images related your chosen keyword.",
			"id" => $shortname."_keyword",
			"std" => "beautiful scenery",
            "type" => "text"),

    array( 	"name" => "AGC Template",
			"desc" => "You can use [first-images], [images-galery], [agc-text], [google-cse], [related-post], [related-videos], [spun-text], [ads-160-600], [ads-300-250], [ads-728-90]",
			"id" => $shortname."_template",
            "std" => "[first-images]\n[ads-728-90]\n[agc-text]\n[spun-text]\n[images-galery]\n[related-post]\n[google-cse]\n[related-videos]",
            "type" => "textarea"),

    array( 	"name" => "Inject Sitemap",
			"desc" => "You need to install plugins <a href=\"https://wordpress.org/plugins/google-sitemap-generator/\">Google XML Sitemap Generator</a> to use this features",
			"id" => $shortname."_inject_sitemap",
            "type" => "checkbox"),

    array( 	"name" => "Break Engine",
			"desc" => "Stop your index in search engine with make this features on.",
			"id" => $shortname."_break_engine",
            "type" => "checkbox"),

	array(  "name" => "Size Filter",
			"desc" => "Select the image size",
			"id" => $shortname."_size",
            "type" => "select",
			"options" => array('NONE', 'SMALL' , 'MEDIUM', 'LARGE', 'WALLPAPER'),
   		    "std" => "NONE"),

	array(  "name" => "Home Page Gallery Images",
			"desc" => "How many images to be shown in home page?",
			"id" => $shortname."_home_image_num",
            "type" => "text",
   		    "std" => "12"),

	array(  "name" => "Home Page Gallery Image Width",
			"desc" => "Set the image width of the home gallery.",
			"id" => $shortname."_width",
            "type" => "text",
   		    "std" => "400"),

	array(  "name" => "Home Page Gallery Image Height",
			"desc" => "Set the image height of the home gallery.",
			"id" => $shortname."_height",
            "type" => "text",
   		    "std" => "300"),

	array(  "name" => "Single Post Gallery Images",
			"desc" => "How many images to be shown in single post gallery?",
			"id" => $shortname."_gallery_image_num",
            "type" => "text",
   		    "std" => "4"),

	array(  "name" => "Single Post Gallery Image Width",
			"desc" => "Set the image width of the single post gallery.",
			"id" => $shortname."_gallery_image_width",
            "type" => "text",
   		    "std" => "150"),

	array(  "name" => "Single Post Gallery Image Height",
			"desc" => "Set the image height of the single post gallery.",
			"id" => $shortname."_gallery_image_height",
            "type" => "text",
   		    "std" => "150"),

    array( 	"name" => "Show AGC Text",
			"desc" => "Do you want to show AGC Text?",
			"id" => $shortname."_show_agc_text",
            "type" => "checkbox"),


    array( 	"name" => "Show Google CSE",
			"desc" => "Do you want to show Google CSE?",
			"id" => $shortname."_show_cse",
            "type" => "checkbox"),

    array( 	"name" => "Show Related Post",
			"desc" => "Do you want to show related post list?",
			"id" => $shortname."_show_related",
            "type" => "checkbox"),

    array( 	"name" => "Youtube Api",
			"desc" => "Enter Your Youtube Api.",
			"id" => $shortname."_youtubeapi",
			"std" => "AIzaSyA-m53DMxEFbkWj8JvSdn3JGeD34twPZKo",
            "type" => "text"),
            
	array( 	"name" => "Show YouTube Related Videos",
			"desc" => "Do you want to show related videos from YouTube?",
			"id" => $shortname."_show_ytrv",
            "type" => "checkbox"),

	array(  "name" => "Number of Related Videos",
			"desc" => "Select the number of related videos to be searched.",
			"id" => $shortname."_num_ytrv",
            "type" => "select",
			"options" => array('1','2','3', '4' , '5', '6', '7', '8'),
   		    "std" => "1"),

	array( 	"name" => "Show Spun Text",
			"desc" => "Do you want to show fake paragraph?",
			"id" => $shortname."_show_spun",
            "type" => "checkbox"),

	array( 	"name" => "Spun Text",
			"desc" => "Create a spun pattern paragraph.",
			"id" => $shortname."_spun",
			"std" => "You {can|could} do this to {create|generate|automate} a paragraph.",
            "type" => "textarea"),

	array( 	"name" => "Show AdSense 160x600",
			"desc" => "Do you want to show your 160x600 Adsense?",
			"id" => $shortname."_show_adsense_160",
            "type" => "checkbox"),

	array( 	"name" => "AdSense Code 160x600",
			"desc" => "Put your AdSense 160x600 script code. Do shortcode: <code>&lt;?php do_shortcode('[vmagc_adsense size=\"160\"]'); ?&gt;</code>",
			"id" => $shortname."_adsense_code_160",
            "type" => "textarea"),

	array( 	"name" => "Limit for Search Engine Visitors",
			"desc" => "Do you want to show your 160x600 Ads to visitors from search engine only?",
			"id" => $shortname."_show_limit_160",
            "type" => "checkbox"),

	array( 	"name" => "Show AdSense 300x250",
			"desc" => "Do you want to show your 300x250 Adsense?",
			"id" => $shortname."_show_adsense_300",
            "type" => "checkbox"),

	array( 	"name" => "AdSense Code 300x250",
			"desc" => "Put your AdSense 300x250 script code. Do shortcode: <code>&lt;?php do_shortcode('[vmagc_adsense size=\"300\"]'); ?&gt;</code>",
			"id" => $shortname."_adsense_code_300",
            "type" => "textarea"),

	array( 	"name" => "Limit for Search Engine Visitors",
			"desc" => "Do you want to show your 300x250 Ads to visitors from search engine only?",
			"id" => $shortname."_show_limit_300",
            "type" => "checkbox"),

	array( 	"name" => "Show AdSense 728x90",
			"desc" => "Do you want to show your 728x90 Adsense?",
			"id" => $shortname."_show_adsense_728",
            "type" => "checkbox"),

	array( 	"name" => "AdSense Code 728x90",
			"desc" => "Put your AdSense 728x90 script code. Do shortcode: <code>&lt;?php  do_shortcode('[vmagc_adsense size=\"728\"]'); ?&gt;</code>",
			"id" => $shortname."_adsense_code_728",
            "type" => "textarea"),

	array( 	"name" => "Limit for Search Engine Visitors",
			"desc" => "Do you want to show your 728x90 Ads to visitors from search engine only?",
			"id" => $shortname."_show_limit_728",
            "type" => "checkbox"),

	array(  "type" => "close"),

);


function vm_agc_admin() {

    global $pluginname, $shortname, $vm_agc_options;

    if ( @$_GET['page'] == 'vm-agc-settings' ) {
        if ( 'save' == @$_REQUEST['action'] ) {

                foreach ($vm_agc_options as $value) {
					if ( isset($value['id']) ) {
						if( isset( $_REQUEST[ $value['id'] ] ) ) { update_option( $value['id'], $_REQUEST[ $value['id'] ]  ); } else { delete_option( $value['id'] ); }
					}
				}

                header("Location: admin.php?page=vm-agc-settings&saved=true");
                die;

        } else if( 'reset' == @$_REQUEST['action'] ) {

            foreach ($vm_agc_options as $value) {
				if ( isset($value['id']) ) {
					delete_option( $value['id'] );
					if ( isset($value['std']) )
						update_option( $value['id'], $value['std'] );
				}
			}

            header("Location: admin.php?page=vm-agc-settings&reset=true");
            die;

        }
    }

	if ( @$_GET['page'] == 'vm-agc-keyword-showter' ) {
	    global $wpdb;
        $table_name = $wpdb->prefix . "keyword_showter";
        	$sql = "CREATE TABLE `{$table_name}` (
				`post_id` int(11) NOT NULL auto_increment,
				`terms` VARCHAR(50) NOT NULL,
				PRIMARY KEY  (`post_id`)
			)
			CHARACTER SET utf8 COLLATE utf8_general_ci;
			";
	        $wpdb->query($sql);
      if ( 'inject' == @$_REQUEST['action'] ) {
                $keywords = $_POST['keywordshowter_keyword'];
				$terms = explode("\n", $keywords);

				shuffle($terms);

				foreach ($terms as $term) {
					ks_save_term($term);
				}

				$terms = array_slice($terms, 0, $count);
				header("Location: admin.php?page=vm-agc-keyword-showter&saved=true");
				die;

        }
    }



    add_menu_page( "$pluginname Settings", 'VM AGC Settings', 'edit_themes', 'vm-agc-settings', 'vmagc_plugin_admin', 'dashicons-forms' );
    add_submenu_page( 'vm-agc-settings', "$pluginname Settings", 'VM Keyword Showter', 'edit_themes', 'vm-agc-keyword-showter', 'keywords_showter_admin');
    add_submenu_page( 'vm-agc-settings', "$pluginname Settings", 'VM Bulk Poster', 'edit_themes', 'vm-agc-bulk-poster', 'bulk_poster_admin');

}

// Hak Cipta VM AGC Di Lindungi Oleh Tuhan Yang Maha Esa //
// Jika anda menyebarkan plugins ini secara ilegal, semoga rezeki anda terhambat //
function vmagc_verify_domain( $domain = '' ) {

	if(!function_exists("curl_init")) die("cURL extension is not installed");

	$fields = array(
		'domain' => $domain,
		'format' => 'json',
	);
	$args = http_build_query($fields);
	$url = "http://license.exclusivebot.net/verul.php?{$args}";

	// Open connection
	$ch = curl_init();

	// Set the url, number of GET vars, GET data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$result = curl_exec($ch);
	curl_close($ch);

	$license = json_decode($result, true);
	if ( "true" == $license['success'] )
		return "true";

	return false;

}

// Hak Cipta VM AGC Di Lindungi Oleh Tuhan Yang Maha Esa //
// Jika anda menyebarkan plugins ini secara ilegal, semoga rezeki anda terhambat //
function vmagc_verify_license( $domain = '' ) {

	if(!function_exists("curl_init")) die("cURL extension is not installed");

	$fields = array(
		'domain' => $domain,
		'format' => 'json',
	);
	$args = http_build_query($fields);
	$url = "http://license.exclusivebot.net/verul.php?{$args}";

	// Open connection
	$ch = curl_init();

	// Set the url, number of GET vars, GET data
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

	$result = curl_exec($ch);
	curl_close($ch);

	$license = json_decode($result, true);
	if ( "true" == $license['success'] )
		return $license['license_key'];

	return false;

}



// Tampilan Vm AGC //



function vmagc_plugin_admin() {

    global $pluginname, $shortname, $vm_agc_options, $licensed;

?>
<style type="text/css">
#container {
width: 100%;
padding-right: 10px;
font-size: 13px;
font-family: Arial;
line-height: 2;
float: left;
}
</style>
<div class="wrap" style="width:80%">
<?php
		if ( @$_REQUEST['saved'] ) echo '<div id="message" class="updated fade below-h2"><p><strong>'.$pluginname.' settings saved.</strong></p></div>';
		if ( @$_REQUEST['reset'] ) echo '<div id="message" class="updated fade below-h2"><p><strong>'.$pluginname.' settings reset.</strong></p></div>';
		?>

      <div id='container'>
      <center><img src="http://exclusivebot.net/id/wp-content/themes/ebot/images/logo-header.png" title="ExclusiveBot.Net" alt="ExclusiveBot.Net"></center>
      <h2 class="wraphead" style="margin:10px 0px; padding:15px 10px; font-family:arial; font-style:normal;color: #fff; background:#6666CC;">
         <b><?php echo $pluginname; ?> OPTION</b>
         <a href="http://exclusivebot.net/id/vm-agc/" target="_blank"><b style="float:right; font-family:arial; font-style:normal;color: #fff;">TUTORIAL</b></a>
      </h2>

		<form method="post" class="vmagc">

		<?php
        // Hak Cipta VM AGC Di Lindungi Oleh Tuhan Yang Maha Esa //
        // Jika anda menyebarkan dan mendapatkan plugins ini secara ilegal, semoga rezeki anda terhambat //
		$licensed	= get_option('vmagc_license_active');
		$url = site_url();
		$license_key_verify	= vmagc_verify_license($url);
        $domain_verify	= vmagc_verify_domain($url);
        if ( "" == $licensed ) {
            ?>
           <table width="100%" border="0" style="background-color:#fff; padding:5px 10px;">
				<tr>
					<td style="vertical-align:middle;width:30%"><h3 style="font-size:14px;font-family:Arial;">License Key Required!</h3></td>
			   		<td style="width:70%">
                    <input style="height:30px;width:400px;" name="vmagc_license_active" id="vmagc_license_active" type="text" value="<?php if ( get_option( 'vmagc_license_active' ) != "") { echo get_option( 'vmagc_license_active' ); } else { echo ""; } ?>" />  <br />
                    <small><?php echo ( $verified ? "" : 'This domain is not registered for this license. ' ) ?>You can get this from <a href="http://exclusivebot.net/id" target="_blank">ExclusiveBot.Net</a></small>
                    </td>
				</tr>
            </table>        <br />
            <?
        }
        else {
		if( $license_key_verify == $licensed && "true" ===  $domain_verify ) {

			foreach ($vm_agc_options as $value) {

				$varType = vm_agc_isset_get($value, 'type');

				switch ( $varType ) {
					case "image":
					?>
						<tr>
						<td width="30%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
						<td width="70%"><img src="<?php echo $value['id']; ?>" /></td>
						</tr>
						<tr><td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td></tr>
						<tr><td colspan="2">&nbsp;</td></tr>
					<?php
						break;

					case "open":
					?>
						<table width="100%" border="0" style="background-color:#fff; padding:10px;">

					<?php
						break;

					case "close":
					?>
                      </table>
					  <p style="border-top:1px solid #000;margin-top:-10px;background:#fff;">License #<?php echo $licensed; ?>
                      <span style="float:right"><?php echo $pluginname ." version ". VMAGC_VERSION; ?></span>
                      </p>

					<?php
						break;

					case "instruction":
					?>

						<tr><td colspan="2" style="border-top:1px solid #000;"><br /><?php echo $value['desc']; ?></td></tr>

					<?php
						break;

					case "break":
					?>

						<tr><td colspan="2" style="border-top:1px solid #000;">&nbsp;</td></tr>

					<?php
						break;

					case "title":
					?>

						<table width="100%" border="0" style="background-color:#fff; padding:0px 10px;">
						<tr>
							<td colspan="2"><h3 style="font-size:14px;font-family:arial"><?php echo $value['name']; ?></h3></td>
						</tr>

					<?php
						break;

					case 'text':
					?>

						<tr>
							<td width="30%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
							<td width="70%"><input style="width:400px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="<?php echo $varType; ?>" value="<?php if ( get_option( $value['id'] ) != "") { echo get_option( $value['id'] ); } else { echo $value['std']; } ?>" /></td>
						</tr>
						<tr>
							<td><small><?php echo $value['desc']; ?></small></td>
						</tr>
						<tr>
							<td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>

					<?php
						break;

					case 'textarea':
					?>

						<tr>
							<td width="30%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
							<td width="70%"><textarea name="<?php echo $value['id']; ?>" style="width:400px; height:100px;" type="<?php echo $varType; ?>" cols="" rows=""><?php if ( get_option( @$value['id'] ) != "") { echo stripslashes (get_option( @$value['id'] )); } else { echo @$value['std']; } ?></textarea></td>
						</tr>
						<tr>
							<td><small><?php echo $value['desc']; ?></small></td>
						</tr>
						<tr>
							<td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>

					<?php
						break;

					case 'select':
					?>
						<tr>
							<td width="30%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
							<td width="70%"><select style="width:240px;" name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>"><?php foreach ($value['options'] as $option) { ?><option<?php if ( get_option( $value['id'] ) == $option) { echo ' selected="selected"'; } elseif ($option == $value['std']) { echo ' selected="selected"'; } ?>><?php echo $option; ?></option><?php } ?></select></td>
						</tr>

						<tr>
							<td><small><?php echo $value['desc']; ?></small></td>
						</tr>
						<tr>
							<td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>

					<?php
						break;

					case "checkbox":
					?>
						<tr>
							<td width="30%" rowspan="2" valign="middle"><strong><?php echo $value['name']; ?></strong></td>
							<td width="70%"><?php if(get_option($value['id'])){ $checked = "checked=\"checked\""; }else{ $checked = ""; } ?>
							<input type="checkbox" name="<?php echo @$value['id']; ?>" id="<?php echo @$value['id']; ?>" value="true" <?php echo @$checked; ?> />
							</td>
						</tr>

						<tr>
							<td><small><?php echo $value['desc']; ?></small></td>
						</tr>
						<tr>
							<td colspan="2" style="margin-bottom:5px;border-bottom:1px dotted #ffffff;">&nbsp;</td>
						</tr>
						<tr>
							<td colspan="2">&nbsp;</td>
						</tr>

					<?php
						break;

				}
			}
		}
		else {
		?>
			<table width="100%" border="0" style="background-color:#fff; padding:5px 10px;">
				<tr>
					<td style="vertical-align:middle;width:30%"><h3 style="font-size:14px;font-family:Arial;">License Key Required!</h3></td>
			   		<td style="width:70%">
                    <input style="height:30px;width:400px;" name="vmagc_license_active" id="vmagc_license_active" type="text" value="<?php if ( get_option( 'vmagc_license_active' ) != "") { echo get_option( 'vmagc_license_active' ); } else { echo ""; } ?>" />  <br />
                    <small><?php echo ( $license_key_verify ? "" : 'This domain is not registered for this license. ' ) ?> You can get this from <a href="http://exclusivebot.net/id" target="_blank">ExclusiveBot.Net</a></small>
                    </td>
				</tr>
            </table>        <br />

		<?php
		}
            }
		?>

			<p class="submit">
				<input name="save" type="submit" class="button-primary" value="Save changes" />
				<input type="hidden" name="action" value="save" />
				<?php
					if ( $license_key_verify == "") {
				?>
				<input type="hidden" name="vmagc_license_active" value="<?php if ( get_option( 'vmagc_license_active' ) != "") { echo get_option( 'vmagc_license_active' ); } else { echo ""; } ?>" />
				<?php
					}else{
					    ?>
                        <input type="hidden" name="vmagc_license_active" value="<?php echo $license_key_verify; ?>" />
                <?php
					}
				?>
			</p>
		</form>
		<form method="post" class="vmagc">
			<p class="submit">
				<input name="reset" type="submit" class="button-primary" value="Reset" />
                <input type="hidden" name="action" value="reset" />

			</p>
		</form>

	</div>
           </div>
<?php
}





// Keyword Showter //










function keywords_showter_admin() {

    global $pluginname, $shortname, $vm_agc_options, $licensed;

?>
    <div class="wrap" style="width:80%">
    <?php
	if ( @$_REQUEST['saved'] ) echo '<div id="message" class="updated fade below-h2"><p><strong>'.$pluginname.' Has inject keyword.</strong></p></div>';
	?>
                          <center><img src="http://exclusivebot.net/id/wp-content/themes/ebot/images/logo-header.png" title="ExclusiveBot.Net" alt="ExclusiveBot.Net"></center>
        <h2 class="wraphead" style="margin:10px 0px; padding:15px 10px; font-family:arial; font-style:normal;color: #fff; background:#6666CC;">
         <b>Keyword Showter</b>
      </h2>



		<form method="post" style="background-color:#fff;" class="vmagc">

		<?php
		$licensed	= get_option('vmagc_license_active','');
		$url = site_url();
		$license_key_verify	= vmagc_verify_license($url);
        $domain_verify	= vmagc_verify_domain($url);
        if ( "" == $licensed ) {
           ?>
            <script type="text/javascript">
            window.location = "admin.php?page=vm-agc-settings";
            </script>
            <?
        }
        else {
		if( $license_key_verify == $licensed && "true" ===  $domain_verify ) {

					?>
            <table width="100%" border="0" style="background-color:#fff; padding:5px 10px;">
				<tr>
					<td style="vertical-align:middle;width:30%"><h3 style="font-size:14px;font-family:Arial;">Keyword List</h3></td>
			   		<td style="width:70%"><textarea name="keywordshowter_keyword" style="width:400px; height:500px;" type="textarea" cols="" rows=""></textarea><br />
                    <small>To Show Random Search paste it to your widget <code>[ks_random_search count=20] (Change number in count whatever you need to show)</code></small>
                    </td>
				</tr>
                <tr>
                <td></td>
                <td>
                 <p class="submit">
			        	<input name="inject" type="submit" class="button-primary" value="Submit" />
				        <input type="hidden" name="action" value="inject" />
                    </p>
                </td>
                </tr>
            </table>

		</form>
     </div>





	<?php
		}
		else {
    ?>
            <script type="text/javascript">
            window.location = "admin.php?page=vm-agc-settings";
            </script>
    <?
}
    }
        }

add_action('admin_menu', 'vm_agc_admin'); ?>