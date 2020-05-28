<?php
if ( ! defined( 'ABSPATH' ) )
	 exit;
?>
<style>
	a.xyz_header_link:hover{text-decoration:underline;}
	.xyz_header_link{text-decoration:none;}
</style>

<?php
if(isset($_POST['xyz_ips_pre_ads'])){
	$xyz_ips_pre_ads = intval($_POST['xyz_ips_pre_ads']);
	update_option('xyz_ips_premium_version_ads',$xyz_ips_pre_ads);
}

/*
if(get_option('xyz_ips_premium_version_ads')==1){

	?>
<div id="xyz-ips-premium">

	<div style="float: left; padding: 0 5px">
		<h2 style="vertical-align: middle;">
			<a target="_blank" href="https://xyzscripts.com/wordpress-plugins/xyz-wp-insert-code-snippet/details">Fully Featured XYZ WP Insert Code Snippet Premium Plugin</a> - Just 19 USD
		</h2>
	</div>
	<div style="float: left; margin-top: 3px">
		<a target="_blank"
			href="https://xyzscripts.com/members/product/purchase/XYZWPICSPRE"><img
			src="<?php  echo plugins_url("images/orange_buynow.png",XYZ_INSERT_PHP_PLUGIN_FILE); ?>">
		</a>
	</div>
	<div style="float: left; padding: 0 5px">
	<h2 style="vertical-align: middle;text-shadow: 1px 1px 1px #686868">
			( <a 	href="<?php echo admin_url('admin.php?page=insert-php-code-snippet-about');?>">Compare Features</a> )
	</h2>
	</div>
</div>
<?php
}
*/

if($_POST && isset($_POST['xyz_ips_credit']))
{
	if (! isset( $_REQUEST['_wpnonce'] )|| ! wp_verify_nonce( $_REQUEST['_wpnonce'],'ips-psetting_')){
		wp_nonce_ays( 'ips-psetting_' );
		exit;
	}
	$xyz_ips_credit_link=sanitize_text_field($_POST['xyz_ips_credit']);
	update_option('xyz_credit_link', $xyz_ips_credit_link);
}


if(!$_POST && isset($_GET['ips_blink'])&&isset($_GET['ips_blink'])=='en'){
	if (! isset( $_REQUEST['_wpnonce'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce'],'ips-blk')){
		wp_nonce_ays( 'ips-blk');
		exit;
	}
	update_option('xyz_credit_link',"ips");
?>
<div class="xyz_system_notice_area_style1" id="xyz_system_notice_area">
Thank you for enabling backlink.
 &nbsp;&nbsp;&nbsp;<span id="xyz_system_notice_area_dismiss">Dismiss</span>
</div>

<style type="text/css">
	.xyz_blink{
		display:none !important;
	}
</style>
<?php
}

if((get_option('xyz_credit_link')=="0")&&(get_option('xyz_ips_credit_dismiss')=="0")){
	?>
<div style="float:left;background-color: #FFECB3;border-radius:5px;padding: 0px 5px;margin-top: 10px;border: 1px solid #E0AB1B" id="xyz_ips_backlink_div">

	Please do a favour by enabling backlink to our site. <a id="xyz_ips_backlink" style="cursor: pointer;" >Okay, Enable</a>. <a id="xyz_ips_dismiss" style="cursor: pointer;" >Dismiss</a>.
<script type="text/javascript">
		jQuery(document).ready(function() {
			jQuery('#xyz_ips_backlink').click(function(){
				xyz_filter_blink(1)
			});

			jQuery('#xyz_ips_dismiss').click(function(){
				xyz_filter_blink(-1)
			});

			function xyz_filter_blink(stat){

				<?php $ajax_fltr_nonce = wp_create_nonce( "xyz-ips-blink" );?>
				var dataString = {
					action: 'ips_backlink',
					security:'<?php echo $ajax_fltr_nonce; ?>',
					enable: stat
				};

				jQuery.post(ajaxurl, dataString, function(response) {

					if(response==1){
						jQuery("#xyz_ips_backlink_div").html('Thank you for enabling backlink!');
					 	jQuery("#xyz_ips_backlink_div").css('background-color', '#D8E8DA');
						jQuery("#xyz_ips_backlink_div").css('border', '1px solid #0F801C');
						jQuery("select[id=xyz_ips_credit] option[value=ips]").attr("selected", true);
					}

					if(response==-1){
						jQuery("#xyz_ips_backlink_div").remove();

					}

				});
			}
		});

</script>
</div>
	<?php
}
?>

<style>
#text {margin:50px auto; width:500px}
.hotspot {color:#900; padding-bottom:1px; border-bottom:1px dotted #900; cursor:pointer}

#tt {position:absolute; display:block; }
#tttop {display:block; height:5px; margin-left:5px;}
#ttcont {display:block; padding:2px 10px 3px 7px;  margin-left:-400px; background:#666; color:#FFF}
#ttbot {display:block; height:5px; margin-left:5px; }
</style>





<div style="margin-top: 10px">
<table style="float:right; ">
<tr>
<td  style="float:right;" >
	<a  class="xyz_header_link" style="margin-left:8px;margin-right:12px;"   target="_blank" href="http://xyzscripts.com/donate/5">Donate</a>
</td>
<td style="float:right;">
	<a class="xyz_header_link" style="margin-left:8px;" target="_blank" href="http://help.xyzscripts.com/docs/insert-php-code-snippet/faq/">FAQ</a>
</td>
<td style="float:right;">
	<a class="xyz_header_link" style="margin-left:8px;" target="_blank" href="http://help.xyzscripts.com/docs/insert-php-code-snippet/">Readme</a>
</td>
<td style="float:right;">
	<a class="xyz_header_link" style="margin-left:8px;" target="_blank" href="https://xyzscripts.com/wordpress-plugins/insert-php-code-snippet/details">About</a>
</td>
<td style="float:right;">
	<a class="xyz_header_link" target="_blank" href="https://xyzscripts.com">XYZScripts</a>
</td>

</tr>
</table>
</div>

<div style="clear: both"></div>
