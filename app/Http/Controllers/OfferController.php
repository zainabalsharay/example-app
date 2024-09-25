<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
                'msg' => __('messages.Offer saved successfully!'),
            ]);
        } else {
            return response()->json([
                'status' => false,
                'msg' => __('messages.Fails Save Please Again!!!'),
            ]);
        }
    }
    public function getAllOffers()
    {
        $offers = Offer::select(
            'id',
            'photo',
            'price',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'detalis_' . LaravelLocalization::getCurrentLocale() . ' as detalis')->limit(10)->get(); //return collection
        return view('Ajaxoffers.all', compact('offers'));
    }

    public function deleteOffer(Request $request)
    {
        $offer = Offer::find($request->id);
        if (!$offer) {
            return response()->json([
                'status' => false,
                'message' => 'Offer not found',
            ]);
        }

        $offer->delete();

        return response()->json([
            'status' => true,
            'message' => __('messages.offer deleted successfully'),
            'id' => $request->id,
        ]);
    }

    public function editOffer($offer_id)
    {
        // Offer::findOrFail($offer_id);
        $offer = Offer::find($offer_id); //search in given table of model offer id only
        if (!$offer) {
            return response()->json([
                'status' => false,
                'message' => 'Offer not found',
            ]);
        }
        $offer = Offer::select('photo', 'id', 'name_ar', 'name_en', 'price', 'detalis_ar', 'detalis_en')->find($offer_id);

        return view('Ajaxoffers.edit', compact('offer'));
    }
    public function updateOffer(OfferRequest $request)
    {
        //validatio to another file OfferRequest

        //check if offer exists
        $offer = Offer::find($request->offer_id);
        if (!$offer) {
            return response()->json([
                'status' => false,
                'message' => 'Offer not found',
            ]);
        }

        // تخزين الصورة إذا كانت موجودة
        if ($request->hasFile('photo')) {
            // حذف الصورة القديمة (إذا لزم الأمر)
            if ($offer->photo && File::exists(public_path($offer->photo))) {
                File::delete(public_path($offer->photo));
            }

            // تخزين الصورة الجديدة
            $imagePath = $request->file('photo')->store('images/offers', 'public');
            $offer->photo = $imagePath; // تحديث مسار الصورة في العرض
        }

        //update data
        $offer->update($request->except('photo'));

        return response()->json([
            'status' => true,
            'message' => __('messages.To update successfully!'),
            'image_path' => asset('storage/' . $offer->photo),
        ]);
        //another way to update
        // $offer->update([
        //     'name_ar' => $request->name_ar,
        //     'name_en' => $request->name_en,
        //     'price' => $request->price,
        // ]);
    }

}
