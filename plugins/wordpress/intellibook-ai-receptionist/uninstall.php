<?php
/**
 * Removes the plugin's options when it is deleted from the Plugins screen.
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

delete_option('intellibook_business_slug');
delete_option('intellibook_enable_floating_button');
delete_option('intellibook_show_credit');
