<?php

namespace App;
use Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debate extends Model
{

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
        'category_id',
        'question_id',
        'status',
        'starts_at',
        'ends_at'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['question_text',
        'question_category',
        'question_source',
        'question_medium'
    ];


    /**
     * Makes event date Carbon instance
     *
     * @var array
     */
    protected $dates = ['starts_at', 'ends_at', 'created_at', 'deleted_at'];

    /**
     * A debate has many users
     * @return \Illuminiate\Database\Eloquent\Relations\belongsToMany
     */
    public function users()
    {
        // return $this->belongsToMany(\App\User::class, 'debate_user', 'debate_id', 'user_id');

        //return $this->belongsToMany(\App\User::class, 'debate_user', 'debate_id', 'user_id');

        return $this->belongsToMany(\App\User::class, 'debate_user', 'debate_id', 'user_id')
        ->withPivot(['side','votes']);


    }

    /**
     * A debate has many users
     * @return \Illuminiate\Database\Eloquent\Relations\belongsToMany
     */
    public function question()
    {
        //return $this->belongsTo(\App\Question::class)->with('ads');
        return $this->belongsTo(\App\Question::class);
        
    }

  public function getDebatequestion()
    {

        return $this->belongsTo(\App\Question::class, 'question_id');
    }
    public function debate_user()
    {
        return $this->hasMany(\App\DebateUser::class, 'debate_id');
    }
    

    /**
     * A debate has many users
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function arguments()
    {
        return $this->hasMany(\App\DebateArgument::class)->with('user')->where('status','active');
    }

    /**
     * A debate has many users
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function argumentPro()
    {
        return $this->hasMany(\App\DebateArgument::class)->with('user');
    }

    /**
     * A debate has many comments
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function commentPro()
    {
        //return $this->hasMany(\App\DebateComment::class)->with('user')->orderBy('created_at', 'desc');
        return $this->hasMany(\App\DebateComment::class)->with('user')->orderBy('created_at', 'asc');
    }

    /**
     * A debate has many comments
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function comments()
    {
        //return $this->hasMany(\App\DebateComment::class)->with('user')->orderBy('created_at', 'desc');
        return $this->hasMany(\App\DebateComment::class)->with('user')->where('status','active')->orderBy('created_at', 'asc');
    }



    /**
     * A debate has many votes
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function votes()
    {
        return $this->hasMany(\App\Vote::class)->with('voter')->orderBy('created_at', 'desc');
    }




    /**
     * Return question text to append to JSON array
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function getQuestionTextAttribute()
    {
        return $this->question->text;
    }

    /**
     * Return question text to append to JSON array
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function getQuestionCategoryAttribute()
    {
        return $this->question->category->name;
    }

    /**
     * Return question text to append to JSON array
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function getQuestionSourceAttribute()
    {
        return $this->question->source;
    }

    /**
     * Return question text to append to JSON array
     * @return \Illuminiate\Database\Eloquent\Relations\hasMany
     */
    public function getQuestionMediumAttribute()
    {
        return $this->question->medium;
    }

}
