<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Overwrite authorize() bach t-khdem bla arguments
     */
     public function authorize($ability = null, $arguments = [])
    {
        // Marki l-flag bch middleware y-3refha dazt mn hna
        app()->instance('auth_checked', true);

        if (is_null($ability)) {
            // Check l-user wach logged in
            return auth()->check() ? true : abort(403);
        }

        return $this->baseAuthorize($ability, $arguments);
    }
}