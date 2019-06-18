<?php
/*
Plugin Name: Exemplar DB
Version: 1.0
Description: Modifies the previous DB plugin to pull Exemplar data
Author: Jorie Sieck
Author URI: https://my.thinkeracademy.com
*/

global $db_version;
$db_version = '1.0';

global $table_postfix;
$table_postfix = 'judgements';

// Call create_table on plugin activation.
register_activation_hook(__FILE__,'create_table');
/*
 * Creates the table "wp_judgements" in the database.
 */
function create_table() {
    global $wpdb;
    global $db_version;
    global $table_postfix;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    $table_name = $wpdb->prefix . $table_postfix;

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        judg_id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
        learner_id mediumint(9) UNSIGNED NOT NULL,
        trial_num smallint(2) UNSIGNED NOT NULL,
		comp_num smallint(2) UNSIGNED NOT NULL,
		task_num smallint(2) UNSIGNED NOT NULL,
		ex_title tinytext NOT NULL,
		learner_level smallint(1) UNSIGNED NOT NULL,
		learner_rationale longtext NOT NULL,
		gold_level longtext NOT NULL,
		judg_corr smallint(1) UNSIGNED NOT NULL,
	    judg_time time NOT NULL,
        PRIMARY KEY (judg_id)
	) $charset_collate;";

    dbDelta($sql);
    $success = empty( $wpdb->last_error );
    update_option($table_name . '_db_version',$db_version);
    return $success;
}