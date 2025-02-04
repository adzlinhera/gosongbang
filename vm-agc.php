<?php
/*
Plugin Name: VM AGC
Plugin URI: http://exclusivebot.net/id
Description: AGC purpose-driven plugin. Taking images from Bing for specified keyword.
Author: ExclusiveBot.net
Version: 2.0.7
Author URI: http://exclusivebot.net/id
*/

// Private plugin repository auto-update --
require 'plugin-update-checker/plugin-update-checker.php';
$MyUpdateChecker = PucFactory::buildUpdateChecker(
'http://plugins.exclusivebot.net/updates/?action=get_metadata&slug=vm-agc', //Metadata URL.
__FILE__, //Full path to the main plugin file.
'vm-agc' //Plugin slug. Usually it's the same as the name of the directory.
);

if ( !function_exists( 'add_action' ) ) {
	echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
	exit;
}

define( 'VMAGC_VERSION', '2.0.7' );
define( 'VMAGC_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'VMAGC_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

$plugin = plugin_basename(__FILE__);
require_once( VMAGC_PLUGIN_DIR . 'vm-sitemap-generator.php' );
require_once( VMAGC_PLUGIN_DIR . 'vm-bulk-poster.php' );

if ( is_admin() ) {
	require_once( VMAGC_PLUGIN_DIR . 'vm-agc-option.php' );

	// Add settings link on plugin page
	add_filter("plugin_action_links_$plugin", 'vm_agc_settings_link' );
	
}
function vm_agc_settings_link($links) { 
	$settings_link = '<a href="options-general.php?page=vm-agc-settings">Settings</a>';
	array_unshift($links, $settings_link); 
	return $links; 
}

/* Load the "Related YouTube Videos" API class if it does not exist yet. */
if( !class_exists( 'RelatedYouTubeVideos_API' ) ) {

	$file = VMAGC_PLUGIN_DIR . 'includes' . DIRECTORY_SEPARATOR . 'RelatedYouTubeVideos' . DIRECTORY_SEPARATOR . 'API.php';

	if( file_exists( $file ) ) {
		include_once $file;
	}

}



// Add custom style for the plugin's output
add_action( 'wp_enqueue_scripts', 'vm_agc_custom_styles' );
function vm_agc_custom_styles() {
    wp_register_style( 'vm_agc_custom_style', VMAGC_PLUGIN_URL . 'css/style.css' );
    wp_enqueue_style( 'vm_agc_custom_style' );
}

// Custom hook for generating the homepage gallery
function vm_agc_before_content( $arg1=null, $arg2=null ) {
    do_action( 'vm_agc_before_content', $arg1, $arg2 );
}

// The initial calls
/* paste this on theme file: <?php vm_agc_before_content(); ?> */
function vm_agc( $num=null, $print=true, $keyword='' ) {
    $vm_nofollow = get_option('vmagc_break_engine');
    if ($vm_nofollow == "true")
    {
        $vm_rel_break = "nofollow";
    }else {
        $vm_rel_break = "dofollow";
    }

	if ( null === $num )
		$num = get_option('vmagc_home_image_num');
	
	$sizex = get_option('vmagc_size');

	if ( is_404() ) {
		$heightx = get_option('vmagc_gallery_image_height');
		$widthx = get_option('vmagc_gallery_image_width');

	} else {
		$heightx = get_option('vmagc_height');
		$widthx = get_option('vmagc_width');
	}
	
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

	/* Count the search pagination */
	$nav = @$_GET['nav'];
	if ( empty($nav) ) {
		$nav ='1';
	}
	$startx = ($nav - 1) * $num;
	$starty = $startx + 1;
	
	/* Now, search for the images */
	if ( '' == $keyword ) {
		$keyword	= 	str_replace(' ','+',get_option('vmagc_keyword'));
	}
	else {
		$keyword	= 	str_replace(' ','+',$keyword);
	}
	
	$url		=	'http://www.bing.com/images/search?q='.$keyword.$quality.'&count='.$num.'&first='.$starty;
	$feed   	= 	vm_agc_getfeed($url);
	if( strpos($feed,'Ensure words are spelled correctly') !== false ){
		$url		=	'http://www.bing.com/images/search?q='.urldecode($keyword).$quality.'&count='.$num.'&first='.$starty;
		$feed   	= 	vm_agc_getfeed($url);
	}

	$content	= 	explode('<noscript>',$feed);
	$content	= 	explode('</noscript>',$content[1]);
	$content	= 	htmlspecialchars_decode($content[0]);
	$image2		= 	explode('imgurl:"',$content);
	$citra		= 	explode('"',$image2[1]);
	$citra		=	$citra[0];
	$title2		= 	explode('t1="',$content);
	$source2	= 	explode('surl:"',$content);
	$dimensi2	=	explode('t2="',$content);
	
	/* Prepare the AGC feed */
	$result = '';
	$arr_result = array();
	for ($i=1;$i<=$num;$i++) {
		$image		= explode('"',$image2[$i]);
		$image		= $image[0];
		$image		= str_replace(array('http://www.sareez.com','http://wall4all.me','http://www.wallm.com','http://www.sohocg.net','http://furnitureconnxion.com','http://millyskitchen.co.nz','http://lobuscogratis.com','http://www.neverpaintagain.co.uk','http://viphairstyles.com','http://www.finecabinetryllc.com','http://christmascakedecorations.info'),' ',$image);
		$image		= str_replace(array('http://'),'',$image);
		$title		= explode('"',$title2[$i]);
		$title		= $title[0];
		$title		= preg_replace("/[^A-Za-z0-9 ]/", ' ', $title);
		$title		= str_replace(array('Png','Click','The','Above','Thumbnail','To','View','Large','Images','Of','Or ','Erotik','Film','Pornoizle','Sikis','ARZU','OKAY',' FILIMI','SIKIS','SEX','EROTIC','Maxresdefault','640x480','800x600','1024x768', '1152x864', '1280x960', '1400x1050', '1600x1200', '1920x1440', '2048x1536','1280x1024','1280x800', '1440x900', '1680x1050','1400x1050', '1920x1200','1600x1200', '2560x1600','1280x720', '1366x768','1024x768', '1600x900', '1920x1080','Pixels','COM','WWW','The Free Encyclopedia','Org','And','Of','YouTube','Photo','Pictures','Facebook','Pixels','Sex','toronto','rumah','uploads','Wp Content','buy','it now','get','download','Share','On','www','/','-','+','-','%7C','jpg','php','gif','html','Blogspot','Com','.com','http','naked','sexy','porn','lol','wtf','com','related','http:,cache:,site:,utm_source','sex','porn','gamble','xxx','nude','squirt','gay','abortion','attack','bomb','casino','cocaine','die','death','erection','gambling','heroin','marijuana','masturbation','pedophile','penis','poker','pussy','terrorist','drug','facebook','twitter','amazon','Wikipedia'),' ',$title);
		$title		= preg_replace("/[0-9]/", "", $title);
		$title		= trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $title));
		$title		= str_replace(array('_','/'),' ',$title);
		$title		= trim(ucwords($title));
		$url        = home_url('/') . str_replace(' ','-',strtolower($title));
		$cat		= explode('-',$url);
		$cat		= $cat[0];
		
		/* Prepare the output */
		if ( !empty($image) ) {
			$result .= '<div class="vm_container"><a href="'.$url.'" title="'.$title.'" rel="'.$vm_rel_break.'"><img src="http://i0.wp.com/'.$image.'?w='.$widthx.'&h='.$heightx.'" alt="'.$title.'" class="vm_thumb" width="'.$widthx.'" height="'.$heightx.'" title="'.$title.'" /></a></div>';

			$arr_result[] = '<div class="vm_container"><a href="'.$url.'" title="'.$title.'" rel="'.$vm_rel_break.'"><img src="http://i0.wp.com/'.$image.'?w='.$widthx.'&h='.$heightx.'" alt="'.$title.'" class="vm_thumb" width="'.$widthx.'" height="'.$heightx.'" title="'.$title.'" /></a></div>';
			
		}
	}
	if ( true === $print) {
		echo $result;
	}
	else {
		return $arr_result;
	}
}

function vm_agc_images($keyword='', $num=3, $sizex = 'MEDIUM') {
	// $sizex = get_option('vmagc_size');
	// $heightx = get_option('vmagc_height');
	// $widthx = get_option('vmagc_width');
	
	switch ($sizex) {
		case 'NONE':
			$quality = '';
			$heightx = get_option( 'thumbnail_size_h' );
			$widthx = get_option( 'thumbnail_size_w' );
			break;
		case 'SMALL':
			$quality = '&qft=+filterui:imagesize-small';
			$heightx = get_option( 'thumbnail_size_h' );
			$widthx = get_option( 'thumbnail_size_w' );
			break;
		case 'MEDIUM':
			$quality = '&qft=+filterui:imagesize-medium';
			$heightx = get_option( 'medium_size_h' );
			$widthx = get_option( 'medium_size_w' );
			break;
		case 'LARGE':
			$quality = '&qft=+filterui:imagesize-large';
			$heightx = get_option( 'large_size_h' );
			$widthx = get_option( 'large_size_h' );
			break;
		case 'WALLPAPER':
			$quality = '&qft=+filterui:imagesize-wallpaper';
			$heightx = get_option( 'large_size_h' );
			$widthx = get_option( 'large_size_h' );
			break;
	}

	/* Count the search pagination */
	$nav = @$_GET['nav'];
	if ( empty($nav) ) {
		$nav ='2';
	}
	$startx = ($nav - 1) * $num;
	$starty = $startx + 1;
	
	/* Now, search for the images */
	if ( '' == $keyword ) {
		$keyword	= 	str_replace(' ','+',get_option('vmagc_keyword'));
	}
	else {
		$keyword	= 	str_replace(' ','+',$keyword);
	}
	
	$url		=	'http://www.bing.com/images/search?q='.$keyword.$quality.'&count='.$num.'&first='.$starty;
	$feed   	= 	vm_agc_getfeed($url);
	if( strpos($feed,'Ensure words are spelled correctly') !== false ){
		$url		=	'http://www.bing.com/images/search?q='.urldecode($keyword).$quality.'&count='.$num.'&first='.$starty;
		$feed   	= 	vm_agc_getfeed($url);
	}

	$content	= 	explode('<noscript>',$feed);
	$content	= 	explode('</noscript>',$content[1]);
	$content	= 	htmlspecialchars_decode($content[0]);
	$image2		= 	explode('imgurl:"',$content);
	$citra		= 	explode('"',$image2[1]);
	$citra		=	$citra[0];
	$title2		= 	explode('t1="',$content);
	$source2	= 	explode('surl:"',$content);
	$dimensi2	=	explode('t2="',$content);
	
	/* Prepare the AGC feed */
	$arr_result = array();
	for ($i=1;$i<=$num;$i++) {
		$image		= explode('"',$image2[$i]);
		$image		= $image[0];
		$image		= str_replace(array('http://www.sareez.com','http://wall4all.me','http://www.wallm.com','http://www.sohocg.net','http://furnitureconnxion.com','http://millyskitchen.co.nz','http://lobuscogratis.com','http://www.neverpaintagain.co.uk','http://viphairstyles.com','http://www.finecabinetryllc.com','http://christmascakedecorations.info'),' ',$image);
		$image		= str_replace(array('http://'),'',$image);
		
		/* Prepare the output */
		if ( !empty($image) ) {
			
			$arr_result[] = 'http://i0.wp.com/'.$image.'?w='.$widthx.'&h='.$heightx.'';
			
		}
	}
	
	return $arr_result;
	
}

function vm_agc_items($keyword='', $num=3) {
	
	if ( '' == $keyword ) {
		$keyword	= 	str_replace(' ','+',get_option('vmagc_keyword'));
	}
	else {
		$keyword	= 	str_replace(' ','+',$keyword);
	}
	
	$url		=	'http://www.bing.com/search?q='.$keyword.'&count='.$num.'&format=rss';
	$feed   	= 	vm_agc_getfeed($url);
	if( strpos($feed,'Ensure words are spelled correctly') !== false ){
		$url		=	'http://www.bing.com/search?q='.urldecode($keyword).'&count='.$num.'&format=rss';
		$feed   	= 	vm_agc_getfeed($url);
	}
	$xml = @simplexml_load_string($feed);
	$feed = $xml->channel;
	
	/* Prepare the AGC feed */
	$arr_result = array();
	
	foreach ($feed->item as $entry) {
		
		$arr_result[] = array(
						'title'=>$entry->title,
						'description'=>$entry->description
					);
		
	}
	
	return $arr_result;
	
}

// Function For Agc Text
function VMExtractkURL($url){
		// inisialisasi CURL
		$data = curl_init();
		// setting CURL
		curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($data, CURLOPT_URL, $url);
		// menjalankan CURL untuk membaca isi file
		$hasil = curl_exec($data);
		curl_close($data);
		return $hasil;
		}

function limit_words($string, $word_limit)
		{
			$words = explode(" ",$string);
			return implode(" ",array_splice($words,0,$word_limit));
		}

/* Create 404 interception */
// generate faux on single post
add_action( 'template_redirect', 'vm_agc_404', 0 );
function vm_agc_404() {
	global $wp_query, $post;
	global $wpdb; // if you're in a function
	$random_user_id = $wpdb->get_var("SELECT ID FROM $wpdb->users ORDER BY RAND() LIMIT 1");
	
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

	/* Count the search pagination */
	$nav = @$_GET['nav'];
	if ( empty($nav) ) {
		$nav ='1';
	}
	$startx = ($nav - 1) * 3;
	$starty = $startx + 1;
	
    if ( $wp_query->post_count == 0 AND ! is_home() AND ! is_search() ) {
		status_header( '200' );

		$permalink	= $_SERVER['REQUEST_URI'];
		$permalinkx	= $_SERVER['REQUEST_URI'];
		$permalinky	= explode('?',$permalink);
		$permalinky	= $permalinky[0];
		$permalink	= explode('/',$permalinkx);
		$permalinkz = $permalink[1];
		$permalink	= $permalink[1];
		$permalink	= explode('?',$permalink);
		$permalink	= $permalink[0];
		$title    	= urldecode(str_replace(array('/','-','+','-','%7C','jpg','php','gif','html','Blogspot','Com','.com','http','Wikipedia'),' ',$permalink));
		
		/* the faux */
		
		// generate random ID
		// just a work-around to mar-kup the theme
		$last = wp_get_recent_posts( array(
				'numberposts' => 1)
			);
		$last_id = $last['0']['ID'];
		$max_id = $last_id + 100;
		$id = rand($last_id, $max_id);
		
		// generate random images
		// get several images for link to another ag page
		$keyword = $title;
		$num_images = get_option('vmagc_gallery_image_num');
		$images = vm_agc($num_images, false, $keyword);
		
		// generate first image and title
		// mimic the featured post feature
		$align = 'center';
		$widthx = get_option('large_size_w');
		$first_image = vm_agc_images($title, 1, 'LARGE');
		$first_image = '<div id="wp-image-' . $id . '" class="wp-caption ' . esc_attr($align) . '" style="width: 100%; text-align: center;"><img src="'
. $first_image[0] . '" width="100%"><p class="wp-caption-text">' . $title . '</p></div>';

		// generate image gallery
		// continuing usage of generated images
		$image_gallery = '<h2 class="section-title">Image Gallery '. $title .'</h2><div class="thumbnail-single-gallery clearfix">' . "\n";
		
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
		    $urlrss    = 'http://www.bing.com/search?q='.urlencode(limit_words($title,5)).'&count=10&first='.$firstx.'&format=rss';
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
		$custom_search .= "<script type='text/javascript'>google.load('search','1'),google.setOnLoadCallback(function(){var e=new google.search.CustomSearchControl('003993100619866043508:vzaawptqixi');e.draw('cse'),e.execute('{$title}')});</script>";
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
			$related_videos .= '<div id="vm-rytv" class="entry-content clearfix"><h3 class="section-title">Related Videos to '. ucwords($title) .'</h3>' . "\n";

			$RytvAPI  = new RelatedYouTubeVideos_API();

			/* Do your configuration */
			$data     = $RytvAPI->validateConfiguration(
							array(
								'relation' => 'postTitle',
                                'terms' => "$title",
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
			$results  = $RytvAPI->searchYouTube( $data, $title );

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

		$post = new stdClass();
			$post->ID 			= $id;
			$post->post_category= array('uncategorized'); //Add some categories. an array()???
			$post->post_content	= $content; //The full text of the post.
			$post->post_excerpt	= 'hey here we are a real post'; //For all your post excerpt needs.
			$post->post_status	= 'publish'; //Set the status of the new post.
			$post->post_title	= $title; //The title of your post.
			$post->post_type	= 'post'; //Sometimes you might want to post a page.
			$post->post_author	= $random_user_id;
			$post->post_date 	= 1;
			$post->comment_status= 'closed';
		/* assign the faux */
		$wp_query->queried_object=$post;
		$wp_query->post=$post;
		$wp_query->found_posts = 1;
		$wp_query->post_count = 1;
		$wp_query->max_num_pages = 1;
		$wp_query->is_single = 1;
		$wp_query->is_404 = false;
		$wp_query->is_posts_page = 1;
		$wp_query->posts = array($post);
		$wp_query->is_post=true;
		
		add_action( 'wp_head', 'vm_agc_meta_tags' , 2 );
		
    } // .if ( $wp_query->post_count == 0 )
	elseif ( is_search() ) {
		$permalink	= $_SERVER['REQUEST_URI'];
		$permalinkx	= $_SERVER['REQUEST_URI'];
		
		if (strpos($permalinkx,'/search/') !== false) {			
			$permalinky	= explode('search',$permalink);
			$permalinky	= $permalinky[0];
			$permalink	= explode('/',$permalinkx);
			$permalinkz = $permalink[1];
			$permalink	= $permalink[2];
			$permalink	= explode('?s=',$permalink);
			$permalink	= $permalink[0];
		}
		else {
			$permalinky	= explode('?s=',$permalink);
			$permalinky	= $permalinky[0];
			$permalink	= explode('/',$permalinkx);
			$permalinkz = $permalink[1];
			$permalink	= $permalink[1];
			$permalink	= explode('?s=',$permalink);
			$permalink	= $permalink[1];
		}
		
		
		$title    	= urldecode(str_replace(array('/','-','+','-','%7C','jpg','php','gif','html','Blogspot','Com','.com','http','Wikipedia'),' ',$permalink));
		$url        = home_url('/') . str_replace(' ','-',strtolower($title));
		
		/* the faux */
		
		// generate random ID
		// just a work-around to mar-kup the theme
		$last = wp_get_recent_posts( array(
				'numberposts' => 1)
			);
		$last_id = $last['0']['ID'];
		$max_id = $last_id + 100;
		$id = rand($last_id, $max_id);
		
		// generate random images
		// get several images for link to another ag page
		$keyword = $title;
		
		// compose the content
		$content = '';
		// $related_posts = vm_agc_parse_search_results($keyword, null);
		$search_results = vm_agc_generate_search_results($keyword, null);
		
		$datestart = strtotime('2013-12-10');
		$dateend = strtotime("last Monday");
		foreach ( $search_results as $sr ) {
			if ( isset($sr) ) {
				$random_date = mt_rand($datestart, $dateend);
				$postdate = date("Y-m-d H:i:s", $random_date);
				
				$post = new stdClass();
				$post->ID 			= $sr['id'];
				$post->post_category= $sr['cat'];
				$post->post_content	= $sr['content'];
				$post->post_excerpt	= $sr['excerpt'];
				$post->post_status	= 'publish'; //Set the status of the new post.
				$post->post_title	= $sr['title'];
				$post->slug			= $sr['slug'];
				$post->image 		= $sr['thumbnail'];
				$post->post_type	= 'post'; //Sometimes you might want to post a page.
				$post->post_author	= $random_user_id;
				$post->post_date 	= $postdate;
				$post->comment_status= 'closed';
				
				
			}
			
			$posts[] = $post;
		}
		
		/* assign the faux */
		$wp_query->queried_object=$post;
		$wp_query->post=$post;
		$wp_query->found_posts = 10;
		$wp_query->post_count = 10;
		$wp_query->max_num_pages = 1;
		$wp_query->is_single = 1;
		$wp_query->is_404 = false;
		$wp_query->is_posts_page = 1;
		$wp_query->posts = $posts;
		$wp_query->is_post=true;
		
		add_action( 'wp_head', 'vm_agc_meta_tags' , 2 );
	}
	else {
		add_action( 'vm_agc_before_content', 'vm_agc', 10 );
	}
}

// Faux thumbnails for search results
add_filter( 'post_thumbnail_html', 'vm_agc_post_image_html', 10, 5 );

function vm_agc_post_image_html( $html, $post_id, $post_thumbnail_id, $size, $attr ) {
	global $post;
	
    if( '' == $html ) {
        
        $html = "<img src='{$post->image}' alt='{$post->slug}' width='{$post->image->width}' height='{$post->image->height}' >";
    }
    return $html;
}

add_filter('pre_post_link', 'pre_search_permalink', 10, 3);
function pre_search_permalink($permalink, $post, $leavename) { 
    if  ( is_search() ) {
        $title 		= urldecode(str_replace(array('/','-','+','-','%7C','jpg','php','gif','html','Blogspot','Com','.com','http','Wikipedia'),' ',$post->slug));
		$permalink	= str_replace(' ','-',strtolower($title));
	}
    return $permalink;      
}


function vm_agc_getfeed($url){
     // inisialisasi CURL
     $data = curl_init();
     // setting CURL
     curl_setopt($data, CURLOPT_URL, $url);
     curl_setopt($data, CURLOPT_HEADER, 0);
     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($data, CURLOPT_URL, $url);
     curl_setopt($data, CURLOPT_REFERER, 'https://www.bing.com');
     curl_setopt($data, CURLOPT_SSL_VERIFYPEER, false);
     curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.11 (KHTML, like Gecko) Chrome/23.0.1271.97 Safari/537.11");
     curl_setopt($data, CURLOPT_FOLLOWLOCATION, true);
     $response = curl_exec($data);
     curl_close($data);
     return $response;
}
// Parse spun formatted string
function vm_agc_spin($text){
	return preg_replace_callback(
		'/\{(((?>[^\{\}]+)|(?R))*)\}/x',
		'vm_agc_process_spin',
		$text
	);
}

function vm_agc_process_spin($text){
	$text = vm_agc_spin($text[1]);
	$parts = explode('|', $text);
	return $parts[array_rand($parts)];
}

// Limit Ads shown to search engine visitors
function vm_agc_from_searchengine() {
	
	$ref = $_SERVER['HTTP_REFERER'];
	$SE = array('/search?', 'images.google.', 'web.info.com', 'search.', 'del.icio.us/search', 'soso.com', '/search/', '.yahoo.');

	foreach ($SE as $source) {

		if (strpos($ref,$source)!==false)
			return true;
	}
	return false;
}

// Check for bad words in url
function vm_agc_check_badwords($permalink = "") {
	$banned_words	= file_get_contents(  VMAGC_PLUGIN_DIR .'badkeyword.txt' );
	$arr_banned_words	= explode(',', $banned_words);

	$banned = false;

	$matches = array();
	$matchFound = preg_match_all(
					"/\b(" . implode($arr_banned_words,"|") . ")\b/i",
					$permalink,
					$matches
				  );

	if ($matchFound) {
		
		$words = array_unique($matches[0]);

		foreach($words as $word) {
			if ( 0 < strlen($word) ) {
				$banned = true;
			}
			else {
				$banned = false;
			}
		}
	}
	
	return $banned;
}

// Add custom jQuery for the plugin's output
add_action( 'wp_enqueue_scripts', 'vm_agc_load_jquery' );
function vm_agc_load_jquery() {
	
	if ( is_404() || is_single() ) {
		$vmagc_height_value = get_option('vmagc_gallery_image_height');
		$vmagc_width_value = get_option('vmagc_gallery_image_width');

	} else {
		$vmagc_height_value = get_option('vmagc_height');
		$vmagc_width_value = get_option('vmagc_width');
	}
	
	
	wp_register_script( 'vm-agc-jquery', VMAGC_PLUGIN_URL . 'js/vm_agc_jquery.js', array( 'jquery' ), false, false );
	wp_enqueue_script( 'vm-agc-jquery', VMAGC_PLUGIN_URL . 'js/vm_agc_jquery.js');
	wp_localize_script( 
		'vm-agc-jquery',
		'js_value',
		array(
			'vmagc_width_value' => $vmagc_width_value,
			'vmagc_height_value' => $vmagc_height_value
		)
		
	);
	
}

/* Create custom 404 Title */
add_filter( 'wp_title', 'vm_agc_wp_title', 10, 2 );
function vm_agc_wp_title( $title, $sep ) {
	global $paged, $page;
	$title = ucwords($title);
	
	return $title;
}

/* Adding Meta Tags */
function vm_agc_meta_tags() {
	$sizex = get_option('vmagc_size');
	$heightx = get_option('vmagc_height');
	$widthx = get_option('vmagc_width');
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
	/* Count the search pagination */
	$nav = @$_GET['nav'];
	if ( empty($nav) ) {
		$nav ='1';
	}
	$startx = ($nav - 1) * 3;
	$starty = $startx + 1;
    global $post;
	
        $permalink	= $_SERVER['REQUEST_URI'];
		$permalinkx	= $_SERVER['REQUEST_URI'];
		$permalinky	= explode('?',$permalink);
		$permalinky	= $permalinky[0];
		$permalink	= explode('/',$permalinkx);
		$permalinkz = $permalink[1];
		$permalink	= $permalink[1];
		$permalink	= explode('?',$permalink);
		$permalink	= $permalink[0];
		$title    	= urldecode(str_replace(array('/','-','+','-','%7C','jpg','php','gif','html','Blogspot','Com','.com','http','Wikipedia'),' ',$permalink));
		$keywords	= str_replace(' ',', ',$title);
		$katakunci	= str_replace(array('-','()'),array('+','"'),$permalink);
		$katakunci	= str_replace(array('www','/','-','+','-','%7C','jpg','php','gif','html','Blogspot','Com','.com','http','Wikipedia'),'',$katakunci);
		$katakunci 	= urlencode(str_replace(' ',',',$permalink));
		$katakunci	= htmlspecialchars(strip_tags($katakunci));
		$katakunci	= strtolower(str_replace('-','+',$katakunci));

		$url		= 'http://www.bing.com/images/search?q='.$katakunci.$quality.'&count=3&first='.$starty;
		$feed   	= vm_agc_getfeed($url);
		if(strpos($feed,'Ensure words are spelled correctly') !== false){
			$url	= 'http://www.bing.com/images/search?q='.urldecode($katakunci).$quality.'&count=3&first='.$starty;
			$feed	= vm_agc_getfeed($url);
		}

		$content	= 	explode('<noscript>',$feed);
		if ( isset($content[1]) ) {
			$content	= 	explode('</noscript>',$content[1]);
		}
		$content	= 	htmlspecialchars_decode($content[0]);
		$image2		= 	explode('imgurl:"',$content);
		if ( isset($image2[1]) ) {
			$citra		= 	explode('"',$image2[1]);
			$citra		=	$citra[0];
		} else {
			$citra		= '';
		}
		$title2		= 	explode('t1="',$content);
		$source2	= 	explode('surl:"',$content);
		$dimensi2	=	explode('t2="',$content);

		$secure_url = str_replace('http://','https://',$citra);

		echo '<meta name="description" content="' . $title . '" />' . "\n";
        echo '<meta name="keywords" content="' . $keywords . '" />' . "\n";
        echo '<meta property="og:title" content="' . $title . '" />' . "\n";
        echo '<meta property="og:image" content="' . $citra . '" />' . "\n";
		echo '<meta property="og:image:secure_url" content="' . $secure_url . '" />' . "\n";
		echo '<meta property="og:image:type" content="image/jpeg" />' . "\n";
		echo '<meta property="og:image:height" content="' . $heightx . '" />' . "\n";
		echo '<meta property="og:image:width" content="' . $widthx . '" />' . "\n";
		echo '<meta content="follow,all" name="googlebot-image"/>' . "\n";
		echo '<meta content="follow,all" name="msnbot"/>' . "\n";
		echo '<meta content="follow,all" name="alexabot"/>' . "\n";
		echo '<meta content="follow,all" name="ZyBorg"/>' . "\n";
		echo '<meta content="follow,all" name="Scooter"/>' . "\n";
		echo '<meta content="all,index,follow" name="spiders"/>' . "\n";
		echo '<meta content="all,index,follow" name="webcrawlers"/>' . "\n";
		echo '<meta content="all,index,follow" name="SLURP"/>' . "\n";
		echo '<meta content="all,index,follow" name="yahoobot"/>' . "\n";
		echo '<meta content="all,index,follow" name="bingbot"/>' . "\n";
		echo '<meta content="10" name="pagerank"/>' . "\n";
		echo '<meta content="100" name="alexa"/>' . "\n";
		echo '<meta content="1,2,3,10,11,12,13,ATF" name="serps"/>' . "\n";
		echo '<meta content="no" http-equiv="imagetoolbar"/>' . "\n";
		echo '<meta content="no-cache" http-equiv="cache-control"/>' . "\n";
		echo '<meta content="no-cache" http-equiv="pragma"/>' . "\n";
		echo '<meta content="Aeiwi, Alexa, AllTheWeb, AltaVista, AOL Netfind, Anzwers, Canada, DirectHit, EuroSeek, Excite, Overture, Go, Google, HotBot. InfoMak, Kanoodle, Lycos, MasterSite, National Directory, Northern Light, SearchIt, SimpleSearch, WebsMostLinked, WebTop, What-U-Seek, AOL, Yahoo, WebCrawler, Infoseek, Excite, Magellan, LookSmart, bing, CNET, Googlebot" name="search engines"/>' . "\n";
		echo '<link rel="canonical" href="'. get_bloginfo('wpurl').'/'.$permalink .'" />';
		// echo '<link rel="canonical" href="'. get_bloginfo('wpurl').$permalinkx .'" />';
    
}

/* Parse feed title for next randomness */
function vm_agc_parse_title($keyword) {
	$title	= preg_replace("/[^A-Za-z0-9 ]/", ' ', $keyword);
	$title	= trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $title));
	$title	= str_replace(array('_','/'),' ',$title);
	$title	= trim(ucwords($title));
	$url	= str_replace(' ','-',strtolower($title));
	$parsed	= '<a href="/'.$url.'" title="'.$title.'" >'.$title.'</a>';
	
	return $parsed;
}

/* Generate Faux Related Posts */
function vm_agc_parse_related_posts($keyword, $num=3) {
    $vm_nofollow = get_option('vmagc_break_engine');
    if ($vm_nofollow == true)
    {
        $vm_rel_break = "nofollow";
    }else {
        $vm_rel_break = "dofollow";
    }
	$heightx = get_option( 'thumbnail_size_h' );
	$widthx = get_option( 'thumbnail_size_w' );
	$images_feed = vm_agc_images( $keyword, $num, 'SMALL' );
	$items_feed = vm_agc_items($keyword, $num);
	
	$output = '<h3 class="related-posts">Related Posts to ' . $keyword .'</h3>' . "\n";
	$output .= "<ul>\n";
	for ($i=0;$i<$num;$i++) {
		$title	= preg_replace("/[^A-Za-z0-9 ]/", ' ', $items_feed[$i]['title']);
		$title	= trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $title));
		$title	= str_replace(array('_','/'),' ',$title);
		$title	= trim(ucwords($title));
		$url	= str_replace(' ','-',strtolower($title));

		$output .="<li class='related-post-item'>\n\t<a class='relatedthumb' href='".home_url('/')."{$url}' title='{$title}' rel='{$vm_rel_break}'><span class='rthumb'> <img width='{$widthx}' height='{$heightx}' src='{$images_feed[$i]}' class='attachment-widgetthumb wp-post-image' alt='{$title}' > </span><span>{$items_feed[$i]['title']} </span></a><p>{$items_feed[$i]['description']}</p></li>" . "\n";
	}
	$output .= "</ul>\n";
	
	return $output;
}

/* Generate Faux Search Results */
function vm_agc_parse_search_results($keyword, $num=NULL) {
	if ( NULL === $num )
		$num = get_option( 'posts_per_page' );
	
	$heightx = get_option( 'thumbnail_size_h' );
	$widthx = get_option( 'thumbnail_size_w' );
	$images_feed = vm_agc_images( $keyword, $num, 'MEDIUM' );
	$items_feed = vm_agc_items($keyword, $num);
	
	$output = '<div class="related-post">' . "\n";
	$output .= "<ul style='display: inline-block;'>\n";
	for ($i=0;$i<$num;$i++) {
		$title	= preg_replace("/[^A-Za-z0-9 ]/", ' ', $items_feed[$i]['title']);
		$title	= trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $title));
		$title	= str_replace(array('_','/'),' ',$title);
		$title	= trim(ucwords($title));
		$url	= str_replace(' ','-',strtolower($title));
		
		$output .="<li class='related-post-item'>\n\t<a class='relatedthumb' href='".home_url('/')."{$url}' title='{$title}'><span class='rthumb'> <img width='{$widthx}' height='{$heightx}' src='{$images_feed[$i]}' class='attachment-widgetthumb wp-post-image' alt='{$title}' > </span><span>{$items_feed[$i]['title']} </span></a><p>{$items_feed[$i]['description']}</p></li>" . "\n";
	}
	$output .= "</ul>\n";
	$output .= "</div>\n";
	
	return $output;
}

/* Generate Faux Search Objects */
function vm_agc_generate_search_results($keyword, $num=NULL) {
	if ( NULL === $num )
		$num = get_option( 'posts_per_page' );
	
	$heightx = get_option( 'thumbnail_size_h' );
	$widthx = get_option( 'thumbnail_size_w' );
	$images_feed = vm_agc_images( $keyword, $num, 'MEDIUM' );
	$items_feed = vm_agc_items($keyword, $num);
	$last = wp_get_recent_posts( array(
				'numberposts' => 1)
			);
	$last_id = $last['0']['ID'];
	$max_id = $last_id + 100;
	
	for ($i=0;$i<$num;$i++) {
		if ( isset($items_feed[$i]) ) {
			$title	= preg_replace("/[^A-Za-z0-9 ]/", ' ', $items_feed[$i]['title']);
			$title	= trim(preg_replace('/[\s\t\n\r\s]+/', ' ', $title));
			$title	= str_replace(array('_','/'),' ',$title);
			$title	= trim(ucwords($title));
			$url	= str_replace(' ','-',strtolower($title));
			
			$sr['id']		= rand ( $last_id, $max_id );
			$sr['cat']		= array('uncategorized');
			$sr['content']	= $items_feed[$i]['description'];
			$sr['excerpt']	= $items_feed[$i]['description'];
			$sr['title']	= $items_feed[$i]['title'];
			$sr['thumbnail']= $images_feed[$i];
			$sr['slug']		= $url;
			
			
		}
		
		$arr_result[] = $sr;
	}
	
	return $arr_result;
}

// Make sure no auto-paragraph is added.
remove_filter( 'the_content', 'wpautop' );

// Load AdSense JS
add_shortcode('vmagc_adsense', 'vm_agc_load_adsense');
function vm_agc_load_adsense( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'size' => '300',
		), $atts )
	);
	
	switch ($size) {
        case '160':
			$show_adsense = get_option('vmagc_show_adsense_160');
			$adsense_code = get_option('vmagc_adsense_code_160');
			$limit_adsense_show = get_option('vmagc_show_limit');
            break;
        case '300':
			$show_adsense = get_option('vmagc_show_adsense_300');
			$adsense_code = get_option('vmagc_adsense_code_300');
			$limit_adsense_show = get_option('vmagc_show_limit');
            break;
        case '728':
			$show_adsense = get_option('vmagc_show_adsense_728');
			$adsense_code = get_option('vmagc_adsense_code_728');
			$limit_adsense_show = get_option('vmagc_show_limit');
            break;
    }

	// custom filter for badwords
	// taking references from http://badword.website/keyword.txt
	$permalink	= $_SERVER['REQUEST_URI'];
	$permalinkx	= $_SERVER['REQUEST_URI'];
	$permalinky	= explode('?',$permalink);
	$permalinky	= $permalinky[0];
	$permalink	= explode('/',$permalinkx);
	$permalinkz = $permalink[1];
	$permalink	= $permalink[1];
	$permalink	= explode('?',$permalink);
	$permalink	= $permalink[0];
	$title    	= urldecode(str_replace(array('/','-','+','-','%7C','jpg','php','gif','html','Blogspot','Com','.com','http','Wikipedia'),' ',$permalink));
	if ( true === vm_agc_check_badwords($title) )
		$show_adsense = false;
	
	if ( $show_adsense ) :
		if ( $limit_adsense_show ) {
			if ( vm_agc_from_searchengine() ) {
				$adsense_part = stripslashes($adsense_code);
			}
		}
		else {
			$adsense_part = stripslashes($adsense_code);
		}
	endif;
	
	$output = '';
	
	if ( !empty( $adsense_part ) ) {
		$output .= "<div class='cfmonitor'>$adsense_part</div>";
	}
	return $output;
}

// helper function
function vm_agc_isset_get($array, $key, $default = null) {
    return isset($array[$key]) ? $array[$key] : $default;
}

// Keyword Showter Function //

function ks_function_prepare_searchterms_widget( $searchterms, $list=true, $search=true ){
	global $post;
	$toReturn = ( $list ) ? '<ul>' : '';
	foreach($searchterms as $term){
			$toReturn .= ( $list ) ? '<li>' : '';
			if ( !$search ) {
				$permalink = ( 0 == $term->post_id ) ? get_bloginfo('url') : get_permalink($term->post_id);
			} else {
				$permalink = get_bloginfo( 'url' ).'/'.user_trailingslashit(ks_function_sanitize_search_link($term->terms));
			}
			$toReturn .= "<a href=\"$permalink\" title=\"$term->terms\">$term->terms</a>";
			$toReturn .= ( $list ) ? '</li>' : ', ';
		}
	$toReturn = trim($toReturn,', ');
	$toReturn .= ( $list ) ? '</ul>' : '';
	//$toReturn = htmlspecialchars_decode($toReturn);
	//$toReturn .= PK_WATERMARK;
	return $toReturn;
}

function ks_function_sanitize_search_link($title) {
	$title = strip_tags($title);
	// Preserve escaped octets.
	$title = preg_replace('|%([a-fA-F0-9][a-fA-F0-9])|', '---$1---', $title);
	// Remove percent signs that are not part of an octet.
	$title = str_replace('%', '', $title);
	// Restore octets.
	$title = preg_replace('|---([a-fA-F0-9][a-fA-F0-9])---|', '%$1', $title);
	$title = remove_accents($title);
	if (seems_utf8($title)) {
	   if (function_exists('mb_strtolower')) {
		   $title = mb_strtolower($title, 'UTF-8');
	   }
	   $title = utf8_uri_encode($title);
	}
	$title = strtolower($title);
	$title = preg_replace('/&.+?;/', '', $title); // kill entities
	$title = preg_replace('/[^%a-z0-9 _-]/', '', $title);
	$title = preg_replace('/\s+/', '-', $title);
	$title = preg_replace('|-+|', '-', $title);
	$title = trim($title, '-');
	return $title;
}

function ks_save_term($term){
	global $wpdb;

	// buat jadi lower case sebelum insert
	$term = strtolower(trim($term));
	if(empty($term)) return false;

	$success = $wpdb->query( $wpdb->prepare( "INSERT IGNORE INTO ".$wpdb->prefix."keyword_showter (`terms`) VALUES ( %s )", $term ) );
	return $success;
}

function ks_random_terms_widget( $atts ) {

	// Attributes
	extract( shortcode_atts(
		array(
			'count' => '10',
		), $atts )
	);
    $searchterms = ks_db_get_random_terms($count);
    $result = ks_function_prepare_searchterms_widget($searchterms,"1","1");
    return $result;
}
add_shortcode('ks_random_search', 'ks_random_terms_widget');
add_filter( 'widget_text', 'do_shortcode' );
function ks_db_get_random_terms( $count ){
	$result = wp_cache_get( 'ks_random_terms' );
	if ( false == $result ) {
		global $wpdb;
		$result = $wpdb->get_results( "SELECT `terms` FROM `".$wpdb->prefix."keyword_showter` ORDER BY RAND() LIMIT ".$count.";" );
		wp_cache_set( 'ks_random_terms', $result, 3600 );
	}
	return $result;
}

// Generated Sitemap //

if(get_option('vmagc_inject_sitemap') == "true") {
add_action("sm_buildmap", "VM_generate_sitemap");
}
