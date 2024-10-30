<?php

  

    function cmsPackWarningUploadFolder()
    {
        echo '<div class="updated fade"><p>Cms-pack could not create the "Uploads" folder. Please create a folder named
        uploads in the &quot;wp-content&quot; folder of your WordPress installation.</div>'; 
    }


    function cmsPackWarningCmsPackFolder()
    {
        echo '<div class="updated fade"><p>Cms-pack could not create the "cms-pack-cache" folder. Please create a folder named
        cms-pack-cache in the &quot;wp-content/uploads&quot; folder of your WordPress installation.</div>'; 
    }

   
   
    if( !is_dir( WP_CONTENT_DIR . '/uploads'    ) )
    {
        if( !@mkdir( WP_CONTENT_DIR . '/uploads'    ) )
        {

            add_action('admin_notices', 'cmsPackWarningUploadFolder');
        }
    }  





    if( !is_dir( WP_CONTENT_DIR . '/uploads'    ) )
    {
        if( !@mkdir( WP_CONTENT_DIR . '/uploads'    ) )
        {

            add_action('admin_notices', 'cmsPackWarningUploadFolder');
        }
    }  


    if( !is_dir( CMS_PACK_CACHE) ){



        if( !@mkdir( CMS_PACK_CACHE   ) )
        {

            add_action('admin_notices', 'cmsPackWarningCmsPackFolder');
        }else{

            chmod(CMS_PACK_CACHE   ,0777);

        }




    }




?>