<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}

class DTRPG_Setting extends DTRPG_Settings{
    
    private $settingList;

    function __construct(){

        $this->settingList = parent::initSettingList();
        add_action( 'admin_print_scripts', [$this,'editorScript'], 99 );
        add_action( 'admin_print_styles', [$this,'editorStyle'], 99 );
        add_action( 'gform_field_standard_settings', [$this,'standardFields'], 10, 2 );
        add_action( 'gform_field_appearance_settings', [$this,'appearanceFields'], 10, 2 );
        add_action( 'gform_field_advanced_settings', [$this,'advancedFields'], 10, 2 );
        add_filter( 'gform_tooltips', [$this,'tooltips'] );

    }

    function standardFields($position, $form_id){
        if ( $position == 25 ) {
            ob_start();
                include_once(DTRPG_DIR."/inc/settings/back/standard-list.php");
            echo ob_get_clean();
        }
    }

    function appearanceFields($placement, $form_id){
        if ( $placement == 50 ) {
            ob_start();
                include_once(DTRPG_DIR."/inc/settings/back/appearance-list.php");
            echo ob_get_clean();
        }
    }

    function advancedFields($placement, $form_id){
        if ( $placement == 50 ) {
            ob_start();
                include_once(DTRPG_DIR."/inc/settings/back/advanced-list.php");
            echo ob_get_clean();
        }
    }
    //admin_print_styles
    function editorStyle(){
        ?>
            <style>
            .range-ul li{
                display: grid;
                grid-template-columns: 1fr 3fr;
            }
            .range-ul-result li{
                display: grid;
                grid-template-columns:1fr 5fr;
            }
            </style>
        <?php
    }

    //admin_print_scripts
    function editorScript(){
        ?>
        <script type='text/javascript'>
            jQuery(document).on('gform_load_field_settings', function(event, field, form){
                <?php
                    
                    foreach ($this->settingList as $key => $value) {
                        $key = $this->cleanKey($key);
                        switch ($this->getValue($key , 0 , true)) {
                            case 'selectbox':
                                ?>
                                if( field.<?php $this->getKeyID($key);?> != undefined ){
                                    jQuery('#<?php $this->getKey($key);?>').val(field.<?php $this->getKeyID($key);?>);
                                }
                                <?php
                                break;
                            case 'checkbox':
                                ?>
                                    jQuery('#<?php $this->getKey($key);?>').attr('checked', field.<?php $this->getKeyID($key);?> == true);
                                <?php
                                break;
                            case 'textbox':
                                ?>
                                    jQuery('#<?php $this->getKey($key);?>').val(field.<?php $this->getKeyID($key);?>);
                                <?php
                                break;
                        }
                    }    
                ?>


                jQuery('#<?php $this->getKey('range');?>').attr("class",field.id);
                
                if(field.<?php $this->getKeyID('autoUpdateInput');?> == undefined){
                    jQuery('#<?php $this->getKey('autoUpdateInput');?>').attr('checked', true);
                    SetFieldProperty('<?php $this->getKeyID('autoUpdateInput');?>',true);
                }

                <?php
                    ob_start();
                        include_once(DTRPG_DIR."/inc/settings/back/js/hide-show.php");
                    echo str_replace(['<script>','</script>'],['',''],ob_get_clean());
                ?> 


            });

            function hide_show_init(el , childs , on = false){
                
                for (let index = 0; index < childs.length; index++) {
                    jQuery('[data-id="'+childs[index]+'"]').hide();
                }

                    var obj = jQuery("#"+el);

                    if( obj.is(":checked") ){

                        for (let index = 0; index < childs.length; index++) {
                            jQuery('[data-id="'+childs[index]+'"]').show();
                        }
                    }else{
                        for (let index = 0; index < childs.length; index++) {
                            jQuery('[data-id="'+childs[index]+'"]').hide();
                        }
                    }
            }

            <?php
                ob_start();
                    include_once(DTRPG_DIR."/inc/settings/back/js/advanced.php");
                echo ob_get_clean();
            ?>
        </script>
        <?php
    }

    function tooltips( $tooltips ) {

        $tooltips['form_'.$this->getKey('open',true)] =  esc_attr__( "<h6>Opens</h6>Whether the picker appears aligned to the left, to the right, or centered", 'dtrpg' );
        
        $tooltips['form_'.$this->getKey('drops',true)] = esc_attr__("<h6>Drops</h6>Whether the picker appears below (default) or above the HTML element it's attached to.", 'dtrpg');
        
        $tooltips['form_'.$this->getKey('timePicker',true)] = esc_attr__("<h6>timePicker</h6>Adds select boxes to choose times in addition to dates.", 'dtrpg');
        
        $tooltips['form_'.$this->getKey('showDropdowns',true)] = esc_attr__("<h6>ShowDropdowns</h6>Show year and month select boxes above calendars to jump to a specific month and year.", 'dtrpg');
        
        $tooltips['form_'.$this->getKey('singleDatePicker',true)] = esc_attr__("<h6>SingleDatePicker</h6>Show only a single calendar to choose one date, instead of a range picker with two calendars. The start and end dates provided to your callback will be the same single date chosen.", 'dtrpg');
                
        $tooltips['form_'.$this->getKey('dateFormat',true)] = esc_attr__("<h6>DateFormat</h6>Allows you to customize the date format.", 'dtrpg');
        
        $tooltips['form_'.$this->getKey('timePicker24Hour',true)] = esc_attr__("<h6>TimePicker24Hour</h6>Use 24-hour instead of 12-hour times, removing the AM/PM selection.", 'dtrpg');
        
        $tooltips['form_'.$this->getKey('timePickerIncrement',true)] = esc_attr__("<h6>TimePickerIncrement</h6> Increment of the minutes selection list for times (i.e. 30 to allow only selection of times ending in 0 or 30).", 'dtrpg');
        
        $tooltips['form_'.$this->getKey('maxSpanStatus',true)] = esc_attr__("<h6>MaxSpan</h6>The maximum span between the selected start and end dates.", 'dtrpg');;
        
        $tooltips['form_'.$this->getKey('range',true)] = esc_attr__("<h6>Range</h6>Set predefined date ranges the user can select from. Each key is the label for the range, and its value an array with two dates representing the bounds of the range.", 'dtrpg');
       
        $tooltips['form_'.$this->getKey('minDateFormat',true)] = esc_attr__("<h6>MinDate</h6>The earliest date a user may select.", 'dtrpg');;
        $tooltips['form_'.$this->getKey('maxDateFormat',true)] = esc_attr__("<h6>MaxDate</h6>The latest date a user may select.", 'dtrpg');;
      
        $tooltips['form_'.$this->getKey('minYear',true)] = esc_attr__("<h6>MinYear</h6>The minimum year shown in the dropdowns when showDropdowns is checked.", 'dtrpg');;
        $tooltips['form_'.$this->getKey('maxYear',true)] = esc_attr__("<h6>MaxYear</h6>The maximum year shown in the dropdowns when showDropdowns is checked.", 'dtrpg');;
        
        $tooltips['form_'.$this->getKey('startDate',true)] = esc_attr__("<h6>StartDate</h6>The beginning date of the initially selected date range. If you provide a string, it must match the date format string set in your Main Date Format Field.", 'dtrpg');
        $tooltips['form_'.$this->getKey('endDate',true)] = esc_attr__("<h6>EndDate</h6>The end date of the initially selected date range.", 'dtrpg');;

        $tooltips['form_'.$this->getKey('autoUpdateInput',true)] = esc_attr__("<h6>AutoUpdateInput</h6>Indicates whether the date range picker should automatically update the value of the < input > element it's attached to at initialization and when the selected dates change.", 'dtrpg');
        
        return $tooltips;
     }

}
