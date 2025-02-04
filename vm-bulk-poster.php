<?php

function bulk_poster_admin() {
  global $pluginname, $shortname, $vm_agc_options, $licensed;
  ?>
   <div class="wrap" style="width:80%">
    <?php
	if ( @$_REQUEST['saved'] ) echo '<div id="message" class="updated fade below-h2"><p><strong>'.$pluginname.' Has inject keyword.</strong></p></div>';
	?>
      <center><img src="http://exclusivebot.net/id/wp-content/themes/ebot/images/logo-header.png" title="ExclusiveBot.Net" alt="ExclusiveBot.Net"></center>
      <h2 class="wraphead" style="margin:10px 0px; padding:15px 10px; font-family:arial; font-style:normal;color: #fff; background:#6666CC;">
          <b>Bulk Poster</b>
         <a href="http://exclusivebot.net/id/vm-agc/" target="_blank"><b style="float:right; font-family:arial; font-style:normal;color: #fff;">TUTORIAL</b></a>
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
        if ( ! empty ($_POST['vm_bulk_poster_keyword']) ) {
			vm_make_post($_POST['vm_bulk_poster_keyword']);
		} else {
			VMBPDisplay();
		}


	} else {
    ?>
            <script type="text/javascript">
            window.location = "admin.php?page=vm-agc-settings";
            </script>
    <?
}

    }
        }

function VMBPDisplay() {
    $category = get_categories(array('orderby' => 'NAME','order' => 'asc','taxonomy' => 'category','hide_empty' => 0));
		$cat = '<select name="bulk_post_category">';
		foreach($category as $row){
			$cat .= "<option value='{$row->cat_ID}'>{$row->cat_name}</option>";
		}
		$cat .= '</select>';

	   echo '<form method="post" action="">'.PHP_EOL;
		if ( function_exists('wp_nonce_field') ) {
			wp_nonce_field('vm_bulk_poster');
		} else {
			die ('<p>'.self::$upgrade_message.'</p>');
		}
		echo '<table style="text-align: left; padding: 10px 30px;">
			<tr valign="top">
                <th scope="row" style="vertical-align:middle;width:30%"><h3 style="font-size:12px;font-family:Arial;">Enter your lists of keyword / title here, one on each line</h3></th>
				<td><textarea name="vm_bulk_poster_keyword" cols="100" rows="10"></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 style="font-size:12px;font-family:Arial;">Post Type</h3></th>
				<td>
					<select name="vm_bulk_poster_type">
						<option value="post">Posts</option>
						<option value="page">Pages</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 style="font-size:12px;font-family:Arial;">Category</h3></th>
				<td>
					'.$cat.'
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 style="font-size:12px;font-family:Arial;">Post Status</h3></th>
				<td>
					<select name="vm_bulk_poster_status">
						<option value="draft">Draft</option>
						<option value="publish">Published</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 style="font-size:12px;font-family:Arial;">Start Posting On</h3></th>
				<td>
					<select name="date[year]">
						<option value="2015">2015</option>
						<option value="2014">2014</option>
						<option value="2013">2013</option>
						<option value="2012">2012</option>
						<option value="2011">2011</option>
						<option value="2010">2010</option>
						<option value="2009">2009</option>
						<option value="2008">2008</option>
					</select>
					<select name="date[month]">
						<option value="01">January</option>
						<option value="02">February</option>
						<option value="03">March</option>
						<option value="04">April</option>
						<option value="05">May</option>
						<option value="06">June</option>
						<option value="07">July</option>
						<option value="08">August</option>
						<option value="09">September</option>
						<option value="10">October</option>
						<option value="11">November</option>
						<option value="12">December</option>
					</select>
					<select name="date[day]">
						<option value="01">1</option>
						<option value="02">2</option>
						<option value="03">3</option>
						<option value="04">4</option>
						<option value="05">5</option>
						<option value="06">6</option>
						<option value="07">7</option>
						<option value="08">8</option>
						<option value="09">9</option>
						<option value="10">10</option>
						<option value="11">11</option>
						<option value="12">12</option>
						<option value="13">13</option>
						<option value="14">14</option>
						<option value="15">15</option>
						<option value="16">16</option>
						<option value="17">17</option>
						<option value="18">18</option>
						<option value="19">19</option>
						<option value="20">20</option>
						<option value="21">21</option>
						<option value="22">22</option>
						<option value="23">23</option>
						<option value="24">24</option>
						<option value="25">25</option>
						<option value="26">26</option>
						<option value="27">27</option>
						<option value="28">28</option>
						<option value="29">29</option>
						<option value="30">30</option>
						<option value="31">31</option>
					</select>
				</td>
			</tr>
			<tr valign="top">
				<th scope="row"><h3 style="font-size:12px;font-family:Arial;">Post Every</h3></th>
				<td>
					<input type="text" value="1" name="interval[value]" style="width:40px;"> /
					<select name="interval[type]">
						<option value="days">Day</option>
						<option value="hours">Hour</option>
						<option value="minutes">Minutes</option>
					</select>
				</td>
			</tr>
			</table>'.PHP_EOL;

		echo '<input type="hidden" name="action" value="update" />'.PHP_EOL;
		echo '<p class="submit">
			<input type="submit" class="button-primary" value="'.__('Create Now').'" />
			</p>'.PHP_EOL;
		}

function vm_make_post($titles){
       if ( ! empty($titles)) :
        $titles = explode(PHP_EOL, $titles);
		        	echo '<ul>'.PHP_EOL;
			        foreach ( $titles as $key => $title ) {
			        	$title = trim($title);
				        if ('post' == $_POST['vm_bulk_poster_type']) {
				       	if ($new_draft_id = vm_create_post($title, $key)) {
						echo '<li>Created <a href="post.php?action=edit&post='.$new_draft_id.'">'.$title.'</a>'.PHP_EOL;
					}
				} else {
					if ($new_draft_id = vm_create_post($title, $key)) {
						echo '<li>Created <a href="page.php?action=edit&post='.$new_draft_id.'">'.$title.'</a>'.PHP_EOL;
					}
				}
			}
			echo '<ul>'.PHP_EOL;
			if ('post' == $_POST['vm_bulk_poster_type']) {
				echo '<p>All done! <a href="edit.php">See all posts &raquo;</a></p>'.PHP_EOL;
			} else {
				echo '<p>All done! <a href="edit.php?post_type=page">See all pages &raquo;</a></p>'.PHP_EOL;
			}

		endif;
}

function vm_create_post($title, $key) {
		$params = $_POST;
		$base_date = mktime(0, 0, 0, (int)$params['date']['month'], (int)$params['date']['day'], (int)$params['date']['year']);
		$post_interval = '+'.($params['interval']['value']*$key).' '.$params['interval']['type'];

		$post_time = strtotime($post_interval, $base_date);
		$post_time = date('Y-m-d H:i:s', $post_time);


		if ( ! empty($title)) {
			global $wpdb;

			$new_draft_post = array(
			  'post_content' => VMMakeContent($title),
			  'post_status' => $params['vm_bulk_poster_status'],
			  'post_title' => $title,
			  'post_type' => $params['vm_bulk_poster_type'],
			  'post_date' => $post_time,
			);

			if ( $new_draft_id = wp_insert_post( $new_draft_post ) ) {
				wp_set_post_categories($new_draft_id,$params['bulk_post_category']);

				return $new_draft_id;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

function VMMakeContent($keyword_BP) {
        $sizex = get_option('vmagc_size');
	    $heightx = get_option('vmagc_height');
	    $widthx = get_option('vmagc_width');
	    $show_related = get_option('vmagc_show_related');
        $show_agc_text = get_option('vmagc_show_agc_text');
	    $show_cse = get_option('vmagc_show_cse');
	    $show_spun = get_option('vmagc_show_spun');
        $template = get_option('vmagc_template');
	    $show_ytrv = get_option('vmagc_show_ytrv');
	    $num_ytrv = get_option('vmagc_num_ytrv');

        switch ($sizex) {
		case 'NONE':
			$quality = '';
			break;
		case 'SMALL':
			$quality = '&qft=+filterui:imagesize-small';
			break;
		case 'MEDIUM':
			$quality = '&qft=+filterui:imagesize-medium';
			break;
		case 'LARGE':
			$quality = '&qft=+filterui:imagesize-large';
			break;
		case 'WALLPAPER':
			$quality = '&qft=+filterui:imagesize-wallpaper';
			break;
	}
        $keyword = $keyword_BP;
		$num_images = get_option('vmagc_gallery_image_num');
		$images = vm_agc($num_images, false, $keyword);

		// generate first image and title
		// mimic the featured post feature
		$align = 'center';
		$widthx = get_option('large_size_w');
		$first_image = vm_agc_images($keyword_BP, 1, 'LARGE');
		$first_image = '<div id="wp-image-' . $id . '" class="wp-caption ' . esc_attr($align) . '" style="width: 100%; text-align: center;"><img src="'
. $first_image[0] . '" width="100%"><p class="wp-caption-text">' . $keyword_BP . '</p></div>';

		// generate image gallery
		// continuing usage of generated images
		$image_gallery = '<h2 class="section-title">Image Gallery '. $keyword_BP .'</h2><div class="thumbnail-single-gallery clearfix">' . "\n";

		for ($i=0;$i<=$num_images;$i++) {
			if( isset($images[$i]) )
				$image_gallery .= $images[$i];
		}

		$image_gallery .= '</div>' . "\n";

		// generate related posts
		// list some related search and linking to another ag page
		$related_posts = '';

		if ( $show_related ) :
			$related_posts = vm_agc_parse_related_posts($keyword, 4);
		endif;

        // Generated AGC Text
        if ( $show_agc_text ) :
			$nav ='1';
		    $agc_text = '';
		    $agc_text .= '<blackquote><p style="text-align: justify; font-size: small;">';
		    $firstx = ($nav - 1) * 10;
		    $firstx = $firstx + 1;
		    $urlrss    = 'http://www.bing.com/search?q='.urlencode(limit_words($keyword_BP,5)).'&count=10&first='.$firstx.'&format=rss';
		    $feedbing  = @simplexml_load_string(VMExtractkURL($urlrss));
		   	foreach ($feedbing->channel->item as $itembing):
	    	$linked1  = $itembing->link;
		    $linked  = base64_encode($linked1);
		    $linked  = '/?go='.$linked;
		    $desced	= $itembing->description;
		    $desced = str_replace("...","",$desced);
		    $agc_text .= $desced;
	    	endforeach;
		    $agc_text .= '</p></blackquote>';
		endif;

		// generate related search
		// display Google Custom Search Engine
		$custom_search = '';

		if ( $show_cse ) :
		$custom_search .= "<div id='cse' class='vm_cse entry-content clearfix' style='width: 100%;'>Loading</div>\n";
		$custom_search .= "<script src='http://www.google.com/jsapi'></script>\n";
		$custom_search .= "<script type='text/javascript'>google.load('search','1'),google.setOnLoadCallback(function(){var e=new google.search.CustomSearchControl('003993100619866043508:vzaawptqixi');e.draw('cse'),e.execute('{$keyword_BP}')});</script>";
		endif;

		// Paragraph Part
		$paragraph_part = '';
		if ( $show_spun ) :
			$spun_string = get_option('vmagc_spun');
			$paragraph_part = vm_agc_spin($spun_string);
			$paragraph_part = wpautop($paragraph_part);
		endif;

		// AdSense Part
		$adsense_part = '';
		$adsense_part728 .= do_shortcode( '[vmagc_adsense size="728"]' );
        $adsense_part300 .= do_shortcode( '[vmagc_adsense size="300"]' );
        $adsense_part160 .= do_shortcode( '[vmagc_adsense size="160"]' );

		// Generate Related YouTube Videos
		$related_videos = '';
		/* Only continue if the API class could be loaded properly. */
		if( class_exists( 'RelatedYouTubeVideos_API' ) && $show_ytrv ) {
			$related_videos .= '<div id="vm-rytv" class="entry-content clearfix"><h3 class="section-title">Related Videos to '. ucwords($keyword_BP) .'</h3>' . "\n";

			$RytvAPI  = new RelatedYouTubeVideos_API();

			/* Do your configuration */
			$data     = $RytvAPI->validateConfiguration(
							array(
								'relation' => 'postTitle',
                                'terms' => "$keyword_BP",
								'max'      => $num_ytrv,
								'width'    => 150,
								'height'   => 150,
								'lang'     => 'en',
                                'region' => 'us',
								'class'    => 'left center inline bg-black',
								'preview'  => true,
								'showvideodescription' => true
							)
						);

			/* Search YouTube. */
			$results  = $RytvAPI->searchYouTube( $data, $keyword_BP );

			/* Generate the unordered HTML list of videos according to the YouTube results and your configuration.  */
			$html     = $RytvAPI->displayResults( $results, $data );

			$related_videos .= $html; // Or do with it whatever you like ;)

			$related_videos .= '</div>' . "\n";

		}


		// compose the content
		$content = '';
        $content_template = $template;
        $content_template = str_replace("[first-images]",$first_image,$content_template);
        $content_template = str_replace("[agc-text]",$agc_text,$content_template);
        $content_template = str_replace("[google-cse]",$custom_search,$content_template);
        $content_template = str_replace("[images-galery]",$image_gallery,$content_template);
        $content_template = str_replace("[related-post]",$related_posts,$content_template);
        $content_template = str_replace("[related-videos]",$related_videos,$content_template);
        $content_template = str_replace("[spun-text]",$paragraph_part,$content_template);
        $content_template = str_replace("[ads-160-600]",$adsense_part160,$content_template);
        $content_template = str_replace("[ads-300-250]",$adsense_part300,$content_template);
        $content_template = str_replace("[ads-728-90]",$adsense_part728,$content_template);
		$content = $content_template;
        return $content;
}
?>