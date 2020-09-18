<?php
/**
 * XLS-Converter
 *
 * @author     Gero Gothe <practical@medizin-lernen.de>
 */
 

class admin_plugin_xlsconv extends DokuWiki_Admin_Plugin {
     
	function getMenuText($language){
		return "XLS to DokuWiki Converter";
	}
	
    function forAdminOnly() {
        return false;
    }
     
    function html() {
        include_once DOKU_INC.'lib/plugins/xlsconv/xlsconv.php';
    }

}

