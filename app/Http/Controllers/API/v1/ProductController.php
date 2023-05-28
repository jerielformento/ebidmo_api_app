<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ProductUpdateRequest;
use App\Http\Requests\v1\ProductStoreRequest;
use App\Models\ProductImages;
use App\Models\Stores;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->first();
        $product = [];
        
        if($store) {
            try {
                $product = Products::with('thumbnail','brand','condition','bid', 'store')->where('store_id', $store->id)->get();
            } catch(Throwable $e) {

            }
        }

        return $product;
    }

    public function all()
    {

        $products = Products::with('thumbnail','brand','condition','bid', 'store')->limit(20)->get(); 
        $aproducts = collect($products);
        $append_products = [];
        foreach($aproducts as $product) {
            $aprod = collect($product);
            $aprod->put('store_slug', Str::slug($product['store']['name']));
            $append_products[] = $aprod;
        }

        return $append_products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->first();

        /* $prod_slug = Products::where('slug', Str::slug($request->name))->exists();
        $max = Products::where('name', $request->name)->count();
        dd($max);  */
        if($store) {
            if($request->hasFile('images')) {
                $images = $request->file('images');
                $files = [];
                foreach ($images as $image) {
                    $storage_path = Storage::putFile('public/product_images', $image);
                    $filename = Str::of($storage_path)->explode('/');
                    $data['name'] = $filename[2];
                    $data['url'] = Storage::url($filename[2]);
                    $data['mime_type'] = $image->getMimeType();
                    $data['size'] = $image->getSize();

                    $files[] = $data;
                }
            } else {
                return response()->json([
                    'message' => 'Product image required.'
                ], 401);
            }

            try {
                $product = Products::create([    
                    'store_id' => $store->id,
                    'name' => $request->name,
                    'slug' => $this->createSlug($request->name),
                    'details' => $request->details,
                    'condition' => $request->condition,
                    'brand' => $request->brand,
                    'quantity' => $request->quantity,
                    'created_at' => Carbon::now()->toDateTime()
                ]);
            } catch (Throwable $e) {
                return response()->json([
                    'message' => 'Saving product failed.',
                    'code' => $e->getCode()
                ], 500);
            }   

            if($product) {
                $insert_images = [];
                foreach($files as $file) {
                    $insert_images[] = [
                        'product_id' => $product->id,
                        'filename' => $file['name'],
                        'url' => $file['url'],
                        'mime_type' => $file['mime_type'],
                        'size' => $file['size']
                    ];
                }

                try {
                    ProductImages::insert($insert_images);
                } catch (Throwable $e) {
                    return response()->json([
                        'message' => 'Saving images failed.',
                        'code' => $e->getCode()
                    ], 500);
                }
            }

        } else {
            return response()->json([
                'message' => 'Unauthorized user.'
            ], 401);
        }

        return response()->json([
            'message' => 'Product has been saved.'
        ], 200);
    }

    private function createSlug($title)
    {
        $slug = Str::slug($title);

        if (Products::where('slug', $slug)->exists()) {
            $count = Products::where('name', $title)->count();

            if($count > 0) {
                return "{$slug}-$count";
            }
        }

        return $slug;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($unique_slug)
    {
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->first();
        //dd($store);
        try {
            $product = Products::with('images:product_id,filename,url,mime_type,size','bid')
            ->where('slug', $unique_slug)
            ->where('store_id', $store->id)
            ->first(['id','name','slug','details','quantity','brand','condition','created_at','prefix']);

            if(!$product) {
                return response()->json(['message'=> 'Item not found.'], 201);
            }
        } catch(Throwable $e) {
            return response()->json(['message'=> $e->getMessage()], 404);
        }

        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
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
        return Products::destroy($id);
    }
}