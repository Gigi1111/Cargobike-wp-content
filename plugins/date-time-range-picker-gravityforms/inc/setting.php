<?php
if ( ! defined( 'ABSPATH' ) ) {exit;}

class DTRPG_Settings{

    public $setting_prefix = 'dtrpg_';
    public $setting_suffix = '_setting';

    public $field_prefix = 'dtrpg_field_';
    public $field_suffix = '_value';

    public static $instance;
    
    private $settingList;

    public static function get() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    function __construct(){
        $this->initSettingList();
    }

    function initSettingList(){

        $this->settingList[$this->setting_prefix.'open'.$this->setting_suffix] = ['selectbox'];
        $this->settingList[$this->setting_prefix.'timePicker'.$this->setting_suffix] = ['checkbox'];
        $this->settingList[$this->setting_prefix.'showDropdowns'.$this->setting_suffix] = ['checkbox'];
        $this->settingList[$this->setting_prefix.'singleDatePicker'.$this->setting_suffix] = ['checkbox'];
        $this->settingList[$this->setting_prefix.'baseThemeColor'.$this->setting_suffix] = ['textbox'];
        $this->settingList[$this->setting_prefix.'drops'.$this->setting_suffix] = ['selectbox'];
        $this->settingList[$this->setting_prefix.'dateFormat'.$this->setting_suffix] = ['textbox'];
        $this->settingList[$this->setting_prefix.'timePicker24Hour'.$this->setting_suffix] = ['checkbox'];
        $this->settingList[$this->setting_prefix.'timePickerIncrement'.$this->setting_suffix] = ['textbox'];
        //groupmaxSpan
        $this->settingList[$this->setting_prefix.'maxSpanStatus'.$this->setting_suffix] = ['checkbox'];
        $this->settingList[$this->setting_prefix.'maxSpanBase'.$this->setting_suffix] = ['selectbox'];
        $this->settingList[$this->setting_prefix.'maxSpanNum'.$this->setting_suffix] = ['textbox'];
        //groupmaxSpan
        $this->settingList[$this->setting_prefix.'range'.$this->setting_suffix] = ['textbox'];
        $this->settingList[$this->setting_prefix.'minDateFormat'.$this->setting_suffix] = ['textbox'];
        $this->settingList[$this->setting_prefix.'maxDateFormat'.$this->setting_suffix] = ['textbox'];
        
        $this->settingList[$this->setting_prefix.'minYear'.$this->setting_suffix] = ['textbox'];
        $this->settingList[$this->setting_prefix.'maxYear'.$this->setting_suffix] = ['textbox'];
        
        $this->settingList[$this->setting_prefix.'startDate'.$this->setting_suffix] = ['textbox'];
        $this->settingList[$this->setting_prefix.'endDate'.$this->setting_suffix] = ['textbox'];
        
        $this->settingList[$this->setting_prefix.'autoUpdateInput'.$this->setting_suffix] = ['checkbox'];
        
        return $this->settingList;
    }

    function cleanKey($name , $return = true){
        $name = str_replace([$this->setting_prefix,$this->setting_suffix,$this->field_prefix,$this->field_suffix],['','','',''],$name);//timePicker
        if($return)
            return $name;

        echo $name;
    }

    function getValue($name , $index , $return = false){
        $name = $this->setting_prefix.$name.$this->setting_suffix;
        if($return)
            return $this->settingList[$name][$index];

        echo $this->settingList[$name][$index];
    }

    function getKey($name , $return = false){
        $old_name = $name;
        $name = $this->setting_prefix.$name.$this->setting_suffix;
        
        $arr = $this->settingList;

        if($return)
            return str_replace([$this->setting_prefix,$this->setting_suffix],[$this->field_prefix,$this->field_suffix],$this->getKeySelf($old_name, true));

        echo str_replace([$this->setting_prefix,$this->setting_suffix],[$this->field_prefix,$this->field_suffix],$this->getKeySelf($old_name, true));
    }

    function getKeyID($name , $return = false){
        $old_name = $name;
        $name = $this->setting_prefix.$name.$this->setting_suffix;
        if($return)
            return str_replace([$this->setting_prefix,$this->setting_suffix,$this->field_prefix,$this->field_suffix],['','','',''],$old_name)."Field";

        echo str_replace([$this->setting_prefix,$this->setting_suffix,$this->field_prefix,$this->field_suffix],['','','',''],$old_name)."Field";
    }

    function getKeySelf($name , $return = false){

        foreach ($this->settingList as $key => $value) {
            $lk = $key;
            $name = $name;
            $lk = str_replace([$this->setting_prefix,$this->setting_suffix,$this->field_prefix,$this->field_suffix],['','','',''],$key);

            if( $lk == $name ){

                if($return){

                    return $key;

                }else{

                    echo $key;
                    break;
                }

            }
        }
    }

}
