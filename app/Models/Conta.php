<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Transacao;
class Conta extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'contas';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'numero',
        'valor',
    ];

    public function transacoes()
    {
        return $this->hasMany(Transacao::class, 'conta_id')->orderBy('created_at', 'desc');
    }

}
