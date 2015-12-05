

    var pricing = {
        1820: {
            retail: {
                '7oz': 699.00,
                '8oz': 899.00,
                '9oz': 1049.00
            },
            dealer: {
                '7oz': null,
                '8oz': 699.00,
                '9oz': 799.00
            }
        },
        2123: {
            retail: {
                '7oz': 749.00,
                '8oz': 949.00,
                '9oz': 1099.00
            },
            dealer: {
                '7oz': null,
                '8oz': 749.00,
                '9oz': 849.00
            }
        },
        2426: {
            retail: {
                '7oz': 899.00,
                '8oz': 1099.00,
                '9oz': 1249.00
            },
            dealer: {
                '7oz': null,
                '8oz': 899.00,
                '9oz': 999.00
            }
        },
        2729: {
            retail: {
                '7oz': null,
                '8oz': 1450.00,
                '9oz': 1600.00
            },
            dealer: {
                '7oz': null,
                '8oz': 1088.00,
                '9oz': 1188.00
            }
        },
        3033: {
            retail: {
                '7oz': 1850.00,
                '8oz': 2050.00,
                '9oz': 2200.00
            },
            dealer: {
                '7oz': null,
                '8oz': 1599.00,
                '9oz': 1699.00
            }
        },
        3436: {
            retail: {
                '7oz': 2150.00,
                '8oz': 2350.00,
                '9oz': 2500.00
            },
            detail: {
                '7oz': null,
                '8oz': 1833.00,
                '9oz': 1933.00
            }
        },
        3740: {
            retail: {
                '7oz': 3000.00,
                '8oz': 3200.00,
                '9oz': 3350.00
            },
            detail: {
                '7oz': null,
                '8oz': 2560.00,
                '9oz': 2660.00
            }
        }

    }
    var color = {
        'N': {
            'name': 'Navy',
            'fabric':['9oz','8oz','7oz']
        },
        'B':{
            'name': 'Black',
            'fabric':['9oz','8oz','7oz']
        },
        'G':{
            'name': 'Gray',
            'fabric':['9oz']
        },
        'T':{
            'name': 'Tan',
            'fabric':['9oz']
        }
    }
    var sku = {
        0: 'make',
        1: 'model',
        2: 'year',
        3: 'boat_length',
        4: 'fabric',
        5: 'color',
        6: 'motors',
        7: 'bow_rails',
        8: 'bow_pulpit',
        9: 'bow_roller',
        10: 't-top_type',
        11: 'zipper'
    }
    var item = {}
    var price = 0;
    
jQuery(function($){
    

    function getItem() {
        item = jQuery('#fields').data('fields');
        getOptions();
        calculatePrice();
    }
    
    function getOptions () {
        var opts = {};
        $.each($('.item-option input, .item-option select'), function(k,v) {
            if($(this).prop('type') == 'checkbox') {
                
                if($(this).is(':checked')) {
                    opts[$(this).prop('name')] = 'Yes';
                } else {
                    opts[$(this).prop('name')] = 'No';
                }
            } else {
                var val = $(this).val();
                opts[$(this).prop('name')] = (val == "X" ? null : val);
            }
            
        })
        item.options = opts;
    }
    
    function setValues () {
        
    }
    
    
    function adjustColors() {
        console.log('adjusting colors');
        var elem = $('[name="color"]');
        var fab = item.options.fabric;
        var select = elem.children('[value="X"]');
        $.each(elem.children('[value!="X"]'),function(k,v) {
            var option = $(v);
            var c = color[option.val()];
            if(($.inArray(fab,c.fabric)!=-1)) {
                $(this).prop('disabled',false).text(c.name);
            } else {
                $(this).prop('disabled',true).text(c.name + ' - 9oz Only')
            }
            
        })
        console.log(elem.children('[value='+item.options['color']+']').is(':disabled'))
        if (elem.children('[value='+item.options['color']+']').is(':disabled')) {
            select.prop('selected',true);
        } else {
            elem.children('[value='+item.options['color']+']').prop('selected', true);
        }
    }

    function getSKU() {
        var id = [];
        $.each(sku, function(k,v) {
            id.push((item.details[v] ? item.details[v] : 'X').toUpperCase());
        })

        var SKUid = id.join('|');
        return SKUid;
    }

    function calculatePrice () {
        var size = item.options.boat_length
        var fabric = item.options.fabric
        item.total = (fabric == parseInt(0) ? 'Choose a Fabric' : parseInt(pricing[size]['retail'][fabric]));
    }
    function get(key) {
        return item[key];
    }
    function publishPrice() {
        var subtotal = item.total*item.qty;
        $('#price').html(subtotal.toFixed(2));
    }
    function refreshForm() {
        getItem();
        console.log(item);
        publishPrice();
        adjustColors();
    }
    function init() {
        getItem();
        adjustColors();
    }
    
    $(document).ready(function(){
//        refreshForm();
        $('.item-option input, .item-option select').on('change', function(){
            refreshForm();
        })
        
        $('#storage').on('change',function(){
            if($(this).val() == 'IW') {
                if(confirm('These covers are not designed for in-water use, please consider our Center Console Curtains.')) {
                    window.location = 'http://laportes/products/center-console-curtain';
                }
            }
        })
        
    })

})
jQuery(document).ready(function($) { 
    $('#pp_helper_close').on('click',function(){ 
        var val = $('[name=pp_helper]:checked').val(); 
        $('[name=power_pole_mount]').val(val).trigger('change'); 
    }) 
    
    if($('#power_poles').val() != 'PP-N') {
        $('#power_poles').parent().parent().removeClass('uk-width-1-2');
        $('#power_poles').parent().parent().addClass('uk-width-1-4');
        $('#power_pole_mount').parent().parent().removeClass('uk-hidden');
    }else{
        $('#power_poles').parent().parent().removeClass('uk-width-1-4');
        $('#power_poles').parent().parent().addClass('uk-width-1-2');
        $('#power_pole_mount').parent().parent().addClass('uk-hidden');
    }
});

