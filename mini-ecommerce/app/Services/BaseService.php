<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Builder;

class BaseService
{ 
    public function applyPagination($query,$perPage = 10)
    {
        return $query->paginate($perPage);
    }

    
}