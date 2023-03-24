<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable =[
        'id',
        'tipo_marca_id',
        'descricao',
        'nome',
        'tensao',
        'imagem',
        'created_at',
        'updated_at'
    ];

    public function regras()
    {
         $regras =[
            'nome'=>'required|min:3',
            'descricao'=>'required|min:3',
            //'imagem'=>'file|mimes:doc,pdf,jpe,jpg,jpeg,png',
         ];
         return $regras;
    }

    public function feedbacks(){

         $feedbacks = [
            'nome.unique'=>'Esse campo nome ja existe!',
            'nome.min'=>'Esse campo exige minimo de 3 caracteres!',
            'descricao.min'=>'Esse campo exige minimo de 3 caracteres!',
            'required'=>'O campo :attribute é obrigartério',
         ];

         return $feedbacks;
    }


   
 
}
