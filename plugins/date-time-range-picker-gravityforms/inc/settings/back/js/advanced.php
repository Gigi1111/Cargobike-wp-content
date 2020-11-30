<?php if ( ! defined( 'ABSPATH' ) ) {exit;} 
/*
return to admin_print_scripts:editorScript
*/
?>

    var FILED = '';

    jQuery(document).on('gform_load_field_settings', function(event, field, form){

        FILED = field;
        addToResult();

    });
    

    function AddPush(label , base , num){
        var object = jQuery('.'+FILED.id);
        var values = object.val();

        var xc = null;

            if(object.val() == ''){
                var newx = [];
                object.val( JSON.stringify(newx) );
            }
   
            xc = JSON.parse(object.val());
            var old = [];
            
            el = {};
            el.id = Math.floor(Math.random() * 1000000),
            el.label = label;
            el.base = base;

            xc.push(el);

            object.val(JSON.stringify(xc));

            //console.log(object.val());
        
            SetFieldProperty('<?php $this->getKeyID('range');?>',object.val());

            addToResult();

            //jQuery('.range-ul-result').append("<li>"+label+"</li>");
    }

    function removeList(me){
        var object = jQuery('.'+FILED.id);
        me = jQuery(me);
        var xc = JSON.parse(object.val());
        
        var d_ID = me.attr("data-id");

        for (let index = 0; index < xc.length; index++) {
            
            if( xc[index].id == d_ID ){
                

                var rm = xc.splice(index,1);

                object.val(JSON.stringify(xc));

                SetFieldProperty('<?php $this->getKeyID('range');?>',object.val());

                return addToResult();
            }

            }
    }

    function editList(me){
        var object = jQuery('.'+FILED.id);
        me = jQuery(me);
        var xc = JSON.parse(object.val());
        
        var d_ID = me.attr("data-id");
        var d_KEY = me.attr("data-key");

        for (let index = 0; index < xc.length; index++) {
            
            if( xc[index].id == d_ID ){
                
                switch (d_KEY) {
                    case 'label':
                        xc[index].label = me.val();
                        break;
                    case 'base':
                        xc[index].base = me.val();
                        break;
                }

                object.val(JSON.stringify(xc));

                SetFieldProperty('<?php $this->getKeyID('range');?>',object.val());
                
            }

            }
    }

    function addToResult(){

            jQuery('.'+FILED.id).parent().find('.range-ul-result').html("");

            var object = jQuery('.'+FILED.id);
            console.log(FILED.id);
            if(object.val() == ''){
                return;
            }

            var xc = JSON.parse(object.val());

            for (let index = 0; index < xc.length; index++) {
                jQuery('.'+FILED.id).parent().find('.range-ul-result').append(
                "<li>"+
                "<div>Label : <input data-key='label' data-id='"+xc[index].id+"' value='"+xc[index].label+"' onchange='editList(this)' type='text'></div>"+
                "<div>Code : <textarea style='width:100%;' data-key='base' data-id='"+xc[index].id+"' onchange='editList(this)'>"+xc[index].base+"</textarea><button data-id='"+xc[index].id+"' class='button' onclick='removeList(this)'>Delete</button></div>"
                +"</li>");

            }
    }