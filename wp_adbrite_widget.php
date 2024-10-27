<?php
/*
Plugin Name: Adbrite Money Maker Widget
Description: Widget to add adbrite ads to your sidebar and change colors dynamically.  You need to <a href="http://caliaccountant.com/make-money-with-adbrite/#sign">Sign up for Adbrite</a> and <a href="http://caliaccountant.com/make-money-with-adbrite/#code">get adbrite code</a>.  Also, see how to <a href="http://caliaccountant.com/make-money-with-adbrite/#max1">Maximize Adbrite Earnings</a>    
Author: Tom001
Version: 1.0
Plugin URI: http://caliaccountant.com/make-money-with-adbrite/
*/

if(!function_exists('add_ui_files')){
function add_ui_files(){
	$http_path = trailingslashit(get_option('siteurl'));
	$http_path_plugin = WP_PLUGIN_URL.'/'.str_replace(basename( __FILE__),"",plugin_basename(__FILE__));
	?>
    <link rel="stylesheet" href="<?php echo $http_path_plugin;?>css/colorpicker.css" type="text/css" />
    <script type="text/javascript" src="<?php echo $http_path_plugin;?>js/jquery.js"></script>
	<script type="text/javascript" src="<?php echo $http_path_plugin;?>js/colorpicker.js"></script>
    <script type="text/javascript" src="<?php echo $http_path_plugin;?>js/eye.js"></script>
    <script type="text/javascript" src="<?php echo $http_path_plugin;?>js/utils.js"></script>
    <script type="text/javascript" src="<?php echo $http_path_plugin;?>js/layout.js?ver=1.0.2"></script>
    <?php
}
}
// This gets called at the plugins_loaded action
function widget_adbrite_color_changer_init() {

	// Check for the required API functions
	if ( !function_exists('register_sidebar_widget') )
	return;


	if(!function_exists('widget_adbrite_color_changer_control')){
	function widget_adbrite_color_changer_control() {
		$wp_adbrite_options = $wp_adbrite_new_options = get_option('wp_adbrite_settings');
		#print_r($wp_adbrite_options);
		if(isset($_POST['adbr_title'])){
			$wp_adbrite_new_options['widget_title'] = strip_tags(stripslashes($_POST['adbr_title']));
			$wp_adbrite_new_options['widget_code'] = stripslashes($_POST['adbrite']);
		}
		if ( $wp_adbrite_options != $wp_adbrite_new_options ) {
			$wp_adbrite_options = $wp_adbrite_new_options;
			update_option('wp_adbrite_settings', $wp_adbrite_options);
		}
		?>
 <form>     
     <table cellpadding="20" cellspacing="20" border="1">
<tr><td colspan="3" align="left">Title:<BR /><input value="<?php echo $wp_adbrite_options['widget_title'];?>"  type="text" name="adbr_title" id="adbr_title" /></td></tr>
<tr><td colspan="3" align="left">Adcode (from Adbrite):<BR /><textarea name="adbrite" id="adbrite" cols="40" rows="7"><?php echo $wp_adbrite_options['widget_code'];?></textarea></td></tr>
<tr>
<td  align="left">
Title:<input readonly="readonly" onfocus="javascript:setfocus(this.name,this.form);" type="text" name="adbrite_title" id="adbrite_title" size="2" /></td>
<td  align="left">URL:<input  onfocus="javascript:setfocus(this.name,this.form);" readonly="readonly"  type="text" name="adbrite_url" id="adbrite_url" size="2" /></td>
<td  align="left">Border:<input onfocus="javascript:setfocus(this.name,this.form);"  readonly="readonly"  type="text" name="adbrite_border" id="adbrite_border" size="2" /></td>
</tr>
<tr>
<td  align="left">Text:<input onfocus="javascript:setfocus(this.name,this.form);"  readonly="readonly"  type="text" name="adbrite_text" id="adbrite_text" size="2" /></td>
<td  align="left">Background:<input onfocus="javascript:setfocus(this.name,this.form);"  readonly="readonly"  type="text" name="adbrite_background" id="adbrite_background" size="2" /></td>
<td>&nbsp;</td>
</tr>
</table>
</form>
<BR /><BR />
<script language="javascript" type="text/javascript">

currently_focused = '';
current_form = null;
function setfocus(elementname,formelement){
	currently_focused = elementname;
	current_form = formelement;

	//get the parent node
}

function replace_title(changeto,element){

	//var title = document.getElementById("adbrite").value;
	//var title = $('#adbrite').val();
	  var title = current_form.adbrite.value;
	
	switch(element){
		case "adbrite_title":{
				var pattern = /AdBrite_Title_Color(\s)?=(\s)?('|"){1}([a-fA-F0-9]){6}('|"){1}/;	
				var js_var = 'AdBrite_Title_Color';
				break;
		}
		case "adbrite_url":{
				var pattern = /AdBrite_URL_Color(\s)?=(\s)?('|"){1}([a-fA-F0-9]){6}('|"){1}/;		
				var js_var = 'AdBrite_URL_Color';
				break;
		}
		case "adbrite_border":{
				var pattern = /AdBrite_Border_Color(\s)?=(\s)?('|"){1}([a-fA-F0-9]){6}('|"){1}/;
				var js_var = 'AdBrite_Border_Color';
				break;
		}
		case "adbrite_text":{
				var pattern = /AdBrite_Text_Color(\s)?=(\s)?('|"){1}([a-fA-F0-9]){6}('|"){1}/;	
				var js_var = 'AdBrite_Text_Color';
				break;
		}
		case "adbrite_background":{
				var pattern = /AdBrite_Background_Color(\s)?=(\s)?('|"){1}([a-fA-F0-9]){6}('|"){1}/;	
				var js_var = 'AdBrite_Background_Color';
				break;
		}
	}


	
	//alert(title);
	var re = new RegExp(pattern);
	output = re.exec(title);
	//output = re.match(title);
	if (output != null) {
	old_color = output[0];
	new_color = js_var + " = '"+changeto+"'";
	newcode = title.replace(old_color,new_color);
	//document.getElementById("adbrite").value = newcode;
	current_form.adbrite.value = newcode;
	
  
    

  } else {
    alert("The Adbrite Variable '"+js_var+"' Is Not Found In Your Code Snippet.");
  }

}


$('#adbrite_title, #adbrite_url, #adbrite_border, #adbrite_text, #adbrite_background').ColorPicker({
	onSubmit: function(hsb, hex, rgb, el) {
		//$(el).val(hex);
		$(el).css('backgroundColor', '#' + hex);
		$(el).ColorPickerHide();
		//alert(currently_focused);
		replace_title(hex,currently_focused)
		
	},
	/* onChange: function (hsb, hex, rgb, el) {
		//$('#colorSelector div').css('backgroundColor', '#' + hex);
		$(el).val(hex);
		$(el).ColorPickerHide();
		$(this).ColorPickerSetColor(this.value);
	}, */
	onBeforeShow: function () {
		$(this).ColorPickerSetColor(this.value);
	}
})
.bind('keyup', function(){
	$(this).ColorPickerSetColor(this.value);
});

</script>   
        
        
        
        
        
        
        
        <?php
	}
	}
	// This saves options and prints the widget's config form.
	function widget_adbrite_color_changer() {
		$wp_adbrite_options = get_option('wp_adbrite_settings');
		if($wp_adbrite_options['widget_title'] != '' && $wp_adbrite_options['widget_code'] != ''){
		 echo $before_widget; ?>
			<center><?php echo $before_title . $wp_adbrite_options['widget_title'] . $after_title;
  				?></center>
  				<table align="center"><tr>
  				<td><?php echo $wp_adbrite_options['widget_code']; ?></td>
				</tr>
				</table>
		<?php echo $after_widget; 
		}
	}

	register_widget_control('Adbrite Widget', 'widget_adbrite_color_changer_control',400,500);
	register_sidebar_widget('Adbrite Widget', 'widget_adbrite_color_changer');
}
add_action('widgets_init', 'widget_adbrite_color_changer_init');
add_action('admin_head','add_ui_files');		
?>