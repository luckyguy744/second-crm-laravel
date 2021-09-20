<!DOCTYPE html>
<html>
<head>
    <title>{{$settings->site_title}} - Stripe Payment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="/atlantis/style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <h3 align="center"><img src="/img/{{$settings->site_logo}}" class="login_logo"></h3>
                <p class="text-center">{{$settings->site_title}}</p>
                <div class="panel panel-default credit-card-box">
                    <div class="panel-heading display-table" >
                        <div class="row display-tr" >
                            <h3 class="panel-title display-td">{{ __('messages.paymt_det') }}</h3>
                            <div class="display-td" >             
                                <img class="img-responsive pull-right" src="http://i76.imgup.net/accepted_c22e0.png">
                            </div>
                        </div>    
                    </div>
                    <div class="panel-body"> 
                        @if (Session::has('success'))
                            <div class="alert alert-success text-center">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                                <p>{{ __('messages.suc_msg') }}</p>
                            </div>
                        @endif  
                        <form role="form" action="{{ route('stripe.Submit') }}" method="post" class="require-validation" data-cc-on-file="false"  data-stripe-publishable-key="{{ $settings->stripe_key }}" id="payment-form">
                            @csrf
                            <div class='form-row row'>
                                <div class='col-xs-12 form-group required'>
                                    <label class='control-label'>{{ __('messages.name_on_card') }}</label> 
                                    <input class='form-control' size='4' type='text'>
                                    <input class='form-control' value="{{$amt}}" size='4' name="amt" type='hidden'>
                                </div>
                            </div>
                            <div class='form-row row'>
                                <div class='col-xs-12 form-group card required'>
                                    <label class='control-label'>{{ __('messages.card_no') }}</label> 
                                    <input autocomplete='off' class='form-control card-number' size='20' type='text'>
                                </div>
                            </div> 
                            <div class='form-row row'>
                                <div class='col-xs-12 col-md-4 form-group cvc required'>
                                    <label class='control-label'>{{ __('messages.card_cvc') }}</label>
                                    <input autocomplete='off' class='form-control card-cvc' placeholder='ex. 311' size='4' type='text'>
                                </div>
                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>{{ __('messages.card_exp_m') }}</label> 
                                    <input class='form-control card-expiry-month' placeholder='MM' size='2' type='text'>
                                </div>

                                <div class='col-xs-12 col-md-4 form-group expiration required'>
                                    <label class='control-label'>{{ __('messages.card_exp_y') }}</label>
                                    <input class='form-control card-expiry-year' placeholder='YYYY' size='4' type='text'>
                                </div>

                            </div>
                            <div class='form-row row'>
                                <div class='col-md-12 error form-group hide'>
                                    <div class='alert-danger alert'>{{ __('messages.correct_err') }}</div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">{{ __('messages.pay_now').' $'. $amt}}</button>
                                </div>
                            </div>
                        </form>

                    </div>

                </div>        

            </div>

        </div>
    </div>
</body>
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript">

$(function() {

    var $form = $(".require-validation");

    $('form.require-validation').bind('submit', function(e) {

    var $form = $(".require-validation"),

        inputSelector = ['input[type=email]', 'input[type=password]',

                         'input[type=text]', 'input[type=file]',

                         'textarea'].join(', '),

        $inputs = $form.find('.required').find(inputSelector),

        $errorMessage = $form.find('div.error'),

        valid         = true;

        $errorMessage.addClass('hide'); 

        $('.has-error').removeClass('has-error');

    $inputs.each(function(i, el) {

      var $input = $(el);

      if ($input.val() === '') {

        $input.parent().addClass('has-error');

        $errorMessage.removeClass('hide');

        e.preventDefault();

      }

    });

    if (!$form.data('cc-on-file')) {

      e.preventDefault();

      Stripe.setPublishableKey($form.data('stripe-publishable-key'));

      Stripe.createToken({

        number: $('.card-number').val(),

        cvc: $('.card-cvc').val(),

        exp_month: $('.card-expiry-month').val(),

        exp_year: $('.card-expiry-year').val()

      }, stripeResponseHandler);

    }  

  });
  function stripeResponseHandler(status, response) {
        if (response.error) {
            $('.error')
                .removeClass('hide')
                .find('.alert')
                .text(response.error.message);

        } 
        else 
        {
            var token = response['id'];
            $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
            $form.get(0).submit();
        }

    }
});

</script>
</html>