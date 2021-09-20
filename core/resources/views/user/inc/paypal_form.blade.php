

    <div class="panel-body">

        <form class="form-horizontal" method="POST" id="" role="form" action="{!! URL::route('addmoney.paypal') !!}" >
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                <label for="amount" class="col-md-4 control-label">{{ __('messages.enter_amt') }}</label>
                <div class="col-md-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><b>{{$settings->currency}}</b></span>
                        </div>
                        <input id="amount" type="number" class="form-control" name="amount" value="{{ old('amount') }}" required autofocus>                    
                    </div>
                    @if ($errors->has('amount'))
                        <span class="help-block">
                            <strong>{{ __('messages.err_amount') }}</strong>
                        </span>
                    @endif
                </div>

            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('messages.pay_now') }}
                    </button>
                </div>
            </div>

        </form>

    </div>
