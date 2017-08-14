<?php
/*

**************************************************************************

Plugin Name:  Page Loading
Plugin URI:   http://www.arefly.com/page-loading/
Description:  Add a CSS3 effect to your blog while loading pages. 給你的部落格增加一個帶有CSS3效果的頁面載入動畫
Version:      1.0.5
Author:       Arefly
Author URI:   http://www.arefly.com/

**************************************************************************

	Copyright 2014  Arefly  (email : eflyjason@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

**************************************************************************/

define("PAGE_LOADING_PLUGIN_URL", plugin_dir_url( __FILE__ ));
define("PAGE_LOADING_FULL_DIR", plugin_dir_path( __FILE__ ));
define("PAGE_LOADING_TEXT_DOMAIN", "page-loading");

/* Add CSS code */
wp_enqueue_style(PAGE_LOADING_TEXT_DOMAIN, PAGE_LOADING_PLUGIN_URL.'style.css');

function page_loading_template_include($template) {
	ob_start();
	return $template;
}
add_filter('template_include', 'page_loading_template_include', 1);

/* Use a SPECIAL WAY to add code before <body> tag */
function page_loading_head() {
	if(!in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))){
		$content = ob_get_clean();
		$content = preg_replace('#<body([^>]*)>#i', '<body$1><div id="circle"></div><div id="circle1"></div>', $content);
		echo $content;
	}
}
add_filter('shutdown', 'page_loading_head', 0);

function page_loading_footer() {
	?>
<script>
jQuery(window).load(function() {
	jQuery("#circle").fadeOut(500);
	jQuery("#circle1").fadeOut(700);
});
</script>
	<?php
}
add_action('wp_footer', 'page_loading_footer');
