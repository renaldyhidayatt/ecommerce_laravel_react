<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;


    protected $primaryKey = 'order_id';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function findByUserId($userId)
    {
        return DB::table('orders')
            ->where('user_id', $userId)
            ->get();
    }
}
