<?php

namespace App\Http\Controllers;


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
            'card'=>$this->card,
            'task'=>$this->task,
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
    public function add()
    {

    }

    public function update()
    {

    }

    public function moved($items,$model)
    {   
           $class = '\App\Models\\'.ucfirst($model);
       
            $move = $class::find($items['id']);
            $move->update(['category_id'=>$items['category_id']]); 
            array_push($this->$model,$move->id);    
       
    }

    public function reorder($items,$model)
    {   
        $class = '\App\Models\\'.ucfirst($model);

        foreach($items as $items)
        {   
            $reorder = $class::find($items['id']);
            $reorder->update(['order'=>$items['order']]);
           
            array_push($this->$model,$reorder->id);
            
        }       
    }

    public function delete()
    {

    }

    public function complete()
    {

    }

    public function uncomplete()
    {

    }

   
 
   
}
