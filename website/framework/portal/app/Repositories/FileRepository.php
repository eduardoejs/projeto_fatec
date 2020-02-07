<?php

namespace App\Repositories;

use Illuminate\Support\Facades\File;

class FileRepository{

    public function moveFile($document, $model, $type, $name) {
        if(!is_null($document)) {
            $file = $document;               
            $filename = $name;
            $destinationPath = \public_path('storage/arquivos/'.$type.'/'.$model->id.'/');
            $fullPath = $destinationPath.$filename;

            if(!\file_exists($fullPath)) {

                if(!\file_exists($destinationPath)) {
                    mkdir($destinationPath, 0775, true);
                }

                $file->move($destinationPath, $filename);
                return $filename;
            } else {
                return null;
            }
        }
    }

    public function removeFiles($type, $model, $filename = null)
    {
        $destinationPath = \public_path('storage/arquivos/'.$type.'/'.$model->id.'/');        
        
        //se filename for enviado é para exclusão do arquivo passado por parâmetro
        if(!is_null($filename)) {
            if(\file_exists($destinationPath.$filename)) {                
                unlink($destinationPath.$filename);
            }
            
            //se count arquivos = 0 apaga pasta base da notícia (Diretório id)
            if($model->arquivos()->count() == 0) {
                $this->unlinkRecursive(\public_path('storage/arquivos/'.$type.'/'.$model->id.'/'), true);
            }
        } else {
            //se não for enviado filename é porque foi excluído uma notícia e todo seu diretório com os arquivos
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

    public function download($type, $model, $filename)
    {
        $destinationPath = \public_path('storage/arquivos/'.$type.'/'.$model->id.'/'.$filename);
        return response()->download($destinationPath);
    }

}