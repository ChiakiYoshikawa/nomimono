@extends('app')

@section('content')
<div class="row">
  <div class="col-lg-12">
   <div class="text-left">
    <h2 style="font-size:1rem;">商品一覧画面</h2>
   </div>
   <div class="text-right">
  <a class="btn btn-success" href="{{ route('product.create') }}">新規登録</a>
  </div>
 </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<table class="table table-bordered">
         <tr>
               <th>No</th>
               <th>商品画像</th>
               <th>商品名</th>
               <th>価格</th>
               <th>在庫数</th>
               <th>メーカー名</th>
               <th></th>
               <th></th>
          </tr>
        @foreach($products as $product)
          <tr>
                <td style="text-align:right">{{ $product->id }}</td>
                <td>
                <img src="{{ asset('storage/' . $product->image_path) }}" alt="商品画像">
                </td>
                <td><a href="{{ route('product.show' ,$product->id) }}">{{ $product->product_name }}</a></td>
                <td style="text-align:right">{{ $product->price }}円</td>
                <td style="text-align:right">{{ $product->stock }}</td>
                <td>{{ $product->company->company_name }}</td>
                <td style="text-align:center">
                      <a class="btn btn-primary" href="{{ route('product.edit',$product->id) }}">変更</a>
                <td style="text-align:center">
                <form action="{{ route('product.destroy',$product->id) }}" method="POST">
               @csrf
               @method('DELETE')
               <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm(“削除しますか？”);'>削除</button>
               </form>
               </td>
          </tr>
          @endforeach
</table>

{!! $products->links('pagination::bootstrap-5') !!}

@endsection

