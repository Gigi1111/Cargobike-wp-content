<?php if ( ! defined( 'ABSPATH' ) ) {exit;} 
/*
return to admin_print_scripts:editorScript
*/
?>
    hide_show_init('<?php $this->getKey('maxSpanStatus');?>',[
        '<?php $this->getKeySelf('maxSpanBase');?>',
        '<?php $this->getKeySelf('maxSpanNum');?>'
    ]);

    jQuery('#<?php $this->getKey('maxSpanStatus');?>').change(function (e) { 
            hide_show_init(jQuery(this).attr("id"),[
            '<?php $this->getKeySelf('maxSpanBase');?>',
            '<?php $this->getKeySelf('maxSpanNum');?>'
            ]);
    });

    //minYear
    hide_show_init('<?php $this->getKey('showDropdowns');?>',[
        '<?php $this->getKeySelf('minYear');?>',
        '<?php $this->getKeySelf('maxYear');?>'
    ]);

    jQuery('#<?php $this->getKey('showDropdowns');?>').change(function (e) { 
            hide_show_init(jQuery(this).attr("id"),[
            '<?php $this->getKeySelf('minYear');?>',
            '<?php $this->getKeySelf('maxYear');?>'
            ]);
    });

    //TimePicker
    hide_show_init('<?php $this->getKey('timePicker');?>',[
        '<?php $this->getKeySelf('timePicker24Hour');?>',
        '<?php $this->getKeySelf('timePickerIncrement');?>',
    ]);

    jQuery('#<?php $this->getKey('timePicker');?>').change(function (e) { 
            hide_show_init(jQuery(this).attr("id"),[
            '<?php $this->getKeySelf('timePicker24Hour');?>',
            '<?php $this->getKeySelf('timePickerIncrement');?>'
            ]);
    });