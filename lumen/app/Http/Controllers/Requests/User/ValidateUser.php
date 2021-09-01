<?php

namespace App\Http\Controllers\Requests\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidateUser extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request, [
                'user' => 'required',
                'password' => 'required',
            ]
        );

        parent::__construct($request);
    }
}

?>
