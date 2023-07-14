<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\ProductUpdateRequest;
use App\Http\Requests\v1\ProductStoreRequest;
use App\Models\ProductImages;
use App\Models\Stores;
use App\Http\Helper\Helper;
use App\Models\Bids;
use Exception;
use Illuminate\Support\Arr;
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
                $product = Products::with('thumbnail','brand','condition','category','currency','bid','store')->where('store_id', $store->id)->paginate(10);
            } catch(Throwable $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 401);
            }
        }

        return $product;
    }

    public function indexAuction()
    {
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->first();
        $product = [];
        
        if($store) {
            try {
                $product = Bids::with('product','product.thumbnail','product.brand','product.condition','product.category','product.currency','highest','product.store')->whereRelation('product','store_id', $store->id)->orderByDesc('id')->paginate(10);
            } catch(Throwable $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 401);
            }
        }

        return $product;
    }

    public function all(Request $request)
    {
        
        $brands = [];
        if($request->brand) {
            foreach($request->brand as $brand) {
                array_push($brands, $brand);
            }
        }

        if(!empty($request->category)) {
            if(!empty($brands)) {
                return Products::with('thumbnail','brand','condition','category','currency','store')
                    ->whereRelation('category', 'id', $request->category)
                    ->whereIn('brand', $brands)
                    ->limit(20)->get(); 
            } else {
                return Products::with('thumbnail','brand','condition','category','currency','store')
                    ->whereRelation('category', 'id', $request->category)
                    ->limit(20)->get(); 
            }
        } else {
            if(!empty($brands)) {
                return Products::with('thumbnail','brand','condition','category','currency','store')
                ->whereIn('brand', $brands)
                ->limit(20)->get(); 
            } else {
                return Products::with('thumbnail','brand','condition','category','currency','store')->limit(20)->get(); 
            }
        }
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
                    'slug' => Helper::createSlug('products', $request->name),
                    'details' => $request->details,
                    'condition' => $request->condition,
                    'brand' => $request->brand,
                    'category' => $request->category,
                    'currency' => 1,
                    'price' => $request->price,
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $append_product = [];
        try {
            $product = Products::with('images:product_id,filename,url,mime_type,size','store','brand','condition','category','currency')
            ->where('slug', $slug)
            ->first(['id','name','slug','details','quantity','brand','condition','category','currency','created_at','store_id']);

            if(!$product) {
                return response()->json(['message'=> 'Item not found.'], 201);
            }

            $aprod = collect($product);
            $aprod->put('store_slug', Str::slug($aprod['store']['name']));
            $customer_id = auth()->user()->id;
            $mystore = Stores::where('customer_id', $customer_id)->first(['slug']);

            if($aprod['store']['slug'] === $mystore->slug) {
                $aprod->put('owner', true);
            }
            $append_product = $aprod;


            return $append_product;
        } catch(Throwable $e) {
            return response()->json(['message'=> $e->getMessage()], 404);
        }

        return $append_product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function productDetails($store, $product)
    {
        $append_product = [];
        try {
            $product = Products::with('images:id,product_id,filename,url,mime_type,size','store','brand','condition','category','currency')
            ->where('slug', $product)
            ->first(['id','name','slug','details','quantity','brand','condition','category','price','currency','created_at','store_id']);
            
            if(!$product) {
                return response()->json(['message'=> 'Item not found.'], 401);
            }

            $aprod = collect($product);
            
            try {
                $customer_id = auth()->user()->id;
                $mystore = Stores::where('customer_id', $customer_id)->first(['slug']);

                if($aprod['store']['slug'] === $mystore->slug) {
                    $aprod->put('owner', true);
                }

                if($aprod['store']['slug'] !== $store) {
                    return response()->json(['message'=> 'Item not found.'], 401);
                }
            } catch(Throwable $e) {
                $aprod->put('owner', false);
            }

            $append_product = $aprod;


            return $append_product;
        } catch(Throwable $e) {
            return response()->json(['message'=> $e->getMessage()], 401);
        }

        return $append_product;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function product($slug)
    {
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->first();
        //dd($store);
        try {
            $product = Products::with('images:product_id,filename,url,mime_type,size','bid')
            ->where('slug', $slug)
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

    public function search($key)
    {
        return Products::with('store','category','brand')->where('name','LIKE','%'.$key.'%')->get();
    }

    public function storeSearch($key)
    {
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->first();

        return Products::with('thumbnail','brand','condition','category','currency','bid','store')->where('name','LIKE','%'.$key.'%')->where('store_id', $store->id)->paginate(10);
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
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->first();
        $files = [];

        if($store) {
            if($request->hasFile('images')) {
                $images = $request->file('images');
                
                foreach ($images as $image) {
                    $storage_path = Storage::putFile('public/product_images', $image);
                    $filename = Str::of($storage_path)->explode('/');
                    $data['name'] = $filename[2];
                    $data['url'] = Storage::url($filename[2]);
                    $data['mime_type'] = $image->getMimeType();
                    $data['size'] = $image->getSize();

                    $files[] = $data;
                }
            }

            try {
                $new_slug = Helper::createSlug('products', $request->name);
                $product = Products::where('slug', $id)->update([    
                    'store_id' => $store->id,
                    'name' => $request->name,
                    'slug' => $new_slug,
                    'details' => $request->details,
                    'condition' => $request->condition,
                    'brand' => $request->brand,
                    'category' => $request->category,
                    'price' => $request->price,
                    'quantity' => $request->quantity,
                    'updated_at' => Carbon::now()->toDateTime()
                ]);
            } catch (Throwable $e) {
                return response()->json([
                    'message' => 'Saving product failed.',
                    'code' => $e->getCode()
                ], 500);
            }   

            if($product) {
                if(count($files) > 0) {
                    $prod = Products::where('slug', $new_slug)->firstOrFail();
                    $insert_images = [];
                    foreach($files as $file) {
                        $insert_images[] = [
                            'product_id' => $prod->id,
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyImage($id)
    {
        //
        return ProductImages::destroy($id);
    }
}