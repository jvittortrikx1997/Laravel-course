<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    public function produtos(){
        //return $this->belongsToMany('App\Produto', 'pedidos_produtos');

        return $this->belongsToMany('App\Item', 'pedidos_produtos', 'pedido_id', 'produto_id')->withPivot('updated_at');
        /*
            1 - Modelo do relacionamento NxN em relação ao modelo que estamos implementando
            2 - Tabela auxiliar que armazena os registros do relacionamento
            3 - Nome da FK da tabela mapeada pelo modelo na tabela de relacionamento 
            4 - Nome da FK da tabela mapeada pelo modelo na tabela de relacionamento que estamos implementando
        */

    }
}
