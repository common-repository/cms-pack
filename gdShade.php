<?php
    /**
    * name gdShade
    * class to make shades on images
    * made by Simon Hansen, http://simonhans.dk
    */



    class gdShade{
        public $image;

        function allocate_color($image=null,$color='268597',$transparency='0'){
            if (preg_match('/[0-9ABCDEF]{6}/i', $color)==0) {
                throw new Exception("Invalid color code.");
            }
            if ($transparency<0 || $transparency>127) {
                throw new Exception("Invalid transparency.");
            }

            $r  = hexdec(substr($color, 0, 2));
            $g  = hexdec(substr($color, 2, 2));
            $b  = hexdec(substr($color, 4, 2));
            if ($transparency>127) $transparency = 127;

            if ($transparency<=0)
                return imagecolorallocate($image, $r, $g, $b);
            else
                return imagecolorallocatealpha($image, $r, $g, $b, $transparency);
        }


        function hex2rgb($color) {
            $color = str_replace('#','',$color);
            $s = strlen($color) / 3;
            $rgb[]=hexdec(str_repeat(substr($color,0,$s),2/$s));
            $rgb[]=hexdec(str_repeat(substr($color,$s,$s),2/$s));
            $rgb[]=hexdec(str_repeat(substr($color,2*$s,$s),2/$s));
            return $rgb;
        }




        function __construct(){


        }

        function getIm($startColor,$endColor,$theImg,$border=0){

            $width=imagesx($theImg);
            $height=imagesy($theImg);




            list($r,$g,$b)=$this->hex2rgb('#333333');

            list($r1,$g1,$b1) = $this->hex2rgb($endColor);
            list($r2,$g2,$b2) = $this->hex2rgb($startColor);

            //     header ('Content-Type: image/png');

            $im = imagecreatetruecolor($width, $height);

            $step =1;

            $line_numbers =$height;
            $line_width=$width;


            $gradient=10;
            for ( $i = 0; $i < $gradient; $i=$i+1) {
                // old values :
                $old_r=$r;
                $old_g=$g;
                $old_b=$b;
                // new values :
                $r = ( $r2 - $r1 != 0 ) ? intval( $r1 + ( $r2 - $r1 ) * ( $i / $gradient ) ): $r1;
                $g = ( $g2 - $g1 != 0 ) ? intval( $g1 + ( $g2 - $g1 ) * ( $i / $gradient ) ): $g1;
                $b = ( $b2 - $b1 != 0 ) ? intval( $b1 + ( $b2 - $b1 ) * ( $i / $gradient  ) ): $b1;


                $fill = imagecolorallocate( $im, $r, $g, $b );


                $w=$line_width-$i*$step*1;
                $h=$line_numbers-$i*$step*1;
                $x=$i*$step;
                $y=$i*$step;

                imagefilledrectangle($im, $x, $y, $w, $h, $fill);

            }

            $im2 = imagecreatetruecolor($width, $height);

            $text_color = $this->allocate_color($im2,'ffffff');
            imagefill($im2, 4, 4, $text_color);

            imagecopymerge ( $im ,$im2 , 4, 4, 0, 0,  $w, $h , 100);

            if($border!=0){
                imagecopyresampled($theImg, $theImg, 0, 0, 0, 0, $w-$border,$h-$border, $w, $h);
                imagecopymerge ( $im ,$theImg , 4+$border/2, 4+$border/2, 0, 0,  $w-$border, $h-$border, 100);
            }else{

                imagecopymerge ( $im ,$theImg , 4, 4, 0, 0,  $w, $h , 100);

            }



            $this->image=$im;


            //imagepng($im);
            imagedestroy($theImg);
            imagedestroy($im2);

        }

    }



?>
