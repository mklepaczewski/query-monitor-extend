<?php
/**
 * Plugin Name: QMX: Time Data
 * Plugin URI: https://github.com/crstauf/query-monitor-extend/tree/master/time
 * Description: Query Monitor data for time.
 * Version: 1.0.0
 * Author: Caleb Stauffer
 * Author URI: https://develop.calebstauffer.com
 * Update URI: false
 */

defined( 'WPINC' ) || die();

if ( defined( 'QM_DISABLED' ) && constant( 'QM_DISABLED' ) ) {
	return;
}

if ( constant( 'QMX_DISABLED' ) ) {
	return;
}

add_action( 'qmx/load_data/time', static function () {

	class QMX_Data_Time extends QM_Data {

		public $functions = array();

	}

} );