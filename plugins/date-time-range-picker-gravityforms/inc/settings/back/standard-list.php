<?php if ( ! defined( 'ABSPATH' ) ) {exit;} ?>
<!-- Time Picker -->
<li class="<?php $this->getKeySelf('timePicker'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('timePicker');?>">
        <?php esc_html_e( 'Time Picker', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('timePicker',true) ) ?>
    </label>
    <input type="checkbox" id="<?php $this->getKey('timePicker');?>" onclick="SetFieldProperty('<?php $this->getKeyID('timePicker');?>', this.checked);" />
</li>

<li data-id="<?php $this->getKeySelf('timePicker24Hour');?>" class="<?php $this->getKeySelf('timePicker24Hour'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('timePicker24Hour');?>">
        <?php esc_html_e( '24Hour Time Format', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('timePicker24Hour',true) ) ?>
    </label>
    <input type="checkbox" id="<?php $this->getKey('timePicker24Hour');?>" onclick="SetFieldProperty('<?php $this->getKeyID('timePicker24Hour');?>', this.checked);" />
</li>
<li data-id="<?php $this->getKeySelf('timePickerIncrement');?>" class="<?php $this->getKeySelf('timePicker24Hour'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('timePickerIncrement');?>">
        <?php esc_html_e( 'Time Picker Increment', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('timePickerIncrement',true) ) ?>
    </label>
    <input type="number" id="<?php $this->getKey('timePickerIncrement');?>" onchange="SetFieldProperty('<?php $this->getKeyID('timePickerIncrement');?>', this.value);" />
</li>
<!-- Time Picker -->

<!-- dtrpg_maxSpan_setting  !-->
<li class="<?php $this->getKeySelf('maxSpanStatus'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('maxSpanStatus');?>">
        <?php esc_html_e( 'Max Span Status', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('maxSpanStatus',true) ) ?>
    </label>
    <input type="checkbox" id="<?php $this->getKey('maxSpanStatus');?>" onclick="SetFieldProperty('<?php $this->getKeyID('maxSpanStatus');?>', this.checked);" />
</li>

<li data-id="<?php $this->getKeySelf('maxSpanBase');?>" class="<?php $this->getKeySelf('maxSpanBase'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('maxSpanBase');?>">
        <?php esc_html_e( 'Select MaxSpan Base', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('maxSpanBase',true) ) ?>
    </label>
    <select id="<?php $this->getKey('maxSpanBase');?>" onclick="SetFieldProperty('<?php $this->getKeyID('maxSpanBase');?>', this.value);">
        <option value="months"><?php esc_html_e( 'Month(s)', 'dtrpg' ); ?></option>
        <option value="days"><?php esc_html_e( 'Day(s)', 'dtrpg' ); ?></option>
        <option value="years"><?php esc_html_e( 'Year(s)', 'dtrpg' ); ?></option>
    </select>
</li>

<li data-id="<?php $this->getKeySelf('maxSpanNum');?>" class="<?php $this->getKeySelf('maxSpanNum');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('maxSpanNum');?>">
        <?php esc_html_e( 'Number Of MaxSpan', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('maxSpanNum',true) ) ?>
    </label>
    <input min="1" type="number" id="<?php $this->getKey('maxSpanNum');?>" onchange="SetFieldProperty('<?php $this->getKeyID('maxSpanNum');?>',this.value);" />
</li>
<!-- dtrpg_maxSpan_setting  !-->

<!-- ShowDropdowns -->
<li class="<?php $this->getKeySelf('showDropdowns'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('showDropdowns');?>">
        <?php esc_html_e( 'ShowDropdowns', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('showDropdowns',true) ) ?>
    </label>
    <input type="checkbox" id="<?php $this->getKey('showDropdowns');?>" onclick="SetFieldProperty('<?php $this->getKeyID('showDropdowns');?>', this.checked);" />
</li>
<li data-id="<?php $this->getKeySelf('minYear');?>" class="<?php $this->getKeySelf('minYear');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('minYear');?>">
        <?php esc_html_e( 'Min Year', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('minYear',true) ) ?>
    </label>
    <input min="1919" placeholder="2001" type="number" id="<?php $this->getKey('minYear');?>" onchange="SetFieldProperty('<?php $this->getKeyID('minYear');?>',this.value);" />
</li>
<li data-id="<?php $this->getKeySelf('maxYear');?>" class="<?php $this->getKeySelf('maxYear');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('maxYear');?>">
        <?php esc_html_e( 'Max Year', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('maxYear',true) ) ?>
    </label>
    <input min="1919" placeholder="2005" type="number" id="<?php $this->getKey('maxYear');?>" onchange="SetFieldProperty('<?php $this->getKeyID('maxYear');?>',this.value);" />
</li>
<!-- ShowDropdowns -->

<li class="<?php $this->getKeySelf('singleDatePicker'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('singleDatePicker');?>">
        <?php esc_html_e( 'SingleDatePicker', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('singleDatePicker',true) ) ?>
    </label>
    <input type="checkbox" id="<?php $this->getKey('singleDatePicker');?>" onclick="SetFieldProperty('<?php $this->getKeyID('singleDatePicker');?>', this.checked);" />
</li>

<li class="<?php $this->getKeySelf('dateFormat');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('dateFormat');?>">
        <?php esc_html_e( 'Main Date Format', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('dateFormat',true) ) ?>
    </label>
    <input placeholder="YYYY/MM/DD" type="text" id="<?php $this->getKey('dateFormat');?>" onchange="SetFieldProperty('<?php $this->getKeyID('dateFormat');?>',this.value);" />
</li>

<li class="<?php $this->getKeySelf('minDateFormat');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('minDateFormat');?>">
        <?php esc_html_e( 'Min Date', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('minDateFormat',true) ) ?>
    </label>
    <input placeholder="YYYY/MM/DD" type="text" id="<?php $this->getKey('minDateFormat');?>" onchange="SetFieldProperty('<?php $this->getKeyID('minDateFormat');?>',this.value);" />
    <p><?php esc_html_e( 'Date Format Pattern In This Field Should Match With Main Date Format Pattern.', 'dtrpg' ); ?></p>
</li>
<li class="<?php $this->getKeySelf('maxDateFormat');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('maxDateFormat');?>">
        <?php esc_html_e( 'Max Date', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('maxDateFormat',true) ) ?>
    </label>
    <input placeholder="YYYY/MM/DD" type="text" id="<?php $this->getKey('maxDateFormat');?>" onchange="SetFieldProperty('<?php $this->getKeyID('maxDateFormat');?>',this.value);" />
    <p><?php esc_html_e( 'Date Format Pattern In This Field Should Match With Main Date Format Pattern.', 'dtrpg' ); ?></p>
</li>