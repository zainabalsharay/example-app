<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;

class CrudController extends Controller
{
    //
    public function getoffers()
    {
        return Offer::select('id', 'name')->get();

    }
    // public function store()
    // {
    //     Offer::create([
    //         'name' => 'zainab',
    //         'price' => 66,
    //         'detalis' => 'offer details',
    //     ]);
    // }
    public function create()
    {
        return view('offers.create');
    }

    public function store(OfferRequest $request)
    {
        //validate data before insert to database
        // $rules = $this->getRules();
        // $messages = $this->getMessags();
        // $validator = Validator::make($request->all(), $rules, $messages);

        // if ($validator->fails()) {
        //     // return $validator->errors();
        //     return redirect()->back()->withErrors($validator)->withInput($request->all());
        // }

        //insert
        Offer::create([
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'detalis_ar' => $request->detalis_ar,
            'detalis_en' => $request->detalis_en,

        ]);

        return redirect()->back()->with(['success' => __('messages.Offer saved successfully!')]);

    }
    public function getAllOffers()
    {
        $offers = Offer::select('id', 'name', 'price', 'detalis')->get(); //return collection
        return view('offers.all', compact('offers'));

    }
    // protected function getRules()
    // {
    //     return $rules = [
    //         'name' => 'required|max:100|unique:offers,name',
    //         'price' => 'required|numeric',
    //         'detalis' => 'required',
    //     ];
    // }
    // protected function getMessags()
    // {
    //     return $messages = [
    //         'name.required' => __('messages.offer name required'),
    //         'name.unique' => __('messages.name unique'),
    //         'price.numeric' => __('messages.price numeric'),
    //         'price.required' => __('messages.price required'),
    //         'detalis.required' => __('messages.detalis required'),
    //     ];
    // }
}
