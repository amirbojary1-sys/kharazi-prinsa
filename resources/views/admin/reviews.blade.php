@extends('layouts.app')

@section('title', __('messages.admin_reviews'))

@section('content')
<div class="container admin-shell">
    <div class="page-head reveal"><h1>⭐ {{ __('messages.admin_reviews') }}</h1></div>
    @include('partials.admin-nav')

    <div class="table-wrap reveal" style="margin-top:18px">
        <table>
            <thead><tr>
                <th>{{ __('messages.rev_product') }}</th><th>{{ __('messages.rev_author') }}</th>
                <th>{{ __('messages.rating') }}</th><th>{{ __('messages.rev_comment') }}</th>
                <th>{{ __('messages.o_status') }}</th><th></th>
            </tr></thead>
            <tbody>
            @forelse($reviews as $r)
                <tr>
                    <td><a href="{{ route('product', $r->product_id) }}"><b>{{ $r->product->name }}</b></a></td>
                    <td>{{ $r->author_name }}</td>
                    <td>{{ \App\Support\Fmt::num($r->rating) }} ⭐</td>
                    <td style="max-width:320px">{{ \Illuminate\Support\Str::limit($r->comment, 90) }}</td>
                    <td><span class="tag {{ $r->status === 'approved' ? 'paid' : ($r->status === 'rejected' ? 'cancelled' : 'pending') }}">{{ __('messages.rev_' . $r->status) }}</span></td>
                    <td style="white-space:nowrap">
                        @if($r->status !== 'approved')
                            <form method="POST" action="{{ route('admin.reviews.status', $r->id) }}" style="display:inline">@csrf
                                <input type="hidden" name="status" value="approved">
                                <button class="mini-btn">{{ __('messages.rev_approve') }}</button></form>
                        @endif
                        @if($r->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.reviews.status', $r->id) }}" style="display:inline">@csrf
                                <input type="hidden" name="status" value="rejected">
                                <button class="mini-btn danger">{{ __('messages.rev_reject') }}</button></form>
                        @endif
                        <form method="POST" action="{{ route('admin.reviews.destroy', $r->id) }}" style="display:inline">@csrf @method('DELETE')
                            <button class="mini-btn danger">{{ __('messages.admin_delete') }}</button></form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;padding:30px;color:var(--muted)">{{ __('messages.no_reviews') }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
