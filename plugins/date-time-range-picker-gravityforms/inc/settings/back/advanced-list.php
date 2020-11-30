<?php if ( ! defined( 'ABSPATH' ) ) {exit;} ?>

<li data-id="<?php $this->getKeySelf('range'); ?>" class="<?php $this->getKeySelf('range'); ?> field_setting">
    <label class="section_label" for="<?php $this->getKey('range');?>">
        <?php esc_html_e( 'Ranges', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('range',true) ) ?>
    </label>
    <input type="hidden" id="<?php $this->getKey('range');?>" onchange="SetFieldProperty('<?php $this->getKeyID('range');?>',this.value);" />
    <div>
        <ul class="range-ul">
            <li>
            <div><?php echo esc_html_e('Label: ','dtrpg');?> <input placeholder="Today" style="width:100%;" class="xlabelx" type="text"></div>
            <div><?php echo esc_html_e('Code: ','dtrpg');?> <input placeholder="Moment.js Example: [moment(), moment()]" style="width:100%;" class="xbasex" type="text">
            <span><?php echo esc_html_e('Use Moment.js','dtrpg');?></span>
            </div>
            </li>
        </ul>
        <button class="button" onclick="AddPush(document.querySelector('.xlabelx').value, document.querySelector('.xbasex').value)"><?php echo esc_html_e('Add Range','dtrpg');?></button>
        <h4><?php echo esc_html_e('Range List:','dtrpg');?></h4>
        <ul class="range-ul-result">
        </ul>

    </div>
</li>

<li class="<?php $this->getKeySelf('autoUpdateInput');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('autoUpdateInput');?>">
        <?php esc_html_e( 'Auto Update Input', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('autoUpdateInput',true) ) ?>
    </label>
    <input type="checkbox" id="<?php $this->getKey('autoUpdateInput');?>" onclick="SetFieldProperty('<?php $this->getKeyID('autoUpdateInput');?>',this.checked);" />
</li>

<li class="<?php $this->getKeySelf('startDate');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('startDate');?>">
        <?php esc_html_e( 'Start Date', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('startDate',true) ) ?>
    </label>
    <input placeholder="YYYY/MM/DD" type="text" id="<?php $this->getKey('startDate');?>" onchange="SetFieldProperty('<?php $this->getKeyID('startDate');?>',this.value);" />
    <p><?php esc_html_e( 'Date Format Pattern In This Field Should Match With Main Date Format Pattern.', 'dtrpg' ); ?></p>
</li>
<li class="<?php $this->getKeySelf('endDate');?> field_setting">
    <label class="section_label" for="<?php $this->getKey('endDate');?>">
        <?php esc_html_e( 'End Date', 'dtrpg' ); ?>
        <?php gform_tooltip( 'form_'.$this->getKey('endDate',true) ) ?>
    </label>
    <input placeholder="YYYY/MM/DD" type="text" id="<?php $this->getKey('endDate');?>" onchange="SetFieldProperty('<?php $this->getKeyID('endDate');?>',this.value);" />
    <p><?php esc_html_e( 'Date Format Pattern In This Field Should Match With Main Date Format Pattern.', 'dtrpg' ); ?></p>
</li>