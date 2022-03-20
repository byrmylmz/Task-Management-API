<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Actions\AddAction;
use App\Http\Controllers\Actions\MoveAction;
use App\Http\Controllers\Actions\UpdateAction;


trait SyncResponseObject
{
    public $category = [];
    public $board = [];
    public $column = [];
    public $card = [];
    public $task = [];
    public $temp_id_mapping = "";
    public $user_plan_limit ="";
    public $user_setting = "";

    public function result()
    {
        return array(
            'category'=>'App\Models\Category'::findMany(array_unique($this->category)),
            'board'=>'App\Models\Board'::findMany(array_unique($this->board)),
            'column'=>'App\Models\Column'::findMany(array_unique($this->column)),
            'card'=>'App\Models\Card'::findMany(array_unique($this->card)),
            'task'=>'App\Models\Task'::findMany(array_unique($this->task)),
            'temp_id_mapping'=>$this->temp_id_mapping,
            'user_plan_limit'=>$this->user_plan_limit,
            'user_setting'=>$this->user_setting,
        );
    }
}

class ActionController extends SyncController
{       
    use SyncResponseObject;

    public $boardMap=[];

    public function __construct($collection)
    {   
        
        foreach($collection as  $part)
        {
            $model = explode("_",$part['type'])[0];
            $action = explode("_",$part['type'])[1];
            $this->$action($part['items'],$model);
        }
    }
    
    public function add($items,$model)
    {       
        $add = AddAction::$model($items);
        array_push($this->$model,$add);     
            
    }

    public function update($items,$model)
    {   
       
        $update = UpdateAction::$model($items);
        array_push($this->$model,$update);     

    }

    public function move($items,$model)
    {   
        $move = MoveAction::$model($items);
        array_push($this->$model,$move);  

    }

    public function reorder($items,$model)
    {   
        $class = '\App\Models\\'.ucfirst($model);

        foreach($items as $item)
        {   
            $reorder = $class::find($item['id']);
            
            $reorder->update([
                'order'=>$item['order']
            ]);

            array_push($this->$model,$reorder->id);
            
        }       
    }

    public function delete($items,$model)
    {
        $class = '\App\Models\\'.ucfirst($model);
        $find = $class::find($items['id']);
        try {
            $find->delete();
        } catch (\Throwable $e) {
            throw new \Exception('You can not delete');
        }

    }

    public function complete()
    {
        //
    }

    public function uncomplete()
    {
        //
    }



   
 
   
}
