<?php
/** Step 1. */
function php_everywhere_menu() {
	add_options_page( 'PHP Everywhere', 'PHP Everywhere', 'manage_options', 'php-everywhere-identifier', 'php_everywhere_options' );
}

/** Step 3. */
function php_everywhere_options() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( __('You do not have sufficient permissions to access this page.', 'php-everywhere') ) );
	}
	
	if(isset($_POST['php_everywhere_roles']))
	{
		update_option('php_everywhere_option_roles',$_POST['php_everywhere_roles']);
	}
	if(isset($_POST['php_everywhere_options_box']))
	{
		update_option('php_everywhere_option_options_box',$_POST['php_everywhere_options_box']);
	}
	if(isset($_POST['php_everywhere_gutenberg_block']))
	{
		update_option('php_everywhere_option_options_block',$_POST['php_everywhere_gutenberg_block']);
	}

	?>
<div class="wrap">
<h1>PHP Everywhere</h1>
<p><?php _e('Thanks for using PHP Everywhere. If you have any questions, feel free to ask <a href="https://www.alexander-fuchs.net/contact/">me</a>.<br />I created this plugin because I have not found a Wordpress PHP plugin which is simple to use and provides a good user experience while being able to use PHP or HTML in Posts, Pages or Widgets.', 'php-everywhere'); ?></p>
<p><?php _e('<b>Important:</b> This plugin supports Gutenberg blocks. You are highly adviced to switch your existing shortcodes to Blocks. After you have switched all shortcodes you may disable the options box by using the settings below.', 'php-everywhere'); ?></p>
<h2><?php _e('Support this plugin, if you enjoy using it 😄☕'); ?></h2>
<p><?php echo sprintf( __('I always appreciate to hear from people who like my work. Feel free to contact me or buy me a cup of <a href="%s" target="_blank">buy me a cup of coffee (Donate)</a>.'), "https://www.alexander-fuchs.net/donate/"); ?></p>
<h2><?php _e('Need helping setting up this plugin?'); ?></h2>
<p><?php echo sprintf( __('I offer custom development and WordPress customizations at affordable rates. Feel free to <a href="%s">contact me</a> if you need any help.'), "https://www.alexander-fuchs.net/contact/"); ?></p>
<h1><?php _e('Settings', 'php-everywhere')?></h1>
<p><b><?php _e('Who can modify the PHP in posts and pages?', 'php-everywhere')?></b></p>
<form method="post">
<select name="php_everywhere_roles">
  <option value="everyone"><?php _e('Administrator, editor, author', 'php-everywhere')?></option>
  <option value="admin" <?php if(get_option('php_everywhere_option_roles')=='admin'){echo('selected');}?>><?php _e('Administrator only', 'php-everywhere')?></option>
</select>
<p><?php _e('Important: When you set the modification permission to admin only, the PHP Everyhwere Block can not be used. This is because of a technical limitation within Gutenberg (Content, that is saved inline can be editied by anyone, who has the permission to edit the post.).', 'php-everywhere')?></p>
<p><b><?php _e('Disable Options Box?', 'php-everywhere')?></b></p>
<select name="php_everywhere_options_box">
  <option value="yes"<?php if(get_option('php_everywhere_option_options_box')=='yes'){echo('selected');}?>><?php _e('Yes', 'php-everywhere')?></option>
  <option value="no" <?php if(get_option('php_everywhere_option_options_box', 'no')=='no'){echo('selected');}?>><?php _e('No', 'php-everywhere')?></option>
</select>
<p><?php _e('This setting will disable the PHP Everywhere options box for all posts and pages. Existing shortcodes will continue to work.', 'php-everywhere')?></p>
<p><b><?php _e('Disable Gutenberg Block?', 'php-everywhere')?></b></p>
<select name="php_everywhere_gutenberg_block">
  <option value="yes"<?php if(get_option('php_everywhere_option_options_block')=='yes'){echo('selected');}?>><?php _e('Yes', 'php-everywhere')?></option>
  <option value="no" <?php if(get_option('php_everywhere_option_options_block', 'no')=='no'){echo('selected');}?>><?php _e('No', 'php-everywhere')?></option>
</select>
<p><?php _e('This setting will disable the PHP Everywhere Gutenberg Block for all posts and pages. Existing Blocks will not work anymore.', 'php-everywhere')?></p>
<?php submit_button(); ?>
</form> 
<h1><?php _e('Usage', 'php-everywhere')?></h1>
<h3><?php _e('Widgets', 'php-everywhere')?></h3>
<p><?php _e('Simply activate the <pre>PHP + HTML</pre> Widget. in your sidebar and paste your PHP code including the PHP Tags like this:
<pre>&lt;?php  echo("Hello, World!"); ?&gt;</pre>
You code may contain HTML Elements or have multiple lines.', 'php-everywhere')?></p>
<h3><?php _e('Posts & Pages', 'php-everywhere')?></h3>
<p><?php _e('Edit or create a new post or page and simply create a PHP Everywhere Gutenberg Block on the page. Now you can just put your PHP Code including the PHP tags into the box and it’s output will appear where you placed the Block.', 'php-everywhere')?></p>
<h4><?php _e('Multiple PHP instances', 'php-everywhere')?></h4>
<p><?php _e('You can have multiple PHP instances by placing multiple PHP Everywhere Blocks in your editor', 'php-everywhere')?></p>
<h3><?php _e('Posts & Pages (By using a shortcode)', 'php-everywhere')?></h3>
<p><?php _e('Edit or create a new post or page and simply put your PHP Code including the PHP tags into the side options_box, which is labeled "PHP Everywhere". Then put the <pre>[php_everywhere]</pre> shortcode where you want the code to appear. Your code may contain multiple lines or HTML Tags.', 'php-everywhere')?></p>
<h4><?php _e('Multiple PHP instances', 'php-everywhere')?></h4>
<p><?php _e('If you want to use multiple PHP instances use the shortcode with the instance parameter like this:', 'php-everywhere')?><br><pre>[php_everywhere instance="1"]</pre><br><?php _e('Your PHP snippet should look like this:', 'php-everywhere')?><br><pre>&lt;?php
if($instance==&quot;1&quot;)
{
echo(&quot;Number one!&quot;);
}
if($instance==&quot;2&quot;)
{
echo(&quot;Number two!&quot;);
}
?&gt;</pre></p>
<h1><?php _e('Changelog', 'php-everywhere')?></h1>
<p><?php _e('Go to <a href="http://www.alexander-fuchs.net/php-everywhere/" target="_blank">http://www.alexander-fuchs.net/php-everywhere/</a> to view the changelog and more.', 'php-everywhere')?></p>
<h1><?php _e('Like this Plugin? Support me :)', 'php-everywhere')?></h1>
<h3><?php _e('Follow me', 'php-everywhere')?></h3>
<ul>
<li><a href="https://www.alexander-fuchs.net" target="_blank">alexander-fuchs.net</a></li>
<li><a href="https://www.linkedin.com/in/alexander-fuchs-38b932a1/" target="_blank">LinkedIn</a></li>
</ul>
<h3><?php _e('Donate to this plugin', 'php-everywhere')?></h3>
<p>
<?php echo sprintf( __('I maintain this plugin in my limited free time. I appreciate if you <a href="%s" target="_blank">buy me a coffee (Donate)</a>. :)', 'php-everywhere'), "https://www.alexander-fuchs.net/donate/"); ?></p>
</div>
<?php
}
?>