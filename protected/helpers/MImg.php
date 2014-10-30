<?php
class MImg
{
    //обрезает изображение по заданной пропорции, сохраняет в png
    public static function cutToProportionPng($source_path, $result_path, $sample_x, $sample_y)
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
       
       imagePng($resource,  $result_path);
       
       return true;
    }

    //уменьшает изображение с сохранением пропорций по заданной рамке, сохраняет в png
    public static function reduceToFramePng($source_path, $result_path, $max_width, $max_height)
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
            
        imagePng($resource,  $result_path);    
        
        return true;
    }
}
