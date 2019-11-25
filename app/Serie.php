<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome','capa'];

    public function temporadas()
    {
        return $this->hasMany(Temporada::class);
    }

    public function getCapaUrlAttribute()
    {
        if(empty($this->capa)){
            return url($this->caminho_arquivo_capa .'sem-imagem.jpg');
        }
        return url($this->caminho_arquivo_capa . $this->capa);
    }

    public function getCaminhoArquivoCapaAttribute()
    {
        return 'imagens/series/';
    }
}
