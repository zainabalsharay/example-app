<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTrait;

class OfferController extends Controller
{
    use OfferTrait;
    public function create()
    {
        //view form to add this offer
        return view('Ajaxoffers.create');
    }
    public function store(OfferRequest $request)
    {
        //save offer into DB using AJAX
        $file_name = $this->saveImage($request->photo, 'images/offers');

        //insert table offers in database
        $offer = Offer::create([
            'photo' => $file_name,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'detalis_ar' => $request->detalis_ar,
            'detalis_en' => $request->detalis_en,

        ]);
        //to the same redirect()->back()-with();
        if ($offer) {
            return response()->json([
                'status' => true,
                'msg' => __('messages.saved successfully!'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => __('messages.Fails Save Please Again!!!'),
            ]);
        }
    }

}
