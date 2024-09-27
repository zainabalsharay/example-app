<?php

namespace App\Http\Controllers\Relation;

use App\Http\Controllers\Controller;
use App\Models\Phone;
use App\Models\User;

class RelationController extends Controller
{
    //
    public function hasOneRelation()
    {
        $user = User::with(['phone' => function ($q) {
            $q->select('code', 'phon', 'user_id');
        }])->find(2);

        //return $user->phone->code;//967
        //return $user->name;//zainab
        //$phone = $user->phone;//print of table phone
        return response()->json($user);
    }

    public function hasOneRelationReverse()
    {
        //get all data of phone and id,name of model User
        $phone = Phone::with(['user' => function ($q) {
            $q->select('name', 'id');
        }])->find(1);

        $phone->user->makeHidden(['id']);

        //get all data phone and user
        // $phone = Phone::with('user')->find(1);

        //make some attributes visible
        $phone->makeVisible(['user_id']);
        //make some attributes hidden
        //$phone->makeHidden(['code']);
        // return $phone->user; //return user of this phone number

        return $phone;
    }
    public function getUserHasPhones()
    {
        //get-user-has-phones
        //return User::whereHas('phone')->get();

        //get-user-has-phones where condition code=967
        return User::whereHas('phone', function ($q) {
            $q->where('code', 967);
        })->get();

    }
    public function getUserNotHasPhones()
    {
        return User::whereDoesntHave('phone')->get();
    }
}