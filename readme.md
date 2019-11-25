# Adicionando Capa
```bash
php artisan make:migration adiciona_campo_capa_na_tabela_series --table=series
```
```php
<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdicionaCampoCapaNaTabelaSeries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->string('capa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn('capa');
        });
    }
}
```
```bash
php artisan migrate
```
Alterar o arquivo (app/Serie.php) adicionando o campo "capa" no array de $fillable
```php
<?php
...
protected $fillable = ['nome','capa'];
```
Alterar (app\Services\CriadorDeSerie.php) adicionando o campo "capa"
```php
<?php
...
public function criarSerie(
        string $nomeSerie,
        string $capa,
        int $qtdTemporadas,
        int $epPorTemporada
    ): Serie {
        DB::beginTransaction();
        $serie = Serie::create([
            'nome' => $nomeSerie,
            'capa' => $capa
        ]);
        $this->criaTemporadas($qtdTemporadas, $epPorTemporada, $serie);
        DB::commit();

        return $serie;
    }
```

Alterar o arquivo (app\Http\Requests\SeriesFormRequest.php) para adicionar a "capa"
```php
...
    public function rules()
    {
        return [
            'nome' => 'required|min:2',
            'capa' => 'sometimes|nullable|image'
        ];
    }

    public function messages()
    {
        return [
            'required'   => 'O campo :attribute é obrigatório',
            'nome.min'   => 'O campo nome precisa ter pelo menos 2 caracteres',
            'capa.image' => 'O campo :attribute precisa ser uma imagem'
        ];
    }
```
