<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Statement extends Model
{
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 'account_id', 'amount', 'notes', 'category_id', 'isLoan',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
