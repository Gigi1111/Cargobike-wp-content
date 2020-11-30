<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}
class GF_Field_DTRP extends GF_Field {

    public $type = 'dtrpg';

	public function get_form_editor_field_title() {
		return esc_attr__( 'Range Date', 'dtrpg' );
	}

	function get_form_editor_field_settings() {

		$dtrpg_settings = array_keys(DTRPG_Settings::get()->initSettingList());
		
		$return = array(
			'conditional_logic_field_setting',
			'prepopulate_field_setting',
			'error_message_setting',
			'label_setting',
            //maxSpan
			'label_placement_setting',
			'admin_label_setting',
			'size_setting',
			'rules_setting',
			'visibility_setting',
			'duplicate_setting',
			'placeholder_setting',
			'description_setting',
			'css_class_setting',
		);

		$return = array_merge($return , $dtrpg_settings);

		return $return;
	}

	public function is_conditional_logic_supported() {
		return true;
	}

	public function validate( $value, $form ) {
		if ( empty( $value ) ) {
			$value = '';
			if ( $this->isRequired ) {
				$this->failed_validation  = true;
				$this->validation_message = empty( $this->errorMessage ) ? esc_html__( 'This field is required.', 'gravityforms' ) : $this->errorMessage;
			}
		}
	}

	public function get_field_input( $form, $value = '', $entry = null ) {
		$is_entry_detail = $this->is_entry_detail();
		$is_form_editor  = $this->is_form_editor();

		$form_id  = $form['id'];
		$id       = intval( $this->id );
		$field_id = $is_entry_detail || $is_form_editor || $form_id == 0 ? "input_$id" : 'input_' . $form_id . "_$id";

		$size            = $this->size;
		$disabled_text   = $is_form_editor ? "disabled='disabled'" : '';
		$class_suffix    = $is_entry_detail ? '_admin' : '';
		$class           = $size . $class_suffix;
		$html_input_type = 'text';

		$placeholder_attribute = $this->get_field_placeholder_attribute();
		$required_attribute    = $this->isRequired ? 'aria-required="true"' : '';
		$invalid_attribute     = $this->failed_validation ? 'aria-invalid="true"' : 'aria-invalid="false"';
		$aria_describedby      = $this->get_aria_describedby();
		$data_id      = '';
		$autocomplate      = 'autocomplete="off"';

		$tabindex = $this->get_tabindex();
		$value    = esc_attr( $value );
        $class    = esc_attr( $class );
        
        $field_option = GFFormsModel::get_field( $form_id, $id );

        $lasd = '';
        if(!$is_form_editor){
			ob_start(); 
				include_once(DTRPG_DIR."/inc/settings/front/head.php");
                include(DTRPG_DIR."/inc/settings/front/front-end-script.php");
            $lasd = ob_get_clean();
			
            add_action( 'wp_footer', function() use($lasd){
                echo $lasd;
            }, 99);
        }

		return "<div class='ginput_container ginput_container_website'>
                    <input {$autocomplate} {$data_id} name='input_{$id}' id='{$field_id}' type='$html_input_type' value='{$value}' class='{$class}' {$tabindex} {$aria_describedby} {$disabled_text} {$placeholder_attribute} {$required_attribute} {$invalid_attribute}/>
                </div>";
	}

	public function get_value_entry_detail( $value, $currency = '', $use_text = false, $format = 'html', $media = 'screen' ) {
		$safe_value = $value;
		return $safe_value;
	}

	public function get_value_save_entry( $value, $form, $input_name, $lead_id, $lead ) {

		return $value ? $value : '';
	}
}