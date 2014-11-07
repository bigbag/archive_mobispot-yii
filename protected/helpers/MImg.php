<?php
class MImg
{
    const JPG_QUALITY = 100;
    
    const T_CARD_FRAME = '/themes/mobispot/img/card_frame.jpg';
    //const CARD_WIDTH = 321;
    //const CARD_HEIGHT = 513;
    const PHOTO_WIDTH = 165;
    const PHOTO_HEIGHT = 165;
    const CARD_HAT = 98;
    const CARD_FONT = '/themes/mobispot/fonts/mobispot-webfont.ttf';
    const NAME_SIZE = 25;
    const POSITION_SIZE = 14;
    const NAME_STRLEN = 14;
    const POSITION_STRLEN = 23;
    const LOGO_WIDTH = 230;
    const LOGO_HEIGHT = 60;
    
    //обрезает изображение по заданной пропорции, сохраняет в jpg
    public static function cutToProportionJpg($source_path, $result_path, $sample_x, $sample_y)
    {
        $img_attr = getimagesize($source_path);

        switch ( $img_attr[2] ) {
            case 1: $source = imagecreatefromgif($source_path); break;
            case 2: $source = imagecreatefromjpeg($source_path); break;
            case 3: $source = imagecreatefrompng($source_path); break;
            default: return false; break;
        }

        $img_width = $img_attr[0];
        $img_height = $img_attr[1];
   
       if (((double)$img_width / $img_height) > ((double)$sample_x / $sample_y))
       {
            //обрезаем по x
            $new_width = ((double)$sample_x * $img_height) / $sample_y;
            $width_diff = $img_width - $new_width;
            
            $resource_width = floor($new_width);
            $resource_height = $img_height;
            
            $resource = imagecreatetruecolor($resource_width, $resource_height);
            imagecopy($resource, $source, 0, 0, floor($width_diff / 2), 0, floor($new_width), $img_height);
       }
       else
       {
            //обрезаем по y
            $new_height = ((double)$sample_y * $img_width ) / $sample_x;
            $height_diff = $img_height - $new_height;
            
            $resource_width = $img_width;
            $resource_height = floor($new_height);
            $resource = imagecreatetruecolor($resource_width, $resource_height);
            
            imagecopy($resource, $source, 0, 0, 0, floor($height_diff / 2), $img_width, floor($new_height));

       }
       
       imagejpeg($resource,  $result_path, self::JPG_QUALITY);
       
       return true;
    }

    //уменьшает изображение с сохранением пропорций по заданной рамке, сохраняет в jpg
    public static function reduceToFrameJpg($source_path, $result_path, $max_width, $max_height)
    {
        $img_attr = getimagesize($source_path);

        switch ( $img_attr[2] ) {
            case 1: $source = imagecreatefromgif($source_path); break;
            case 2: $source = imagecreatefromjpeg($source_path); break;
            case 3: $source = imagecreatefrompng($source_path); break;
            default: return false; break;
        }

        if ( $img_attr[0]>$max_width || $img_attr[1]>$max_height ) {
            if ( ((double)$img_attr[0]/$max_width) >= ((double)$img_attr[1]/$max_height) ){
                $resource_width = $max_width;
                $resource_height = floor((double)$max_width * $img_attr[1] / $img_attr[0]);
            }
            else {
                $resource_height = $max_height;
                $resource_width = floor( (double)$max_height * $img_attr[0] / $img_attr[1]);
            }
            $resource = imagecreatetruecolor($resource_width, $resource_height);
            imagecopyresampled($resource, $source, 0, 0, 0, 0, $resource_width, $resource_height, $img_attr[0], $img_attr[1]);
        }
            else $resource = $source;
            
        imagejpeg($resource,  $result_path, self::JPG_QUALITY);    
        
        return true;
    }
    
    public static function reduceToFrame($source, $max_width, $max_height)
    {
        $width = imagesx($source);
        $height = imagesy($source);

        if ($width > $max_width || $height > $max_height) {
            if ( ((double)$width/$max_width) >= ((double)$height/$max_height) ){
                $resource_width = $max_width;
                $resource_height = floor((double)$max_width * $height / $width);
            }
            else {
                $resource_height = $max_height;
                $resource_width = floor( (double)$max_height * $width / $height);
            }
            $result = imagecreatetruecolor($resource_width, $resource_height);
            imagecopyresampled($result, $source, 0, 0, 0, 0, $resource_width, $resource_height, $width, $height);
        }
            else $result = $source;
        
        return $result;
    }
    
    public static function elipseFrame($source, $r, $g, $b)
    {
        $result = $source;
        
        $width = imagesx($result);
        $height = imagesy($result);    
    
        $mask = imagecreatetruecolor($width, $height);  
        imagealphablending($mask, true);  

        $mask_black = imagecolorallocate($mask, 0, 0, 0);  
        $mask_background = imagecolorallocate($mask, $r, $g, $b);  
        imagecolortransparent($mask, $mask_black);  
        imagefill($mask, 0, 0, $mask_background);  

        $circle_x = $width / 2;  
        $circle_y = $height / 2;  
  
        imagefilledellipse($mask, $circle_x, $circle_y, $width, $height, $mask_black);  
 
        imagecopymerge($result, $mask, 0, 0, 0, 0, $width, $height, 100);  
        
        return $result;
    }
    
    public static function expandToFrame($source, $frame_width, $frame_height, $r, $g, $b)
    {
        $width = imagesx($source);
        $height = imagesy($source); 
        
        if($width >= $frame_width and $height >= $frame_height)
            return $source;
        
        if ($width > $frame_width)
            $frame_width = $width;
        elseif ($height > $frame_height)
            $frame_height = $height;
        
        $result = imagecreatetruecolor($frame_width, $frame_height);
        $back_color = imagecolorallocate($result, $r, $g, $b);
        imagefilledrectangle($result, 0, 0, $frame_width, $frame_height, $back_color);

        $x = ($frame_width - $width) / 2;
        $y = ($frame_height - $height) / 2;
        
        imagecopy ($result, $source, $x, $y, 0, 0, $width, $height);
    
        return $result;
    }
    
    public static function center_text($string, $font, $font_size, $image_width)
    {
        $dimensions = imagettfbbox($font_size, 0, $font, $string);
        return ceil(($image_width - $dimensions[4]) / 2);               
    }
    
    public static function text_wrap($text, $wrap_border)
    {
        if (mb_strlen($text) <= $wrap_border)
            return array($text, '');

        $pos = mb_strrpos($text, ' ', $wrap_border - mb_strlen($text) + 1);
        if ($pos > 0) {
            return array(mb_substr($text, 0, $pos), mb_substr($text, $pos + 1));
        }
            
        return array(mb_substr($text, 0, $wrap_border), mb_substr($text, $wrap_border));
    }
    
    public static function makeTransportCard($discodes_id, $photo_src, $logo_src, $name, $position)
    {
        $spot = Spot::getSpot(array('discodes_id' => $discodes_id));
        
        if (!$spot)
            return false;
        $i = 1;
        
        while (file_exists(Yii::getPathOfAlias('webroot.uploads.spot.') . '/' 
            . $spot->discodes_id . '_'. md5($spot->code) 
            . '_transport_card_' . $i . '.jpg'))
            $i++;
        
        $card_path = 
            Yii::getPathOfAlias('webroot.uploads.spot.') . '/' 
            . $spot->discodes_id . '_'. md5($spot->code) 
            . '_transport_card_' . $i . '.jpg';
            
        $frame = imagecreatefromjpeg(Yii::getPathOfAlias('webroot') . '/' . self::T_CARD_FRAME);
        
        $card = imagecreatetruecolor(imagesx($frame), imagesy($frame));
        
        imagecopy ($card, $frame, 0, 0, 0, 0, imagesx($frame), imagesy($frame));
        
        if (!empty($photo_src) and file_exists($photo_src)) {
            //фото
            $photo = self::reduceToFrame(imagecreatefromjpeg($photo_src), self::PHOTO_WIDTH, self::PHOTO_HEIGHT); 
            $photo = self::expandToFrame($photo, self::PHOTO_WIDTH, self::PHOTO_HEIGHT, 255, 255, 255);
            $photo = self::elipseFrame($photo, 255, 255, 255);
            
            imagecopy ($card, $photo, (imagesx($frame) - imagesx($photo)) / 2, self::CARD_HAT, 0, 0, imagesx($photo), imagesy($photo));
        }
        
        $cursor_y = self::CARD_HAT + self::PHOTO_HEIGHT + 59;
        $font = Yii::getPathOfAlias('webroot') . '/' . self::CARD_FONT;
        
        if (!empty($name))
        {
            //имя
            $name_color = imagecolorallocate($card, 63, 63, 63);
            
            if (mb_strlen($name) > self::NAME_STRLEN)
                $name_text = self::text_wrap($name, self::NAME_STRLEN)[0];
            else 
                $name_text = $name;
            
            imagettftext($card, self::NAME_SIZE, 0, 
                self::center_text($name_text, $font, self::NAME_SIZE, imagesx($frame)), 
                $cursor_y, 
                $name_color, 
                $font, 
                $name_text);
                
            if (mb_strlen($name) > self::NAME_STRLEN) {
                $cursor_y += 40;
                $name_text = self::text_wrap($name, self::NAME_STRLEN)[1];
                imagettftext($card, self::NAME_SIZE, 0, 
                    self::center_text($name_text, $font, self::NAME_SIZE, imagesx($frame)), 
                    $cursor_y, 
                    $name_color, 
                    $font, 
                    $name_text);
                    
                    $cursor_y += 48;
            }
            else
                $cursor_y += 50;
        }
        else
            $cursor_y += 50;
        
        if (!empty($position))
        {
            //должность
            $position_color = imagecolorallocate($card, 141, 144, 149);
            
            if (mb_strlen($position) > self::POSITION_STRLEN)
                $position_text = self::text_wrap($position, self::POSITION_STRLEN)[0];
            else 
                $position_text = $position;
            
            imagettftext($card, self::POSITION_SIZE, 0, 
                self::center_text($position_text, $font, self::POSITION_SIZE, imagesx($frame)), 
                $cursor_y, 
                $position_color, 
                $font, 
                $position_text);
                
            if (mb_strlen($position) > self::POSITION_STRLEN)
            {
                $cursor_y += 21;
                $position_text = self::text_wrap($position, self::POSITION_STRLEN)[1];
            
                imagettftext($card, self::POSITION_SIZE, 0, 
                self::center_text($position_text, $font, self::POSITION_SIZE, imagesx($frame)), 
                $cursor_y, 
                $position_color, 
                $font, 
                $position_text);
            }
        }
  
        //логотип
        if (!empty($logo_src) and file_exists($logo_src))
        {
            $logo = self::reduceToFrame(imagecreatefromjpeg($logo_src), self::LOGO_WIDTH, self::LOGO_HEIGHT); 
            $logo = self::expandToFrame($logo, self::LOGO_WIDTH, self::LOGO_HEIGHT, 255, 255, 255);
            imagecopy ($card, $logo, (imagesx($frame) - imagesx($logo)) / 2, imagesy($frame) - 66, 0, 0, imagesx($logo), imagesy($logo));
        }
        
        imagejpeg(
            $card,  
            $card_path, 
            self::JPG_QUALITY
        ); 
    
        return $spot->discodes_id . '_'. md5($spot->code) . '_transport_card_' . $i . '.jpg';
    }
}
