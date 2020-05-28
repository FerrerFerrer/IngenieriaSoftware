<?php
//[php_everywhere]
function php_everywhere_func( $atts,$content = null  ){
	$param = shortcode_atts( array(
        'instance' => "",
    ), $atts );
	$instance = "";
	$instance = $param['instance'];
	$content = htmlspecialchars_decode($content);
	$content = str_replace("&#8216;","'",$content);
	$content = str_replace("&#8217;","'",$content);
	echo($content);
	ob_start();
	eval(' ?>'.$content.'<?php ');
	eval(' ?>'.get_post_meta( get_the_ID(),'php_everywhere_code',true).'<?php ');
	$var = ob_get_contents();
	ob_end_clean();
	return $var;
}
?>