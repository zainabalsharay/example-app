<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\User;

class RelationController extends Controller
{
    //
    public function hasOneRelation()
    {
        $user = User::with(['phone' => function ($q) {
            $q->select('code', 'phon', 'user_id');
        }])->find(2);
        //$phone = $user->phone;
        return response()->json($user);
    }
}
