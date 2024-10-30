=== Cms Pack ===
Contributors: Simon hansen
Donate link:   none
Tags: page,posts,admin,Cms pack, image,meta,browser,submenu, latest post, cms, wordpress, framework, metaboxes,subtemplates
Requires at least: 3.0
Tested up to: 3.4.1
Stable tag: Trunk

                                                                     
Add subtemplates to wordpress. 
Submenu widget.
Imageresize.
Custom fields on page admin.
Add Content 


== Description ==   
It started out as an idea for a lot of different classes that should make wordpress better for use as cms.
Its main feature rigt now is that it enables wordpress to use subtemplates. A subtemplate is a template you can insert into your main template so you dont have to make a hole new page template if you only want to have a new element on your page.


Cms-pack lets you easily select a relation to a page with its own page-select browser. You can easily select an image from your gallery and put it on your front page.



More info here:<a href="http://simonhans.dk/cms-pack/">Info about the plugin</a>

**Features**

* Subtemplates: cms pack adds subtemplates to your wordpress pages. On the page you can select different designed content elements, like a page with an latest post element as seen on simonhans.dk . It is easy to make your own subtemplates.
* Image select field: Cms pack lets you easily select an image fron your gallery.

* Page select field: Cms pack lets select a page an internal page to link to.

* Category select field: Cms pack lets you select a post category, for easy displaying list of posts.

* Submenu: Cms pack has an submenu widget.

* Image: Cms pack lets you make drop shadow an round corner on images. It resizes by scaling or crop-scale.   



== Installation == 


###Installing The Plugin###

Extract all files from the ZIP file, making sure to keep the file structure intact, and then upload it to `/wp-content/plugins/`.

Then just visit your admin area and activate the plugin.

From version 1.7 , use the Cms Pack admin page to set the width of your content area of your webpage

###Plugin Usage###
                                                
When installed you will have and option to select a subtemplate for your pages. They use the width of your webpages content
area so be sure to go to Cms Packs admin panel and set the width.

Look in the folder subTemplates and see example off how to make a subtemplate




== Frequently Asked Questions ==

##How to use:## 

                                                                                 
==Changelog ==


= Version 1.8 =
* Addded support for other background-colors than white for the image-script. Set the hex-color code for your content-areas color in the "cms pack" admin panel



= Version 1.7 =
* New shadow generator
* Addded admin page where you can set the width of your content area
* Made examples calculate the width of images with the use of the width of content area.


= Version 1.6 =
* removed content on page feature
* fixed the examples. Some of the had errors. Now they should be plug n play. 


= Version 1.5 =
* minor bug 

= Version 1.4 =
* Removed timthumb completely. It is not used anymore. I have been notisfied that the rather old version of timtumb I was using had security isues. Everybody should therefore upgrade to version 1.4

= Version 1.3 =
* Added content type "content" that can be used to have more galleries on a page.

= Version 1.2.2 =
* improved imageresize

= Version 1.2.1 =
* css fix

= Version 1.2 =
* added drop shade abillity for the image resize class

= Version 1.1 =
* updated cms-pack submenu
* Has now a wiget, so you dont have to fiddle with my code
* Minor change in basetemplate

= Version 1.0 =
* Tested and ready for 1.0
* Small fixes  

= Version 0.9.3 =
* More examples, ready to use templates
* New image resize class
* Move cache dir and upload to wp-conten/uploads/cms-pack-cache/dir
* Added abillity to make position input-fields in columns
* Added labels in examples  

= Version 0.9.2 =
* better page and image select browser. Added search to limit
* Changed varnames to be unike in examples. Sorry if you use them. Delete the prefixed class name of the var names in the examples if you need to.
* Added more examples

= Version 0.9.1 =    
* bugfixes
* updated to newest wersion off timthumb
* Better examples

= Version 0.9 =    
* inital release

 
 ==Upgrade Notice ==
To upgrade from a previous version of this plugin, delete the entire folder and files from the previous version of the plugin except the subtemplates you use. Typically the ones in the yours_templates folder. 
 
== Screenshots == 
1. The imagebrowser.   
2. Subtemplate.          