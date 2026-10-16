@extends('layouts.app')

@section('title', __('messages.contact_title'))

@section('content')
<div class="container">
    <div class="page-head reveal"><h1>{{ __('messages.contact_title') }}</h1></div>
    <div class="contact-layout">
        <div class="contact-info">
            <div class="contact-item reveal"><div class="ic">📍</div><div><b>{{ __('messages.contact_addr_t') }}</b><p>{{ __('messages.contact_addr') }}</p></div></div>
            <div class="contact-item reveal" data-delay="1"><div class="ic">📞</div><div><b>{{ __('messages.contact_phone_t') }}</b><p><a href="tel:+982144556677">{{ __('messages.contact_phone') }}</a></p></div></div>
            <div class="contact-item reveal" data-delay="2"><div class="ic">🕐</div><div><b>{{ __('messages.contact_hours_t') }}</b><p>{{ __('messages.contact_hours') }}</p></div></div>
            <div class="contact-item reveal" data-delay="3"><div class="ic">💬</div><div><b>{{ __('messages.contact_social_t') }}</b><p>Instagram / Telegram / WhatsApp</p></div></div>
        </div>
        <div class="form-card reveal">
            <form method="POST" action="{{ route('contact.send') }}" class="form-grid">
                @csrf
                <div class="form-group full"><label>{{ __('messages.f_name') }}</label><input class="input" name="name" placeholder="{{ __('messages.form_name_ph') }}" required></div>
                <div class="form-group full"><label>{{ __('messages.f_phone') }}</label><input class="input" name="phone" inputmode="tel"></div>
                <div class="form-group full"><label>{{ __('messages.form_msg_ph') }}</label><textarea class="input" name="message" placeholder="{{ __('messages.form_msg_ph') }}" required></textarea></div>
                <div class="form-group full"><button class="btn btn-primary btn-block" type="submit">{{ __('messages.send_msg') }}</button></div>
            </form>
        </div>
    </div>
</div>
@endsection
