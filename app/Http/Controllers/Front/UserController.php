<?php
namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;

class UserController extends Controller{
    public function showUserName(){
        return "hello zainab!!!!!!!!";
    }
    public function deleteUserName(){
        return "delete";
    }

    public function getIndex(){
        //array
        $data = [
            'name' => 'reem',
            'age' => 25,
            'city' => 'taiz'
        ];

        //object

        $obj=new \stdClass();
        $obj->name='reem';
        $obj->id=339488;
        $obj->age=26;

        //arrray assosative
        $data1 = ['a' => 'ahmed','b' => 'basmah'];
        $data2=[];
        return view('welcome',$data,compact('obj','data1','data2'));
    }


}