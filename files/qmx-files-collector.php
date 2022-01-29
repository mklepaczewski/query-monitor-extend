<?php
/**
 * Plugin URI: https://github.com/crstauf/query-monitor-extend/tree/master/files
 * Description: Query Monitor collector for files.
 * Version: 1.0
 * Author: Caleb Stauffer
 * Author URI: https://develop.calebstauffer.com
 * Update URI: false
 */

defined( 'WPINC' ) || die();

add_action( 'plugin_loaded', 'load_qmx_files_collector' );

function load_qmx_files_collector( string $file ) {

	if ( 'query-monitor/query-monitor.php' !== plugin_basename( $file ) )
		return;

	remove_action( 'plugin_loaded', __FUNCTION__ );

	if ( !class_exists( 'QueryMonitor' ) )
		return;

	if ( defined( 'QMX_DISABLE' ) && QMX_DISABLE )
		return;

	class QMX_Collector_Files extends QM_Collector {

		public $id = 'files';

		protected $data = array(
			'files' => array(),
		);

		public function name() {
			return __( 'Files', 'query-monitor-extend' );
		}

		public function process() {
			if ( did_action( 'qm/cease' ) )
				return;

			$php_errors = QM_Collectors::get( 'php_errors' )->get_data();
			$files_with_errors = array();

			if ( !empty( $php_errors['errors'] ) )
				foreach ( $php_errors['errors'] as $type => $errors )
					foreach ( $errors as $error )
						$files_with_errors[$error['file']] = 1;

			foreach ( get_included_files() as $i => $filepath )
				$this->data['files'][] = array(
					'path' => $filepath,
					'component' => QM_Util::get_file_component( $filepath ),
					'has_error' => array_key_exists( $filepath, $files_with_errors ),
				);

		}

	}

	add_filter( 'qm/collectors', static function ( array $collectors ) : array {
		$collectors['files'] = new QMX_Collector_Files;
		return $collectors;
	} );

}