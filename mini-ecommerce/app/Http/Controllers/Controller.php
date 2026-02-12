<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function authorize($ability = null, $arguments = [])
    {
        app()->instance('auth_checked', true);

        if (is_null($ability)) {
            return auth()->check() ? true : abort(403);
        }

        return $this->baseAuthorize($ability, $arguments);
    }
}