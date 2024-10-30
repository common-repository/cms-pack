
j={                  
    run:function(id){

        var open=0;
        jQuery('#button_'+id).click(function(){


            if(open==0){
                jQuery('#browser').css('display','block');

                open=1;

            }else{
                jQuery('#browser').css('display','none');

                open=0;

            }
            return false;
        })




        jQuery('#browser ul'  +' a').live('click',function(e){
            e.preventDefault();
            jQuery("#"+currentId).attr('value',jQuery(this).attr('href'));
            jQuery("."+currentId+ ' img').attr('src',jQuery(this).attr('url'));
            jQuery("."+currentId+ ' span').html(jQuery(this).attr('url'));


            jQuery('#browser').hide();
            return false;
        });


        //return false;
    }
}

var currentId; 




function selectBrowserSearch(mode,offset,id){
    if(id==0){


    }else{
        currentId=id;

    }
    //alert(jQuery('#inputVal').val());
    searchWord=jQuery('#inputVal').val();
    url=ajaxurl;

    jQuery.post( url, {
        "action": "sims_action",
        'offset':0,
        'searchword':searchWord,
        'searching':1,
        'mode':mode
    },function(data) {
        jQuery('#browser').html(data);
    });



    return false;

}


function selectBrowser(mode,offset,id){
    if(id==0){


    }else{
        currentId=id;

    }

    //alert(mode);

    //var  url='/wordpress/wp-content/plugins/simons-tools/cache/ajax_'+offset+'.txt';
    url=ajaxurl;

    jQuery.post( url, {
        "action": "sims_action",
        'offset':offset,
        'mode':mode
    },function(data) {
        jQuery('#browser').html(data);
    });

}                  
jQuery(document).ready(function(){  


    jQuery(window).width();   // returns width of browser viewport
    jQuery(document).width();

    jQuery('body').prepend('<div style="width:'+jQuery(document).width()+'" ><div style="margin:auto;top:50px;left:'+(jQuery(document).width()/2-440)+'px;display:none;height:560px;overflow:auto;width:800px;border:20px solid #ccc;padding:20px" id="browser"></div></div>');
    jQuery('#browser' ).css('position','fixed');
    jQuery('#browser' ).css('z-index','3');
    jQuery('#browser' ).css('background-color','#fff');

    //fix for tree page view
    jQuery('.cms_tpv_page_actions').css('margin-left','-10px');  
    jQuery('.cms_tpv_wrapper ul').css('display','none');  


    
    

    if(typeof(h) != "undefined"){

        for(var i in h)
            {


            j.run(h[i]);
        }
        //jQuery("#post").attr("enctype","multipart/form-data");
        //jQuery("#post").attr('encoding','multipart/form-data');


    }
});

