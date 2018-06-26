<?php
namespace App\Traits;

use Auth;

use App\Activity;

use ReflectionClass;

trait RecordsActivity
{
    /**
    * Listen for each model event, and log corresponding activity
    */
    protected static function boot()
    {
        parent::boot();
        foreach (static::getModelEvents() as $event) {
            // Commented out because we're manually calling the activities function throughout
            /*static::$event(function($model) use ($event) {
	            $model->addActivity($event);
	        });*/
        }
    }

    /**
    * Create a new activity record based on the event.
    * @var $event
    */
    public function addActivity($event, $model, $userId)
    {
        Activity::create([
            'subject_id' => $model->id,
            'subject_type' => get_class($model),
            'subject_verb' => $this->getSubjectVerb($this, $event),
            'user_id' => $userId,
        ]);
    }

    /**
    * Get a lowercase version of the model name without the "App\" namespace.
    * @var $model
    */
    protected function getSubjectVerb($model, $event)
    {
        $name = strtolower((new ReflectionClass($model))->getShortName());
        return $name . "_" . $event;
    }

    /**
    * If $recordEvents are specified in a given model, listen for those. Otherwise, listen for all model events.
    */
    protected static function getModelEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        };
        return [
            'created', 'deleted', 'updated'
        ];
    }
}
