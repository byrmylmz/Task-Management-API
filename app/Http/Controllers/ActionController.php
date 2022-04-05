<?php

namespace App\Http\Controllers;

use stdClass;
use Illuminate\Support\Collection;
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
    public $user_plan_limit ="";
    public $user_setting = "";
    public $temp_id_store = [];

    public function result()
    {
        return array(
            'category'=>'App\Models\Category'::findMany(array_unique($this->category)),
            'board'=>'App\Models\Board'::findMany(array_unique($this->board)),
            'column'=>'App\Models\Column'::findMany(array_unique($this->column)),
            'card'=>'App\Models\Card'::findMany(array_unique($this->card)),
            'task'=>'App\Models\Task'::findMany(array_unique($this->task)),
            'user_plan_limit'=>$this->user_plan_limit,
            'user_setting'=>$this->user_setting,
            'temp_id_mapping'=>$this->temp_id_store,
        );
    }
}




class ActionController extends SyncController
{       
    use SyncResponseObject;


    public function __construct($collection)
    {   
       
        foreach($collection as  $part)
        {
            $model = explode("_",$part['type'])[0];
            $action = explode("_",$part['type'])[1];

            // temp id is only with adding actions
            // if(isset($part['temp_id'])){
            //     $temp_id=$part['temp_id'];
            //     $this->$action($part['items'],$model,$temp_id);
            // }else{
            //     $this->$action($part['items'],$model);
            // }
            
            $this->$action($part['items'],$model);
        }
    }
    
    public function add($items,$model)
    {   
       
        $add = AddAction::$model($items);
        array_push($this->$model,$add);

        // temp id storing to the data.
        $this->temp_id_store[$items["temp_id"]]=$add;
            
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

    public function complete($items,$model)
    {
        $class = '\App\Models\\'.ucfirst($model);
        $find = $class::find($items['id']);
        $find->update([
            'checked'=>true,
          
        ]);
        array_push($this->$model,$find->id);
        
    }
    
    public function uncomplete($items,$model)
    {
        $class = '\App\Models\\'.ucfirst($model);
        $find = $class::find($items['id']);
        $find->update([
            'checked'=>false,
          
        ]);
        array_push($this->$model,$find->id);
        
    }





   
 
   
}
