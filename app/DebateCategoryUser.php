<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebateCategoryUser extends Model
{
    protected $table = 'debate_category_user';

    protected $fillable = [
        'category_id',
        'user_id'
    ];

     /**
     * Makes event date Carbon instance
     *
     * @var array
     */
    protected $dates = ['created_at', '	updated_at', 'deleted_at'];

    /**
     * A question belongs to a category
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function category()
    {
        return $this->belongsTo(\App\DebateCategory::class, 'category_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
