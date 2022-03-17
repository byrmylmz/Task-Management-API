<?php

namespace App\Actions\Models;


class CategoryModel 
{
  
    public $resultArray =array();
    
    public $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;

        foreach($this->collection as  $part)
        {
            $model = explode("_",$part['type'])[0];
            $action = explode("_",$part['type'])[1];
            $this->$action($part['items'],$model);
           
        }
    }
 
    public function result()
    {
         $this->collection;
    }

    public function reorder($gets,$model)
    {   
       
        foreach($gets as $get)
        {
            array_push($this->resultArray,[$model=>$get]);

        }       
    }

    public function move()
    {



    }

    public function delete()
    {

    }
}
