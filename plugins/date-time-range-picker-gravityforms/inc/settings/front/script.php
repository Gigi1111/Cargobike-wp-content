<?php if ( ! defined( 'ABSPATH' ) ) {exit;}
/*
    return to wp_add_inline_script
*/
?>
var <?php echo $field_id;?>_date = '<?php echo($field_option['dateFormatField'] != '' ? $field_option['dateFormatField'] : 'YYYY/MM/DD');?>';

<?php if( $field_option['timePickerField'] != '' ):?>  

    <?php if( !boolval($field_option['timePicker24HourField']) ): ?>
        <?php echo $field_id;?>_date += ' (hh:mm A)';
    <?php else: ?>
        <?php echo $field_id;?>_date += ' (H:mm)';
    <?php endif;?>

<?php endif;?>
jQuery('#<?php echo $field_id;?>').daterangepicker(
            {
                <?php if( $field_option['rangeField'] == '' ||  $field_option['rangeField'] == '[]'): ?>
                <?php if( $field_option['singleDatePickerField'] != '' ):?>
                singleDatePicker: <?php echo ( $field_option['singleDatePickerField'] == '1' ? 'true' : 'false');?>,
                <?php endif;?>
                <?php endif;?>

                locale: {
                   format: <?php echo $field_id;?>_date,
                    "applyLabel": "<?php esc_html_e( 'Apply', 'dtrpg' );?>",
                    "cancelLabel": "<?php esc_html_e( 'Cancel', 'dtrpg' );?>",
                    "fromLabel": "<?php esc_html_e( 'From', 'dtrpg' );?>",
                    "toLabel": "<?php esc_html_e( 'To', 'dtrpg' );?>",
                    "customRangeLabel": "<?php esc_html_e( 'Custom', 'dtrpg' );?>",
                    "daysOfWeek": [
                        "<?php esc_html_e( 'Su', 'dtrpg' );?>",
                        "<?php esc_html_e( 'Mo', 'dtrpg' );?>",
                        "<?php esc_html_e( 'Tu', 'dtrpg' );?>",
                        "<?php esc_html_e( 'We', 'dtrpg' );?>",
                        "<?php esc_html_e( 'Th', 'dtrpg' );?>",
                        "<?php esc_html_e( 'Fr', 'dtrpg' );?>",
                        "<?php esc_html_e( 'Sa', 'dtrpg' );?>"
                    ],
                    "monthNames": [
                        "<?php esc_html_e( 'January', 'dtrpg' );?>",
                        "<?php esc_html_e( 'February', 'dtrpg' );?>",
                        "<?php esc_html_e( 'March', 'dtrpg' );?>",
                        "<?php esc_html_e( 'April', 'dtrpg' );?>",
                        "<?php esc_html_e( 'May', 'dtrpg' );?>",
                        "<?php esc_html_e( 'June', 'dtrpg' );?>",
                        "<?php esc_html_e( 'July', 'dtrpg' );?>",
                        "<?php esc_html_e( 'August', 'dtrpg' );?>",
                        "<?php esc_html_e( 'September', 'dtrpg' );?>",
                        "<?php esc_html_e( 'October', 'dtrpg' );?>",
                        "<?php esc_html_e( 'November', 'dtrpg' );?>",
                        "<?php esc_html_e( 'December', 'dtrpg' );?>"
                    ]
                },

                <?php if( $field_option['rangeField'] == '' ||  $field_option['rangeField'] == '[]'): ?>
                autoUpdateInput: <?php echo ( $field_option['autoUpdateInputField'] == '1' ? 'true' : 'false');?>,
                <?php endif;?>

                <?php if( $field_option['startDateField'] != '' ):?>
                startDate:'<?php echo $field_option['startDateField'];?>',
                <?php endif;?>
                <?php if( $field_option['endDateField'] != '' ):?>
                endDate:'<?php echo $field_option['endDateField'];?>',
                <?php endif;?>

                <?php if( $field_option['rangeField'] != '' && $field_option['rangeField'] != '[]' ): ?>
                ranges: {
                <?php
                foreach (json_decode($field_option['rangeField'],true) as $key => $value) {
                    echo "'{$value['label']}': ".$value['base'].','."\r";
                }
                ?>
                },
            <?php endif;?>

                <?php if( boolval($field_option['maxSpanStatusField']) ): ?>
                    "maxSpan": {
                        "<?php echo $field_option['maxSpanBaseField'];?>": <?php echo $field_option['maxSpanNumField'];?>
                    },
                <?php endif;?>

                <?php if( $field_option['openField'] != '' ):?>
                opens: '<?php echo $field_option['openField'];?>',
                <?php endif;?>
                <?php if( $field_option['dropsField'] != '' ):?>
                drops:'<?php echo $field_option['dropsField'];?>',
                <?php endif;?>
                
                <?php if( $field_option['timePickerField'] != '' ):?>
                timePicker: <?php echo ( $field_option['timePickerField'] == '1' ? 'true' : 'false');?>,
                <?php endif;?>

                <?php if( $field_option['timePicker24HourField'] != '' ):?>
                timePicker24Hour:<?php echo ( $field_option['timePicker24HourField'] == '1' ? 'true' : 'false');?>,
                <?php endif;?>


                <?php if( $field_option['timePickerIncrementField'] != '' ):?>
                timePickerIncrement:<?php echo $field_option['timePickerIncrementField'];?>,
                <?php endif;?>


                <?php if( $field_option['minDateFormatField'] != '' ):?>
                minDate: "<?php echo $field_option['minDateFormatField'];?>",
                <?php endif;?>
                <?php if( $field_option['maxDateFormatField'] != '' ):?>
                maxDate: "<?php echo $field_option['maxDateFormatField'];?>",
                <?php endif;?>

                <?php if( $field_option['minYearField'] != '' ):?>
                minYear: <?php echo $field_option['minYearField'];?>,
                <?php endif;?>
                <?php if( $field_option['maxYearField'] != '' ):?>
                maxYear: <?php echo $field_option['maxYearField'];?>,
                <?php endif;?>
                

                <?php if( $field_option['showDropdownsField'] != '' ):?>
                showDropdowns: <?php echo ( $field_option['showDropdownsField'] == '1' ? 'true' : 'false');?>,
                <?php endif;?>
            }
);

//autoUpdateInput
<?php if( !boolval($field_option['autoUpdateInputField']) ):?>
jQuery('#<?php echo $field_id;?>').on('apply.daterangepicker', function(ev, picker) {
    <?php if( !boolval($field_option['singleDatePickerField']) ):?>
        jQuery(this).val(picker.startDate.format(<?php echo $field_id;?>_date) + ' - ' + picker.endDate.format(<?php echo $field_id;?>_date));
    <?php else:?>
        jQuery(this).val(picker.startDate.format(<?php echo $field_id;?>_date));
    <?php endif;?>
});
<?php endif;?>
