<?php

namespace App\Actions\Models;

use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class CategoryModel
{
    use AsAction;

    public static function handle($items){
       
       Gate::authorize('create categories', ReorderCommand::class);
        
        return $items;
    }
}
