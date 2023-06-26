<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Requests\v1\StoreRequest;
use App\Http\Requests\v1\StoreUpdateRequest;
use App\Models\Stores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Http\Helper\Helper;
use Illuminate\Support\Str;
use Throwable;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Stores::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $customer_id = auth()->user()->id;
        
        try {
            Stores::create([
                'customer_id' => $customer_id,
                'name' => $request->name,
                'slug' => Helper::createSlug('stores', $request->name),
                'verified' => 0
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Open store failed.',
                'code' => $e->getCode()
            ], 500);
        }   

        return response()->json([
            'message' => 'Store has been created.'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return Stores::where('slug', $slug)->first();
    }

    public function products($store)
    {
        return Products::with('brand','condition','thumbnail','store','currency')->whereRelation('store', 'slug', $store)->limit(20)->get();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRequest $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}