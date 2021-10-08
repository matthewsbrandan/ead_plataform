<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function adminOnly(){
        if(auth()->user()->type !== 'admin') throw new \Exception(
            'Você não tem permissão para acessar está página'
        );
        return true;
    }
    #region LOCAL FUNCTIONS
    protected function generateSlug($str){
        $str = mb_strtolower($str);
        $str = preg_replace('/(â|á|ã)/', 'a', $str);
        $str = preg_replace('/(ê|é)/', 'e', $str);
        $str = preg_replace('/(í|Í)/', 'i', $str);
        $str = preg_replace('/(ú)/', 'u', $str);
        $str = preg_replace('/(ó|ô|õ|Ô)/', 'o',$str);
        $str = preg_replace('/(_|\/|!|\?|#)/', '',$str);
        $str = preg_replace('/( )/', '-',$str);
        $str = preg_replace('/ç/','c',$str);
        $str = preg_replace('/(-[-]{1,})/','-',$str);
        $str = preg_replace('/(,)/','-',$str);
        $str=strtolower($str);
        return $str;
    }
    protected function handlePlural($string, $condition, $singular, $plural){
        if($condition) $string = str_replace($singular,$plural,$string);
        return $string;
    }
    #region IMAGE FUNCTIONS
    protected function uploadImages($files,$path){
        $errors = [];
        $names = [];
        if ($files != null && count($files) > 0) {
            $count = 0;
            foreach ($files as $images) {
                $count++;
                $name_images = Carbon::now()->timestamp . '_' . $count . '.' . $images->getClientOriginalExtension();

                $finalName = asset($path.$name_images);
                try{
                    if(!$images->move(public_path($path), $name_images)){
                        $errors[] = "Houve um erro ao subir a {$count}º imagem";
                        $finalName = null;
                    }
                }catch(Exception $e){
                    $errors[] = "Houve um erro ao subir a {$count}º imagem";
                    $finalName = null;
                }
                $names[] = $finalName;
            }
        }
        else $errors[] = "Nenhuma imagem selecionada";
        return [
            'names' => $names,
            'errors' => $errors
        ];
    }
    protected function deleteImageFromDir($path_name){
        $result = unlink(public_path($path_name));
        if($result === false) return [
            'result'=> $result,
            'response'=> 'Houve um erro inesperado ao tentar excluir imagem da galeria!'
        ];
        return [
            'result'=> $result,
            'response' => 'Imagem excluida com sucesso!'
        ];
    }
    #endregion IMAGE FUNCTIONS
    #endregion LOCAL FUNCTIONS
}