<?php

namespace App\Actions\Objects;

use Lorisleiva\Actions\Concerns\AsAction;
use Lorisleiva\Actions\Concerns\AsObject;

class SyncResponse
{
    use AsObject;

    public $fullSync = false;
    public $moved =[];
    public $categories = [];
    public $boards = [];
    public $columns = [];
    public $cards = [];
    public $tasks = [];
    public $temp_id_mapping = "";
    public $user_plan_limits ="";
    public $user_settings = "";
    
}
