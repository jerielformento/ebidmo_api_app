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
use App\Models\Auctions;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
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
    public function index(Request $request)
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->first();
        $per_page = $request->per_page ? (int)$request->per_page : 10;

        $product = [];
        if($store) {
            try {
                $product = Products::with('thumbnail','brand','condition','category','currency','auction','store')->where('store_id', $store->id)
                ->orderByDesc('id')->paginate($per_page);
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
        
        $categories = [];
        if($request->category) {
            foreach($request->category as $category) {
                array_push($categories, $category);
            }
        }
        $brands = [];
        if($request->brand) {
            foreach($request->brand as $brand) {
                array_push($brands, $brand);
            }
        }

        return Products::with('thumbnail','brand','condition','category','currency','store')
                    ->when($request->brand, function($query) use($brands) {
                        $query->whereIn('brand', $brands);
                    })
                    ->when($request->category, function($query) use($categories) {
                        $query->whereIn('category', $categories);
                    })
                    ->inRandomOrder()->limit(20)->get(); 
    }

    public function suggestions($store)
    {
        return Products::with('thumbnail','brand','condition','category','currency','store')
                    ->whereRelation('store', 'slug', $store)
                    ->inRandomOrder()->limit(4)->get(); 
    }

    public function similar($store, $category)
    {
        return Products::with('thumbnail','brand','condition','category','currency','store')
                    ->whereRelation('store', 'slug', '<>', $store)
                    ->where('category', $category)
                    ->inRandomOrder()->limit(4)->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $customer_id = Auth::id();
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
                    'item_location' => $request->location,
                    'currency' => 1,
                    //'price' => $request->price,
                    //'quantity' => $request->quantity,
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
            ->first(['id','name','slug','details','brand','condition','category','currency','created_at','store_id']);

            if(!$product) {
                return response()->json(['message'=> 'Item not found.'], 201);
            }

            $aprod = collect($product);
            $aprod->put('store_slug', Str::slug($aprod['store']['name']));
            $customer_id = Auth::id();
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
            $product = Products::with('images:id,product_id,filename,url,mime_type,size','brand','category','condition','item_location','store','currency','thumbnail','auction:product_id,status')
            ->where('slug', $product)
            ->first(['id','name','slug','details','brand','condition','category','item_location','currency','created_at','store_id']);
            
            if(!$product) {
                return response()->json(['message'=> 'Item not found.'], 401);
            }

            $aprod = collect($product);
            
            try {
                $customer_id = Auth::id();
                $mystore = Stores::where('customer_id', $customer_id)->first(['slug']);

                if($aprod['store']['slug'] === $mystore->slug) {
                    $aprod->put('owner', true);
                }

                if($aprod['store']['slug'] !== $store) {
                    return response()->json(['message'=> 'Item not found.'], 201);
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
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->first();
        //dd($store);
        try {
            $product = Products::with('images:product_id,filename,url,mime_type,size','bid')
            ->where('slug', $slug)
            ->where('store_id', $store->id)
            ->first(['id','name','slug','details','brand','condition','created_at','prefix']);

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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, $id)
    {
        $customer_id = Auth::id();
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
                    'item_location' => $request->location,
                    //'price' => $request->price,
                    //'quantity' => $request->quantity,
                    'updated_at' => Carbon::now()->toDateTime()
                ]);
            } catch (Throwable $e) {
                return response()->json([
                    'message' => 'Saving product failed.',
                    'code' => $e->getCode()
                ], $e->getCode());
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
        try {
            ProductImages::destroy($id);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], $e->getCode());
        }

        return response()->json([
            'message' => 'Image removed.'
        ], 200);
    }
}