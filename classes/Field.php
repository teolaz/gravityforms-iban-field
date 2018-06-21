<?php
/**
 * Created by PhpStorm.
 * User: Matteo
 * Date: 05/06/2017
 * Time: 15:48
 */

namespace Teolaz\GravityFormsIBANField;

use IBAN;
use GF_Field;

class Field extends GF_Field {
	/**
	 * @var string $type The field type.
	 */
	public $type = 'iban-field';
	
	/**
	 * Return the field title, for use in the form editor.
	 *
	 * @return string
	 */
	public function get_form_editor_field_title() {
		return esc_attr__( 'IBAN', 'gravityforms-iban-field' );
	}
	
	/**
	 * Assign the field button to the Advanced Fields group.
	 *
	 * @return array
	 */
	public function get_form_editor_button() {
		return array(
			'group' => 'advanced_fields',
			'text'  => $this->get_form_editor_field_title(),
		);
	}
	
	/**
	 * The settings which should be available on the field in the form editor.
	 *
	 * @return array
	 */
	function get_form_editor_field_settings() {
		return array(
			'conditional_logic_field_setting',
			'error_message_setting',
			'label_setting',
			'label_placement_setting',
			'admin_label_setting',
			'size_setting',
			'password_field_setting',
			'rules_setting',
			'visibility_setting',
			'duplicate_setting',
			'default_value_setting',
			'placeholder_setting',
			'description_setting',
			'css_class_setting',
		);
	}
	
	/**
	 * Enable this field for use with conditional logic.
	 *
	 * @return bool
	 */
	public function is_conditional_logic_supported() {
		return true;
	}
	
	/**
	 * Define the fields inner markup.
	 *
	 * @param array        $form The Form Object currently being processed.
	 * @param string|array $value The field value. From default/dynamic population, $_POST, or a resumed incomplete submission.
	 * @param null|array   $entry Null or the Entry Object currently being edited.
	 *
	 * @return string
	 */
	public function get_field_input( $form, $value = '', $entry = null ) {
		$form_id         = absint( $form[ 'id' ] );
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();
		
		$html_input_type = 'text';
		
		if ( $this->enablePasswordInput && ! $is_entry_detail ) {
			$html_input_type = 'password';
		}
		
		$logic_event = ! $is_form_editor && ! $is_entry_detail ? $this->get_conditional_logic_event( 'keyup' ) : '';
		$id          = (int)$this->id;
		$field_id    = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";
		
		$value        = esc_attr( $value );
		$size         = $this->size;
		$class_suffix = $is_entry_detail ? '_admin' : '';
		$class        = $size . $class_suffix;
		
		$tabindex              = $this->get_tabindex();
		$disabled_text         = $is_form_editor ? 'disabled="disabled"' : '';
		$placeholder_attribute = $this->get_field_placeholder_attribute();
		$required_attribute    = $this->isRequired ? 'aria-required="true"' : '';
		$invalid_attribute     = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';
		
		$input = "<input name='input_{$id}' id='{$field_id}' type='{$html_input_type}' value='{$value}' class='{$class}' {$tabindex} {$logic_event} {$placeholder_attribute} {$required_attribute} {$invalid_attribute} {$disabled_text}/>";
		
		return sprintf( "<div class='ginput_container ginput_container_text'>%s</div>", $input );
	}
	
	/**
	 * Validate Field
	 */
	public function validate( $value, $form ) {
		if ( ! ( new IBAN( $value ) )->Verify() ) {
			$this->failed_validation = true;
			if ( ! empty( $this->errorMessage ) ) {
				$this->validation_message = $this->errorMessage;
			}
			else {
				$this->validation_message = __( 'The IBAN you inserted is not valid.',
					'gravityforms-iban-field' );
			}
		}
	}
}