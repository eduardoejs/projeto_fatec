<?php

namespace App\Repositories;


use Image;
use Illuminate\Support\Facades\File;

class ImageRepository{

    public function moveImage($image, $model, $type, $thumbnail = false) 
    {
        if(!is_null($image)) 
        {
            $file = $image;
            $extension = $image->getClientOriginalExtension();

            $filename = time().random_int(100, 999).'.'.$extension;            
            $destinationPath = \public_path('storage/imagens/'.$type.'/'.$model->id.'/');
            $url = url('storage/imagens/'.$type.'/'.$model->id.'/'.$filename);
            $fullPath = $destinationPath.$filename;
            
            if(!\file_exists($fullPath)) {
                
                if(!\file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }

                $image = Image::make($file)->encode('jpg');
                $image->save($fullPath, 100);

                if($thumbnail) {                
                    $this->createThumbnail($destinationPath, 'small/', $filename, 120, 93);
                    $this->createThumbnail($destinationPath, 'medium/', $filename, 550, 340);
                    $this->createThumbnail($destinationPath, 'large/', $filename,  800, 600);
                }            

                return $filename;
            } else {
                return null;
            }
            //return $url;
        } else {
            //return url('storage/imagens/default/no_image.jpeg');
            return null;
        }
    }

    public function createThumbnail($destinationPath, $folderThumb ,$filename, $width, $height)
    {
        try{            
            $file = $destinationPath.$filename;
            $thumbPath = $destinationPath.'thumbnail/'.$folderThumb;
            $fullPathThumb = $thumbPath.$filename;

            $img = Image::make($file)->resize($width, $height, function ($constraint) {
                //$constraint->aspectRatio();
                $constraint->upsize();
            });            
                        
            if(!file_exists($thumbPath)) {
                mkdir($thumbPath, 0775, true);
            }
            $img->save($fullPathThumb);
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function removeImages($type, $model, $filename = null)
    {
        $destinationPath = \public_path('storage/imagens/'.$type.'/'.$model->id.'/');
        $thumbnailsDirs = ['s' => 'thumbnail/small', 'm' => 'thumbnail/medium', 'l' => 'thumbnail/large'];
        
        //se filename for enviado é para exclusão do arquivo de imagem passado por parâmetro
        if(!is_null($filename)) {
            if(\file_exists($destinationPath.$filename)) {                
                unlink($destinationPath.$filename);
            }

            foreach($thumbnailsDirs as $dir){
                if(\file_exists($destinationPath.$dir.'/'.$filename)) {                
                    unlink($destinationPath.$dir.'/'.$filename);
                }
            }
            
            //se count imagens = 0 apaga pasta base da notícia (Diretório id)
            if($model->imagens()->count() == 0) {
                $this->unlinkRecursive(\public_path('storage/imagens/'.$type.'/'.$model->id.'/'), true);
            }
        } else {
            //se não for enviado filename é porque foi excluído uma notícia e todo seu diretório com as imagens
            //devem ser excluídas
            if(\file_exists($destinationPath)) {
                $this->unlinkRecursive($destinationPath, true);
            }
        }
    }

    private function unlinkRecursive($dir, $deleteRootToo) 
    { 
        if(!$dh = @opendir($dir)) { 
            return; 
        } 
        while (false !== ($obj = readdir($dh))) { 
            if($obj == '.' || $obj == '..') { 
                continue; 
            } 
    
            if (!@unlink($dir . '/' . $obj)) { 
                $this->unlinkRecursive($dir.'/'.$obj, true); 
            } 
        } 
        closedir($dh); 
        if ($deleteRootToo) { 
            @rmdir($dir); 
        } 
        return; 
    } 
}