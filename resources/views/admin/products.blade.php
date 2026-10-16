@extends('layouts.app')

@section('title', __('messages.admin_products'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>{{ __('messages.admin_products') }}</h1></div>

    @include('partials.admin-nav')

    <div class="admin-topbar" style="margin:14px 0">
        <form method="GET" action="{{ route('admin.products') }}" style="display:flex;gap:8px;flex:1;max-width:520px">
            <input class="form-input" name="q" value="{{ request('q') }}" placeholder="{{ __('messages.search_placeholder') }}">
            <select class="form-input" name="cat" style="max-width:180px">
                <option value="">{{ __('messages.all') }}</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(request('cat') == $c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <button class="mini-btn">{{ __('messages.search_btn') }}</button>
        </form>
        <h2>📦 (@num($products->count()))</h2>
    </div>

    <div style="display:flex;justify-content:flex-end;margin-bottom:18px">
        <a class="btn btn-green" href="{{ route('admin.products.create') }}">＋ {{ __('messages.admin_add_product') }}</a>
    </div>

    <div class="table-wrap reveal">
        <table>
            <thead>
            <tr>
                <th></th>
                <th>{{ __('messages.p_field_name_fa') }}</th>
                <th>{{ __('messages.p_field_cat') }}</th>
                <th>{{ __('messages.price') }}</th>
                <th>{{ __('messages.p_field_stock') }}</th>
                <th>{{ __('messages.o_status') }}</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            @foreach($products as $p)
                <tr>
                    <td><img class="thumb" src="{{ asset($p->image) }}" alt=""></td>
                    <td><b>{{ $p->name }}</b><br><span style="color:var(--muted);font-size:.76rem">ID: {{ $p->id }}</span></td>
                    <td>{{ $p->category->name }}</td>
                    <td>@price($p->price)</td>
                    <td>@num($p->stock)</td>
                    <td>
                        @if($p->featured)<span class="tag featured">⭐ {{ __('messages.p_field_featured') }}</span>
                        @elseif($p->stock <= 0)<span class="tag cancelled">{{ __('messages.out_stock') }}</span>
                        @else<span class="tag paid">{{ __('messages.in_stock') }}</span>@endif
                    </td>
                    <td style="white-space:nowrap">
                        <a class="mini-btn" href="{{ route('admin.products.edit', $p->id) }}">{{ __('messages.admin_edit') }}</a>
                        <form method="POST" action="{{ route('admin.products.destroy', $p->id) }}" style="display:inline" onsubmit="return confirm('{{ __('messages.admin_confirm_del') }}')">
                            @csrf @method('DELETE')
                            <button class="mini-btn danger">{{ __('messages.admin_delete') }}</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
