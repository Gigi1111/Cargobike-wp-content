<?php if ( ! defined( 'ABSPATH' ) ) {exit;} ?>

<li class="<?php $this->getKeySelf('open'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('open');?>">
        <?php esc_html_e( 'Opens', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('open',true) ) ?>
    </label>
    <select id="<?php $this->getKey('open');?>" onclick="SetFieldProperty('<?php $this->getKeyID('open');?>', this.value);">
        <option value="left"> <?php esc_html_e( 'Left', 'dtrpg' ); ?></option>
        <option value="right"> <?php esc_html_e( 'Right', 'dtrpg' ); ?></option>
        <option value="center"> <?php esc_html_e( 'Center', 'dtrpg' ); ?></option>
    </select>
</li>

<li class="<?php $this->getKeySelf('drops'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('drops');?>">
        <?php esc_html_e( 'Drops', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('drops',true) ) ?>
    </label>
    <select id="<?php $this->getKey('drops');?>" onclick="SetFieldProperty('<?php $this->getKeyID('drops');?>', this.value);">
        <option value="down"> <?php esc_html_e( 'Down', 'dtrpg' ); ?></option>
        <option value="up"> <?php esc_html_e( 'Up', 'dtrpg' ); ?></option>
    </select>
</li>