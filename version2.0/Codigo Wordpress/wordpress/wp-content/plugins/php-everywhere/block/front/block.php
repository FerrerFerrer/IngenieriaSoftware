<?php
// block.php

function php_everywhere_render_block($attributes, $content) {
    ob_start();
	eval(' ?>'.urldecode(base64_decode($attributes['code'])).'<?php ');
	$var = ob_get_contents();
	ob_end_clean();
	return $var;
}
