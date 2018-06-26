<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DebateComment extends Model
{

    use Traits\RecordsActivity, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'debate_comment';

    /**
     * Allows soft deletion of events
     * @var string
     */
    protected $softDelete = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'debate_id',
        'user_id',
        'comment',
        'status'
    ];

    /**
     * Makes event date Carbon instance
     *
     * @var array
     */
    protected $dates = ['created_at', 'deleted_at'];

    /**
     * A comment belongs to a debate
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function debate()
    {
        return $this->belongsTo(\App\Debate::class, 'debate_id');
    }

    /**
     * An comment belongs to user
     * @return \Illuminiate\Database\Eloquent\Relations\belongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }

    /**
     * A user can record activity
     *
     * @return \Traits\RecordsActivity
     */
    public function recordActivity($event, $model, $provider)
    {
        return $model->addActivity($event, $model, $provider, $this);
    }
    
}
