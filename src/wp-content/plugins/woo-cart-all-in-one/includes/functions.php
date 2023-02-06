<?php
/**
 * Function include all files in folder
 *
 * @param $path   Directory address
 * @param $ext    array file extension what will include
 * @param $prefix string Class prefix
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'villatheme_include_folder' ) ) {
	function villatheme_include_folder( $path, $prefix = '', $ext = array( 'php' ) ) {

		/*Include all files in payment folder*/
		if ( ! is_array( $ext ) ) {
			$ext = explode( ',', $ext );
			$ext = array_map( 'trim', $ext );
		}
		$sfiles = scandir( $path );
		foreach ( $sfiles as $sfile ) {
			if ( $sfile != '.' && $sfile != '..' ) {
				if ( is_file( $path . "/" . $sfile ) ) {
					$ext_file  = pathinfo( $path . "/" . $sfile );
					$file_name = $ext_file['filename'];
					if ( $ext_file['extension'] ) {
						if ( in_array( $ext_file['extension'], $ext ) ) {
							$class = preg_replace( '/\W/i', '_', $prefix . ucfirst( $file_name ) );

							if ( ! class_exists( $class ) ) {
								require_once $path . $sfile;
								if ( class_exists( $class ) ) {
									new $class;
								}
							}
						}
					}
				}
			}
		}
	}
}
if ( ! function_exists( 'viwcaio_sanitize_fields' ) ) {
	function viwcaio_sanitize_fields( $data ) {
		if ( is_array( $data ) ) {
			return array_map( 'viwcaio_sanitize_fields', $data );
		} else {
			return is_scalar($data)?sanitize_text_field( wp_unslash( $data ) ):$data;
		}
	}
}
if ( ! function_exists( 'viwcaio_sanitize_kses' ) ) {
	function viwcaio_sanitize_kses( $data ) {
		if ( is_array( $data ) ) {
			return array_map( 'viwcaio_sanitize_kses', $data );
		} else {
			return is_scalar($data)? wp_kses_post( wp_unslash( $data ) ):$data;
		}
	}
}

