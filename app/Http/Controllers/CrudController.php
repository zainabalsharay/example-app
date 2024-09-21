<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        //validate data before insert to database
        $rules = $this->getRules();
        $messages = $this->getMessags();
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // return $validator->errors();
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        try {
            //insert
            Offer::create([
                'name' => $request->name,
                'price' => $request->price,
                'detalis' => $request->detalis,
            ]);

            return redirect()->back()->with(['success' => 'Offer saved successfully!']);
        } catch (Exception $e) {
            Log::error($e->getMessage()); // تسجيل الخطأ
            return redirect()->back()->with(['error' => 'Failed to save offer.']);

        }

    }
    protected function getRules()
    {
        return $rules = [
            'name' => 'required|max:100|unique:offers,name',
            'price' => 'required|numeric',
            'detalis' => 'required',
        ];
    }
    protected function getMessags()
    {
        return $messages = [
            'name.required' => __('messages.offer name required'),
            'name.unique' => 'found the name',
            'price.numeric' => 'price of view is been the number',
            'price.required' => 'price is required',
            'detalis.required' => 'details is required',
        ];
    }
}
