<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Company; //追記
use Illuminate\Support\Facades\DB; //追記
use App\Http\Requests\ProductRequest; //追記(バリデーション)
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = (new Product())->getProductsQuery()->paginate(5);
        $companies = Company::getCompaniesQuery();
    
        return view('index', compact('products', 'companies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('create')
        ->with('companies',$companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request) //store(Request $request)→ProductRequestに変える
    {
        DB::beginTransaction();

        try{
            $imagePath = null;
            if ($request->hasFile('img_path')) {
                $imagePath = $request->file('img_path')->store('images/products', 'public');
            }
            
            $product = new Product();
            $product->registProduct($request,$imagePath);
            DB::commit();
        } catch (\Exception $e){
            DB::rollback();
            return back();
        }

        return redirect(route('index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('show', ['product' => $product]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {        
        $companies = Company::all();
        return view('edit', compact('product', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();
    
        try {
            $imagePath = null;
            if ($request->hasFile('img_path')) {
                $imagePath = $request->file('img_path')->store('images/products', 'public');
            }
    
            $product->update([
                'product_name' => $request->input('product_name'),
                'price' => $request->input('price'),
                'stock' => $request->input('stock'),
                'company_id' => $request->input('company_id'),
                'comment' => $request->input('comment'),
                'img_path' => $imagePath,
            ]);
    
            DB::commit();
    
            return redirect()->route('index')
                ->with('success', $product->product_name . 'を変更しました');
        } catch (\Exception $e) {
            DB::rollback();
            return back();
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->deleteProduct();
        return redirect()->route('index')
        ->with('success',$product->name . 'を削除しました');
    }

    public function search(Request $request){
        $query = (new Product())->getProductsQuery();
        $companies = Company::all();

        if ($request->filled('keyword')){
            $query->where('product_name', 'like', '%' . $request->input('keyword') . '%');
        }

        if ($request->filled('company_id')){
            $query->where('company_id', $request->input('company_id'));
        }

        if ($request->filled('price_min')){
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        if ($request->filled('stock_min')){
            $query->where('stock', '>=', $request->input('stock_min'));
        }

        if ($request->filled('stock_max')){
            $query->where('stock', '<=', $request->input('stock_max'));
        }

        $products = $query->paginate(5)->appends($request->all()); //appendメソッドを追加するとページネーションを残したまま検索結果を表示することができる
        return view('index', compact('products', 'companies'));
    }

}
