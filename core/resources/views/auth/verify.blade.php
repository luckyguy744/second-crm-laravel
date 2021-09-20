@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('messages.email_vrfy') }}</div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('messages.email_resent') }}
                        </div>
                    @endif

                    {{ __('messages.check_email') }}
                    {{ __('messages.email_not_received') }}, <a href="{{ route('verification.resend') }}">{{ __('messages.email_resent_req') }}</a>.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
