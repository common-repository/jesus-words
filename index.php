<?php 
/*
Plugin Name: Jesus Words Plugin
Description: The daily words of Jesus
Version: 1.1
Author: dejavuproductionsthlm
Author URI: http://dejavuproduction.se
License: GPLv2
*/



class jesusWords extends WP_Widget {
     
    function __construct() {
    	parent::__construct(
         
	        // base ID of the widget
	        'jesusWords',
	         
	        // name of the widget
	        __('Jesus Words Widget', 'jesusWordsPlugin' ),
	         
	        // widget options
	        array (
	            'description' => __( 'Widget to display Daily Quotes.', 'jesusWordsPlugin' )
	        )
	         
	    );
    }
     
    function form( $instance ) {
    }
     
    function update( $new_instance, $old_instance ) {       
    }
     
    function widget( $args, $instance ) {

    	$content = array();

        $file = plugin_dir_path(__FILE__) . 'dailyquotes.txt';
		
		$date = Date('d-m-Y');

		$cont = explode("\n", file_get_contents($file));

		$content = str_replace(".", "", $cont);

		$res = json_decode(get_option('row_name'),true);

		if(isset($res["date"]) && Date('d-m-Y') == $res["date"]){
			
			$imgpath = plugin_dir_path(__FILE__) . 'jesus.png';

			echo "<div class='Jesus Words Widget'>";

			echo "<img style='display: block;margin: auto;' src='".plugins_url('jesus.png',__FILE__)."' alt='Jesus' align='middle'>";
			
			echo "<blockquote>".$res['content']."</blockquote>";
            
            echo '<a href="http://dejavuproduction.se">Jesus Words</a>';
                        
			echo "</div>";
            

		}else{
			$rand_keys = array_rand($content);

			$newoption = sanitize_text_field($content[$rand_keys]);

			$data["date"] =  Date('d-m-Y');
			$data["content"] = $newoption;

			update_option( 'row_name', json_encode($data));

			echo "<div class='Jesus Words Widget'>";

			echo "<img style='display: block;margin: auto;' src='".plugins_url('jesus.png',__FILE__)."' alt='Jesus' align='middle'>";
			
			echo "<p>".$newoption."</p>";

			echo "</div>";
		}

    }
     
}

function jesus_words_widget() {
 
    register_widget( 'jesusWords' );
 
}

add_action( 'widgets_init', 'jesus_words_widget' );




?>