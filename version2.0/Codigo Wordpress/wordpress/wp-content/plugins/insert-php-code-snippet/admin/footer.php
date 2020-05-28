<?php
if ( ! defined( 'ABSPATH' ) )
     exit;
if(get_option('xyz_ips_premium_version_ads')==1){ ?>
<div id="xyz-ips-premium">

    <div style="float: left; padding: 0 5px">
        <h2 style="vertical-align: middle;">
            <a target="_blank"
            href="https://xyzscripts.com/wordpress-plugins/xyz-wp-insert-code-snippet/details">Fully Featured XYZ WP Insert Code Snippet Premium Plugin</a>
            - Just 19 USD
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
            ( <a    href="<?php echo admin_url('admin.php?page=insert-php-code-snippet-about');?>">Compare Features</a> )
    </h2>
    </div>
</div>
<?php
    }
?>
<div style="clear: both;">
</div>
<div style="width: 100%">
    <div class="xyz_ips_social_media">
        <h3 class="xyz_ips_inner_head">
            Follow Us 
        </h3>
        <a target="_blank" href="http://facebook.com/xyzscripts" class="xyz_home_fbook"></a>
        <a target="_blank" href="http://twitter.com/xyzscripts" class="xyz_home_twitt"></a>
        <a target="_blank" href="https://plus.google.com/+Xyzscripts/" class="xyz_home_gplus"></a>
        <a style="margin-right:0px;" target="_blank" href="https://www.linkedin.com/company/xyzscripts" class="xyz_home_linkedin"></a>
    </div>
    <div class="xyz_ips_sugession">
        <h3 class="xyz_ips_inner_head"> Support</h3>
	  <p  style="width:100%;"><a target="_blank" href="https://xyzscripts.com/donate/5" >Donate</a></p>
      <p  style="width:100%;"><a target="_blank" href="https://xyzscripts.com/support/" >Contact Us</a></p>
      <p  ><a target="_blank" href="https://wordpress.org/support/plugin/insert-php-code-snippet/reviews/" >Please Rate Us
       </a></p>
       <a target="_blank" href="https://wordpress.org/support/plugin/insert-php-code-snippet/reviews/" ><span class="xyz_new_star"></span></a>
       <p  style="width:100%;"><a target="_blank" href="https://wordpress.org/support/plugin/insert-php-code-snippet/" >Create a ticket at Wordpress forum</a>
       </p>    
    </div> 
    <div class="xyz_ips_new_subscribe">
        <h3 class="xyz_ips_inner_head">
            Stay tuned for our updates
        </h3>
        <script language="javascript">
            function check_email(emailString)
            {
                var mailPattern = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,})$/;
                var matchArray = emailString.match(mailPattern);
                if (emailString.length == 0)
                    return false;
                if (matchArray == null)    {
                    return false;
                }else{
                    return true;
                }
            }
            function verify_lists(form)
            {
                var total=0;
                var checkBox=form['chk[]'];
                if(checkBox.length){
                    for(var i=0;i<checkBox.length;i++){
                        checkBox[i].checked?total++:null;
                    }
                }
                else{
                    checkBox.checked?total++:null;
                }
                if(total>0){
                    return true;
                }
                else{
                    return false;
                }
            }
            function verify_fields()
            {
                if(check_email(document.email_subscription.email.value) == false){
                    alert("Please check whether the email is correct.");
                    document.email_subscription.email.select();
                    return false;
                }
                else if(verify_lists(document.email_subscription)==false){
                    alert("Select atleast one list.");
                }
                else{
                    document.email_subscription.submit();
                }
            }
        </script>
        <?php global $current_user; wp_get_current_user();?>
<form action="https://xyzscripts.com/newsletter/index.php?page=list/subscribe" method="post" name="email_subscription" id="email_subscription" target="_blank">
<input type="hidden" name="fieldNameIds" value="1,">
<input type="hidden" name="redirActive" value="http://xyzscripts.com/subscription/pending/XYZWPIPSFRE">
<input type="hidden" name="redirPending" value="http://xyzscripts.com/subscription/active/XYZWPIPSFRE">
<input type="hidden" name="mode" value="1">

<input class="xyz_ips_name"  type="text" placeholder="Name" name="field1" value="<?php
if ($current_user->user_firstname != "" || $current_user->user_lastname != "")
{
    echo $current_user->user_firstname . " " . $current_user->user_lastname;
}
else if (strcasecmp($current_user->display_name, 'admin')!=0 && strcasecmp($current_user->display_name , "administrator")!=0 )
{
    echo $current_user->display_name;
}
else if (strcasecmp($current_user->user_login ,"admin")!=0 && strcasecmp($current_user->user_login , "administrator")!=0 )
{
    echo $current_user->user_login;
}
?>"  >

<input class="xyz_ips_email" name="email"
type="text" placeholder="Email" value="<?php   echo $current_user->user_email; ?>" />

<input id="xyz_ips_submit_ips_btn" type="submit" class="xyz_ips_sbmt_btn" value="Subscribe" name="Submit"  onclick="javascript: if(!verify_fields()) return false; " />

<input type="hidden" name="listName" value="6,1,"/>
</form>
    </div>
<div class="xyz_ips_inmotion" >
   <a target="_blank" href="http://inmotion-hosting.evyy.net/c/1150074/260033/4222">
   <img src="<?php echo plugins_url()?>/insert-php-code-snippet/images/xyz.png" class="xyz_inmotion_label"></a>
   </div>
</div>
<div style="clear: both;">
</div>
<div style="width: 100%">
    <div class="xyz_our_plugins_new">
        <p class="xyz_plugin_head">
            Our Plugins : 
        </p>
        <a target="_blank"  href="https://wordpress.org/plugins/social-media-auto-publish/"><span>1</span>Social Media Auto Publish</a>
        <a target="_blank"  href="https://wordpress.org/plugins/facebook-auto-publish/"><span>2</span>Facebook Auto Publish</a>
        <a target="_blank"  href="https://wordpress.org/plugins/twitter-auto-publish/"><span>3</span>Twitter Auto Publish</a>
        <a target="_blank"  href="https://wordpress.org/plugins/linkedin-auto-publish/"><span>4</span>LinkedIn Auto Publish</a>
        <a target="_blank"  href="https://wordpress.org/plugins/insert-html-snippet/"><span>5</span>Insert HTML Snippet</a>
        <a target="_blank"  href="https://wordpress.org/plugins/insert-php-code-snippet/"><span>6</span>Insert PHP Code Snippet</a>
        <a target="_blank"  href="https://wordpress.org/plugins/contact-form-manager/"><span>7</span>Contact Form Manager</a>
        <a target="_blank"  href="https://wordpress.org/plugins/newsletter-manager/"><span>8</span>Newsletter Manager</a>
        <a target="_blank"  href="https://wordpress.org/plugins/lightbox-pop/"><span>9</span>Lightbox Pop</a>
        <a target="_blank"  href="https://wordpress.org/plugins/full-screen-popup/"><span>10</span>Full Screen Popup</a>
        <a target="_blank"  href="https://wordpress.org/plugins/popup-dialog-box/"><span>11</span>Popup Dialog Box</a>
        <a target="_blank"  href="https://wordpress.org/plugins/quick-bar/"><span>12</span>Quick Bar</a>
        <a target="_blank"  href="https://wordpress.org/plugins/quick-box-popup/"><span>13</span>Quick Box Popup</a>
        <a target="_blank"  href="https://wordpress.org/plugins/custom-field-manager/"><span>14</span> Custom Field Manager</a>
        <a target="_blank"  href="https://wordpress.org/plugins/wp-filter-posts/"><span>15</span>  WP Filter Posts</a>
        <a target="_blank"  href="https://wordpress.org/plugins/wp-gallery-manager/"><span>16</span>  WP Gallery Manager</a>
    </div>
</div>
<div class="xyz_poweredBy">
    Powered by 
    <a href="http://xyzscripts.com" target="_blank">XYZScripts</a>
</div>
<div style="clear: both;"></div>
<p style="clear: both;"></p>
