<?php
if ( ! defined( 'ABSPATH' ) )
	exit;

global $wpdb;
$_GET = stripslashes_deep($_GET);
$xyz_ips_message =$search_name_db=$search_name= '';

if(isset($_GET['xyz_ips_msg'])){
	$xyz_ips_message = intval($_GET['xyz_ips_msg']);
}
if($_POST)
{
    if(isset($_POST['search']))
    {
        if(!isset($_REQUEST['_wpnonce'])||!wp_verify_nonce($_REQUEST['_wpnonce'],'snipp-manage_') ){
            wp_nonce_ays( 'snipp-manage_' );
            exit;
        }
    }
    if(isset($_POST['textFieldButton2']))
    {
        if(!isset($_REQUEST['_wpnonce'])||!wp_verify_nonce($_REQUEST['_wpnonce'],'bulk_actions_ips') ){
            wp_nonce_ays( 'bulk_actions_ips' );
            exit;
        }
    }
	if (isset($_POST['apply_ips_bulk_actions'])){
		if (isset($_POST['ips_bulk_actions_snippet'])){
			$ips_bulk_actions_snippet=$_POST['ips_bulk_actions_snippet'];
			if (isset($_POST['xyz_ips_snippet_ids']))
				$xyz_ips_snippet_ids = $_POST['xyz_ips_snippet_ids'];
 				$xyz_ips_pageno = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
 				if (empty($xyz_ips_snippet_ids))
				{
					header("Location:".admin_url('admin.php?page=insert-php-code-snippet-manage&xyz_ips_msg=8&pagenum='.$xyz_ips_pageno));
					exit();
				}
				if ($ips_bulk_actions_snippet==2)//bulk-delete
				{
					foreach ($xyz_ips_snippet_ids as $snippet_id)
					{
						$wpdb->query($wpdb->prepare( 'DELETE FROM  '.$wpdb->prefix.'xyz_ips_short_code  WHERE id=%d',$snippet_id)) ;
					}
					header("Location:".admin_url('admin.php?page=insert-php-code-snippet-manage&xyz_ips_msg=3&pagenum='.$xyz_ips_pageno));
					exit();
				}
				elseif ($ips_bulk_actions_snippet==0)//bulk-Deactivate
				{
					foreach ($xyz_ips_snippet_ids as $xyz_ips_snippetId)
						$wpdb->update($wpdb->prefix.'xyz_ips_short_code', array('status'=>2), array('id'=>$xyz_ips_snippetId));
						header("Location:".admin_url('admin.php?page=insert-php-code-snippet-manage&xyz_ips_msg=4&pagenum='.$xyz_ips_pageno));
						exit();
				}
				elseif ($ips_bulk_actions_snippet==1)//bulk-activate
				{
					foreach ($xyz_ips_snippet_ids as $xyz_ips_snippetId)
						$wpdb->update($wpdb->prefix.'xyz_ips_short_code', array('status'=>1), array('id'=>$xyz_ips_snippetId));
						header("Location:".admin_url('admin.php?page=insert-php-code-snippet-manage&xyz_ips_msg=4&pagenum='.$xyz_ips_pageno));
						exit();
				}
				elseif ($ips_bulk_actions_snippet==-1)//no action selected
				{
					header("Location:".admin_url('admin.php?page=insert-php-code-snippet-manage&xyz_ips_msg=7&pagenum='.$xyz_ips_pageno));
					exit();
				}
		}

	}

}
if($xyz_ips_message == 1){

	?>
<div class="xyz_system_notice_area_style1" id="xyz_system_notice_area">
PHP Snippet successfully added.&nbsp;&nbsp;&nbsp;<span
id="xyz_system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($xyz_ips_message == 2){

	?>
<div class="xyz_system_notice_area_style0" id="xyz_system_notice_area">
PHP Snippet not found.&nbsp;&nbsp;&nbsp;<span
id="xyz_system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($xyz_ips_message == 3){

	?>
<div class="xyz_system_notice_area_style1" id="xyz_system_notice_area">
PHP Snippet successfully deleted.&nbsp;&nbsp;&nbsp;<span
id="xyz_system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($xyz_ips_message == 4){

	?>
<div class="xyz_system_notice_area_style1" id="xyz_system_notice_area">
PHP Snippet status successfully changed.&nbsp;&nbsp;&nbsp;<span
id="xyz_system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($xyz_ips_message == 5){

	?>
<div class="xyz_system_notice_area_style1" id="xyz_system_notice_area">
PHP Snippet successfully updated.&nbsp;&nbsp;&nbsp;<span
id="xyz_system_notice_area_dismiss">Dismiss</span>
</div>
<?php

}
if($xyz_ips_message == 7)
{
	?>
	<div class="xyz_system_notice_area_style1" id="xyz_system_notice_area">
		Please select an action to apply.&nbsp;&nbsp;&nbsp;
		<span id="xyz_system_notice_area_dismiss">Dismiss</span>
	</div>
<?php
}
if($xyz_ips_message == 8)
{
	?>
	<div class="xyz_system_notice_area_style1" id="xyz_system_notice_area">
		Please select at least one snippet to perform this action.&nbsp;&nbsp;&nbsp;
		<span id="xyz_system_notice_area_dismiss">Dismiss</span>
	</div>
<?php
}
?>
<div >


	<form method="post">
	<?php wp_nonce_field( 'bulk_actions_ips');?>
		<fieldset
			style="width: 99%; border: 1px solid #F7F7F7; padding: 10px 0px;">
			<legend><h3>PHP Code Snippets</h3></legend>
			<?php
			global $wpdb;
 			$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
			$limit = get_option('xyz_ips_limit');
			$offset = ( $pagenum - 1 ) * $limit;


			$field=get_option('xyz_ips_sort_field_name');
			$order=get_option('xyz_ips_sort_order');
			if(isset($_POST['snippet_name']))
			{
			$search_name=sanitize_text_field($_POST['snippet_name']);
			$search_name_db=esc_sql($search_name);
			}

			$entries = $wpdb->get_results( "SELECT * FROM ".$wpdb->prefix."xyz_ips_short_code  	WHERE title like '%".$search_name_db."%'"." ORDER BY  $field $order LIMIT $offset,$limit" );


			?>
			<input  id="xyz_ips_submit_ips"
				style="cursor: pointer; margin-bottom:10px; margin-left:8px;" type="button"
				name="textFieldButton2" value="Add New PHP Code Snippet"
				 onClick='document.location.href="<?php echo admin_url('admin.php?page=insert-php-code-snippet-manage&action=snippet-add');?>"'>
			<br>
<span style="padding-left: 6px;color:#21759B;">With Selected : </span>
 <select name="ips_bulk_actions_snippet" id="ips_bulk_actions_snippet" style="width:130px;height:29px;">
	<option value="-1">Bulk Actions</option>
	<option value="0">Deactivate</option>
	<option value="1">Activate</option>
	<option value="2">Delete</option>
</select>
<input type="submit" title="Apply" name="apply_ips_bulk_actions" value="Apply" style="color:#21759B;cursor:pointer;padding: 5px;background:linear-gradient(to top, #ECECEC, #F9F9F9) repeat scroll 0 0 #F1F1F1;border: 2px solid #DFDFDF;">



<form name="manage_snippets" action="" method="post">
							         <?php wp_nonce_field('snipp-manage_');?>
							<div class="xyz_ips_search_div"  style="float:right;">
				            	<table class="xyz_ips_search_div_table" style="width:100%;">
				                	<tr>


				                  		 	 <input type="text" name="snippet_name" value= "<?php if(isset($search_name)){echo esc_attr($search_name);}?>" placeholder="Search" >
				                   			<input type="submit" name="search" value="Go" />

				              		</tr>
				           		</table>
	          				</div>
</form>





			<table class="widefat" style="width: 99%; margin: 0 auto; border-bottom:none;">
				<thead>
					<tr>
					    <th scope="col" width="3%"><input type="checkbox" id="chkAllSnippets" /></th>
						<th scope="col" >Tracking Name</th>
						<th scope="col" >Snippet Short Code</th>
						<th scope="col" >Status</th>
						<th scope="col" colspan="3" style="text-align: center;">Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					if( count($entries)>0 ) {
						$count=1;
						$class = '';
						foreach( $entries as $entry ) {
							$class = ( $count % 2 == 0 ) ? ' class="alternate"' : '';
							$snippetId=intval($entry->id);
							?>
					<tr <?php echo $class; ?>>
					<td style="vertical-align: middle !important;padding-left: 18px;">
					<input type="checkbox" class="chk" value="<?php echo $snippetId; ?>" name="xyz_ips_snippet_ids[]" id="xyz_ips_snippet_ids" />
					</td>
						<td id="xyz_ips_vAlign"><?php
						echo esc_html($entry->title);
						?></td>
						<td id="xyz_ips_vAlign"><?php
						if($entry->status == 2){echo 'NA';}
						else
						echo '[xyz-ips snippet="'.esc_html($entry->title).'"]';
						?></td>
						<td id="xyz_ips_vAlign">
							<?php
								if($entry->status == 2){
									echo "Inactive";
								}elseif ($entry->status == 1){
								echo "Active";
								}

							?>
						</td>
						<?php
								if($entry->status == 2){
									$stat1 = admin_url('admin.php?page=insert-php-code-snippet-manage&action=snippet-status&snippetId='.$snippetId.'&status=1&pageno='.$pagenum);
						?>
						<td style="text-align: center;"><a
							href='<?php echo wp_nonce_url($stat1,'ips-pstat_'.$snippetId); ?>'><img
								id="xyz_ips_img" title="Activate"
								src="<?php echo plugins_url('images/activate.png',XYZ_INSERT_PHP_PLUGIN_FILE)?>">
						</a>
						</td>
							<?php
								}elseif ($entry->status == 1){
									$stat2 = admin_url('admin.php?page=insert-php-code-snippet-manage&action=snippet-status&snippetId='.$snippetId.'&status=2&pageno='.$pagenum);
								?>
						<td style="text-align: center;"><a
							href='<?php echo wp_nonce_url($stat2,'ips-pstat_'.$snippetId); ?>'><img
								id="xyz_ips_img" title="Deactivate"
								src="<?php echo plugins_url('images/pause.png',XYZ_INSERT_PHP_PLUGIN_FILE)?>">
						</a>
						</td>
								<?php
								}

							?>

						<td style="text-align: center;"><a
							href='<?php echo admin_url('admin.php?page=insert-php-code-snippet-manage&action=snippet-edit&snippetId='.$snippetId.'&pageno='.$pagenum); ?>'><img
								id="xyz_ips_img" title="Edit Snippet"
								src="<?php echo plugins_url('images/edit.png',XYZ_INSERT_PHP_PLUGIN_FILE)?>">
						</a>
						</td>

						<?php $delurl = admin_url('admin.php?page=insert-php-code-snippet-manage&action=snippet-delete&snippetId='.$snippetId.'&pageno='.$pagenum);?>
						<td style="text-align: center;" ><a
							href='<?php echo wp_nonce_url($delurl,'ips-pdel_'.$snippetId); ?>'
							onclick="javascript: return confirm('Please click \'OK\' to confirm ');"><img
								id="xyz_ips_img" title="Delete Snippet"
								src="<?php echo plugins_url('images/delete.png',XYZ_INSERT_PHP_PLUGIN_FILE)?>">
						</a></td>
					</tr>
					<?php
					$count++;
						}
					} else { ?>
					<tr>
						<td colspan="6" >PHP Code Snippets not found</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>

			<input  id="xyz_ips_submit_ips"
				style="cursor: pointer; margin-top:10px;margin-left:8px;" type="button"
				name="textFieldButton2" value="Add New PHP Code Snippet"
				 onClick='document.location.href="<?php echo admin_url('admin.php?page=insert-php-code-snippet-manage&action=snippet-add');?>"'>

			<?php
			$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM ".$wpdb->prefix."xyz_ips_short_code" );
			$num_of_pages = ceil( $total / $limit );

			$page_links = paginate_links( array(
					'base' => add_query_arg( 'pagenum','%#%'),
				    'format' => '',
				    'prev_text' =>  '&laquo;',
				    'next_text' =>  '&raquo;',
				    'total' => $num_of_pages,
				    'current' => $pagenum
			) );



			if ( $page_links ) {
				echo '<div class="tablenav" style="width:99%"><div class="tablenav-pages" style="margin: 1em 0">' . $page_links . '</div></div>';
			}

			?>

		</fieldset>

	</form>

</div>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery("#chkAllSnippets").click(function(){
		jQuery(".chk").prop("checked",jQuery("#chkAllSnippets").prop("checked"));
    });
});
</script>
