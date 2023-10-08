@extends('app')

@section('content')
 <div class="row">
  <div class="col-lg-12 margin-tb">
   <div class="pull-left">
    <h2 style="font-size:1rem;">商品情報詳細画面</h2>
   </div>
   <div class="pull-right">
  <a class="btn btn-success" href="{{ url('/product') }}">戻る</a>
  </div>
 </div>
</div>

<div style="text-align:left;">
<form action="{{ route('product.store') }}" method="POST">
 @csrf

<div class="row">
  <div class="col-12 mb-2 mt-2">
   <div class="form-group">
    商品名 : {{ $product->product_name }}
  </div>
 </div>
  <div class="col-12 mb-2 mt-2">
   <div class=“form-group”>
    価格 : {{ $product->price }}
  </div>
 </div>
  <div class="col-12 mb-2 mt-2">
   <div class="form-group">
    在庫数 : {{ $product->stock }}
  </div>
 </div>
 <div class="col-12 mb-2 mt-2">
    <div class="form-group">
    @foreach($companies as $company)
       @if($company->id == $product->company->id){{ $company->company_id }} @endif
      @endforeach
    </div>
</div>
</div>
</form>
</div>
@endsection
