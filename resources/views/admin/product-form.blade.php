@extends('layouts.app')

@section('title', $product ? __('messages.admin_edit') : __('messages.admin_add_product'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal">
        <h1>{{ $product ? __('messages.admin_edit') : __('messages.admin_add_product') }}</h1>
    </div>

    @include('partials.admin-nav')

    <div class="form-card reveal" style="max-width:820px">
        <form method="POST"
              action="{{ $product ? route('admin.products.update', $product->id) : route('admin.products.store') }}"
              class="admin-form-grid">
            @csrf
            @if($product) @method('PUT') @endif

            <div class="form-group"><label>{{ __('messages.p_field_name_fa') }}</label><input class="input" name="name_fa" value="{{ old('name_fa', $product->name_fa ?? '') }}" required></div>
            <div class="form-group"><label>{{ __('messages.p_field_name_en') }}</label><input class="input" name="name_en" value="{{ old('name_en', $product->name_en ?? '') }}" required></div>
            <div class="form-group full"><label>{{ __('messages.p_field_desc_fa') }}</label><textarea class="input" name="desc_fa" style="min-height:80px">{{ old('desc_fa', $product->desc_fa ?? '') }}</textarea></div>
            <div class="form-group full"><label>{{ __('messages.p_field_desc_en') }}</label><textarea class="input" name="desc_en" style="min-height:80px">{{ old('desc_en', $product->desc_en ?? '') }}</textarea></div>
            <div class="form-group"><label>{{ __('messages.p_field_price') }}</label><input class="input" type="number" name="price" value="{{ old('price', $product->price ?? '') }}" required></div>
            <div class="form-group"><label>{{ __('messages.p_field_stock') }}</label><input class="input" type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}" required></div>
            <div class="form-group">
                <label>{{ __('messages.p_field_cat') }}</label>
                <select class="input" name="category_id">
                    @foreach($categories as $c)
                        <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id ?? null) == $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>{{ __('messages.filter_cats') }} › {{ __('messages.view_details') }}</label>
                <select class="input" name="subcategory_id">
                    <option value="">—</option>
                    @foreach($subcategories->groupBy('category_id') as $cid => $subs)
                        <optgroup label="{{ $subs->first()->category->name }}">
                            @foreach($subs as $s)
                                <option value="{{ $s->id }}" @selected(old('subcategory_id', $product->subcategory_id ?? null) == $s->id)>{{ $s->name }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
            <div class="form-group"><label>{{ __('messages.p_field_image') }}</label><input class="input" name="image" value="{{ old('image', $product->image ?? 'images/cat-buttons.jpg') }}"></div>
            <div class="form-group full" style="flex-direction:row;align-items:center;gap:10px">
                <input type="checkbox" name="featured" id="featChk" @checked(old('featured', $product->featured ?? false)) style="width:18px;height:18px;accent-color:var(--green-600)">
                <label for="featChk">{{ __('messages.p_field_featured') }}</label>
            </div>
            <div class="form-group full" style="flex-direction:row;gap:12px">
                <button class="btn btn-green" type="submit" style="flex:1">{{ __('messages.admin_save') }}</button>
                <a class="btn btn-outline" href="{{ route('admin.products') }}" style="flex:1">{{ __('messages.admin_cancel') }}</a>
            </div>
        </form>
    </div>
</div>
@endsection
