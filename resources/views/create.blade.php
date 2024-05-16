@extends('app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">

        <div class="pull-left">
            <h2 style="font-size:1.5rem;">商品新規登録画面</h2>
        </div>

        <div class="pull-right">
            <a class="btn btn-success" href="{{ url('/nomimono') }}">戻る</a>
        </div>

    </div>
</div>


<div style="text-align:right;">
<form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
@csrf

<div class="row">

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <input type="text" name="product_name" class="form-control" placeholder="商品名" value="{{ old('product_name') }}">
            @if($errors->has('product_name'))
                <p>{{ $errors->first('product_name') }}</p>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class=“form-group”>
            <input type="text" name="price" class="form-control" placeholder="価格" value="{{ old('price') }}">
            @if($errors->has('price'))
                <p>{{ $errors->first('price') }}</p>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <input type="text" name="stock" class="form-control" placeholder="在庫数" value="{{ old('stock') }}">
            @if($errors->has('stock'))
                <p>{{ $errors->first('stock') }}</p>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class=“form-group”>
            <input type="text" name="comment" class="form-control" placeholder="コメント" value="{{ old('comment') }}">
            @if($errors->has('comment'))
                <p>{{ $errors->first('comment') }}</p>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <select name="company_id" class="form-select">
                <option value="">分類を選択してください</option>
                @foreach($companies as $company)
                <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                @endforeach
            </select>
            @if($errors->has('company_id'))
                <p>{{ $errors->first('company_id') }}</p>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
            <input type="file" name="img_path" class="form-control-file">
            @if($errors->has('img_path'))
                <p>{{ $errors->first('img_path') }}</p>
            @endif
        </div>
    </div>

    <div class="col-12 mb-2 mt-2">
        <button type="submit" class="btn btn-primary w-100">登録</button>
    </div>
    
</div>

</form>
</div>
@endsection