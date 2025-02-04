<?php

function VM_generate_sitemap() {
	if(class_exists('GoogleSitemapGenerator')){
		$generatorObject = &GoogleSitemapGenerator::GetInstance();
		if($generatorObject!=null) {
			global $wpdb;
			// Let's get some keywords
			$terms = $wpdb->get_col( "SELECT `terms` FROM `".$wpdb->prefix."keyword_showter` WHERE `post_id` != 0 ORDER BY RAND() LIMIT 25000" );
			$x=1000;
			foreach ($terms as $term) {
				$keyword = str_replace(" ","-",$term);
				$domain = $_SERVER['HTTP_HOST'];
				$url = "http://". $domain ."/". $keyword . "/";
				$generatorObject->AddUrl($url, time(), "Daily",0.6,$x);
				$x++;
			}
		}
	}
}
?>