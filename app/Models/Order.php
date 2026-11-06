<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'status',
        'name',
        'phone',
        'whatsapp',
        'first_name',
        'last_name',
        'address',
        'address_line_2',
        'city',
        'state',
        'zip',
        'email',
        'property_type',
    ];

    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
