<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CrudController extends Controller
{
    //
    public function getOffers()
    {
        return Offer::select('id', 'name_ar')->get();

    }

    public function createOffer()
    {
        return view('offers.create');
    }

    public function storeOffer(OfferRequest $request)
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
    public function editOffer($offer_id)
    {
        // Offer::findOrFail($offer_id);
        $offer = Offer::find($offer_id); //search in given table of model offer id only
        if (!$offer) {
            return redirect()->back();
        }
        $offer = Offer::select('id', 'name_ar', 'name_en', 'price', 'detalis_ar', 'detalis_en')->find($offer_id);

        return view('offers.edit', compact('offer'));
    }
    public function updateOffer(OfferRequest $request, $offer_id)
    {
        //validatio to another file OfferRequest

        //check if offer exists
        $offer = Offer::find($offer_id);
        if (!$offer) {
            return redirect()->back();
        }
        //update data
        $offer->update($request->all());
        return redirect()->back()->with(['success' => __('messages.To update successfully!')]);

        //another way to update
        // $offer->update([
        //     'name_ar' => $request->name_ar,
        //     'name_en' => $request->name_en,
        //     'price' => $request->price,
        // ]);

    }
    public function getAllOffers()
    {
        $offers = Offer::select(
            'id',
            'price',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'detalis_' . LaravelLocalization::getCurrentLocale() . ' as detalis')->get(); //return collection
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