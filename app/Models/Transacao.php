<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Conta;

class Transacao extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'transacoes';

    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'conta_id',
        'valor',
        'tipo',
    ];

    public function conta()
    {
        return $this->hasOne(Conta::class, 'id', 'conta_id');
    }
}
