<?php
/**
 * Created by PhpStorm.
 * User: Matteo
 * Date: 05/06/2017
 * Time: 15:44
 */

namespace Teolaz\GravityFormsIBANField;

use GFForms;
use GFAddOn;
use GF_Fields;

GFForms::include_addon_framework();

class Addon extends GFAddOn {
	protected $_version = GF_IBAN_FIELD;
	protected $_slug = 'gravityforms-iban-field';
	protected $_title = 'Gravity Forms IBAN validated text field';
	protected $_short_title = 'IBAN field';
	/**
	 * @var object $_instance If available, contains an instance of this class.
	 */
	private static $_instance = null;
	
	/**
	 * Returns an instance of this class, and stores it in the $_instance property.
	 *
	 * @return object $_instance An instance of this class.
	 */
	public static function get_instance() {
		if ( self::$_instance == null ) {
			self::$_instance = new self();
		}
		
		return self::$_instance;
	}
	
	/**
	 * Include the field early so it is available when entry exports are being performed.
	 */
	public function pre_init() {
		parent::pre_init();
		if (
			$this->is_gravityforms_supported() &&
			class_exists( 'GF_Field' ) &&
			class_exists( 'GF_Fields' )
		) {
			GF_Fields::register( new Field() );
		}
	}
}