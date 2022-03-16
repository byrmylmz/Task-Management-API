<?php

namespace App\Actions\Objects;

use Lorisleiva\Actions\Concerns\AsObject;

class SyncResponseObject
{
    use AsObject;

    public $fullSync = false;
    public $moved =[];
    public $category = [];
    public $board = [];
    public $column = [];
    public $card = [];
    public $task = [];
    public $temp_id_mapping = "";
    public $user_plan_limit ="";
    public $user_setting = "";
    
}
