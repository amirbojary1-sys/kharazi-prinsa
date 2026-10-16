<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ __('messages.gw_title') }} — {{ __('messages.brand') }}</title>
<style>
    * { margin:0; padding:0; box-sizing:border-box; font-family: Vazirmatn, Tahoma, sans-serif; }
    body { min-height:100vh; background:linear-gradient(160deg,#0b3d2e 0%,#14614a 45%,#0a2f24 100%); display:flex; align-items:center; justify-content:center; padding:20px; }
    .gw { width:100%; max-width:520px; background:#fff; border-radius:22px; overflow:hidden; box-shadow:0 40px 90px rgba(0,0,0,.45); }
    .gw-top { background:linear-gradient(135deg,#0d5c43,#1a8a64); color:#fff; padding:22px 26px; display:flex; align-items:center; gap:14px; }
    .gw-logo { width:52px; height:52px; border-radius:14px; background:linear-gradient(135deg,#c9a227,#f0d97a); display:flex; align-items:center; justify-content:center; font-size:24px; }
    .gw-top h1 { font-size:1.05rem; font-weight:800; }
    .gw-top p { font-size:.78rem; opacity:.85; margin-top:2px; }
    .gw-shaparak { background:#e8f5ef; color:#0d5c43; font-size:.72rem; font-weight:700; padding:8px 26px; letter-spacing:.4px; display:flex; justify-content:space-between; align-items:center; }
    .gw-body { padding:26px; }
    .gw-merchant { display:flex; justify-content:space-between; font-size:.85rem; color:#444; padding-bottom:14px; border-bottom:1px dashed #dde5e1; }
    .gw-amount { text-align:center; padding:22px 0; }
    .gw-amount span { font-size:.82rem; color:#777; }
    .gw-amount b { display:block; font-size:1.9rem; color:#0d5c43; margin-top:6px; letter-spacing:-.5px; }
    .gw-amount small { color:#999; font-size:.75rem; }
    .gw-field { margin-bottom:12px; }
    .gw-field label { display:block; font-size:.78rem; color:#666; margin-bottom:6px; font-weight:700; }
    .gw-field input { width:100%; border:1.5px solid #d8e2dd; border-radius:12px; padding:13px 15px; font-size:1rem; direction:ltr; text-align:center; letter-spacing:2px; outline:none; transition:.2s; background:#fafcfb; }
    .gw-field input:focus { border-color:#1a8a64; box-shadow:0 0 0 4px rgba(26,138,100,.12); background:#fff; }
    .gw-row { display:flex; gap:12px; }
    .gw-row .gw-field { flex:1; }
    .gw-cvv { display:flex; gap:12px; }
    .gw-note { display:flex; align-items:center; gap:8px; background:#f2f8f5; border-radius:12px; padding:11px 14px; font-size:.75rem; color:#0d5c43; margin:14px 0 18px; }
    .gw-btns { display:flex; gap:12px; }
    .gw-btns button { flex:1; border:0; border-radius:14px; padding:15px; font-size:.98rem; font-weight:800; cursor:pointer; transition:.2s; }
    .gw-pay { background:linear-gradient(135deg,#0d5c43,#1a8a64); color:#fff; box-shadow:0 12px 26px rgba(13,92,67,.35); }
    .gw-pay:hover { transform:translateY(-2px); box-shadow:0 18px 34px rgba(13,92,67,.45); }
    .gw-cancel { background:#f3f5f4; color:#666; }
    .gw-cancel:hover { background:#e9eceb; }
    .gw-foot { text-align:center; font-size:.7rem; color:#aaa; padding:16px; border-top:1px solid #eef2f0; }
    .gw-foot .sec { color:#1a8a64; font-weight:700; }
    .gw-demo { background:#fff8e1; border:1px solid #f0e3a8; color:#8a6d1a; border-radius:12px; padding:10px 14px; font-size:.73rem; margin-bottom:16px; line-height:1.8; text-align:center; }
    @media (max-width:520px){ .gw-amount b{font-size:1.55rem} }
</style>
</head>
<body>
<div class="gw">
    <div class="gw-top">
        <div class="gw-logo">🧵</div>
        <div>
            <h1>{{ __('messages.brand') }}</h1>
            <p>{{ __('messages.gw_subtitle') }}</p>
        </div>
    </div>
    <div class="gw-shaparak">
        <span>{{ __('messages.gw_shaparak') }}</span>
        <span>{{ __('messages.gw_order') }} {{ $order->code }}</span>
    </div>
    <div class="gw-body">
        <div class="gw-merchant">
            <span>{{ __('messages.gw_merchant') }}: {{ \App\Models\Setting::get('store_name') }}</span>
            <span>{{ __('messages.gw_date') }}: {{ \App\Support\Fmt::date($order->created_at) }}</span>
        </div>

        <div class="gw-amount">
            <span>{{ __('messages.gw_amount') }}</span>
            <b>{{ number_format($order->total) }}</b>
            <small>{{ __('messages.toman') }}</small>
        </div>

        <div class="gw-demo">
            ⚠️ {{ __('messages.gw_demo_note') }}
        </div>

        <form method="POST" action="{{ route('payment.callback', $order->code) }}">
            @csrf
            <div class="gw-field">
                <label>{{ __('messages.gw_card') }}</label>
                <input name="card_no" inputmode="numeric" maxlength="19" placeholder="6037-____-____-____" required>
            </div>
            <div class="gw-row">
                <div class="gw-field">
                    <label>{{ __('messages.gw_exp') }}</label>
                    <input name="exp" placeholder="05/08" maxlength="5" required>
                </div>
                <div class="gw-field">
                    <label>{{ __('messages.gw_cvv') }}</label>
                    <input name="cvv2" inputmode="numeric" maxlength="4" placeholder="123" required>
                </div>
            </div>
            <div class="gw-field">
                <label>{{ __('messages.gw_pin') }}</label>
                <input name="pin" inputmode="numeric" maxlength="8" placeholder="••••••" required>
            </div>

            <input type="hidden" name="card_pan" id="panField" value="">
            <input type="hidden" name="status" id="statusField" value="ok">
            <input type="hidden" name="ref_id" value="{{ \App\Services\PaymentGateway::demoRef() }}">

            <div class="gw-note">
                🔒 {{ __('messages.gw_secure') }}
            </div>

            <div class="gw-btns">
                <button type="submit" class="gw-pay" onclick="document.getElementById('statusField').value='ok';document.getElementById('panField').value=(document.getElementsByName('card_no')[0].value||'6037-****-****-1234').slice(0,7)+'****-****'+(document.getElementsByName('card_no')[0].value.slice(-4)||'1234');">
                    {{ __('messages.gw_pay_btn') }}
                </button>
                <button type="submit" formaction="{{ route('payment.callback', $order->code) }}" class="gw-cancel" onclick="document.getElementById('statusField').value='cancel';">
                    {{ __('messages.gw_cancel_btn') }}
                </button>
            </div>
        </form>
    </div>
    <div class="gw-foot">
        <span class="sec">🔒 {{ __('messages.gw_secure_footer') }}</span><br>
        {{ __('messages.gw_help') }}
    </div>
</div>
</body>
</html>
