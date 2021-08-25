@extends('_layouts.master')

@section('content')
    <div class="container_single">
        <div class="container_single_top">
            <h1>{{Lang::get('all.paypal.title')}}</h1>
        </div>
        <div class="container_single_body center">

          @if ($step == 1)
              <p>{{Lang::get('all.paypal.slider')}}</p> <br>

              {!! Form::open(['url' => 'https://www.paypal.com/cgi-bin/webscr', 'method' => 'post', 'class' => 'form-horizontal']) !!}

                {!! Form::input('range', 'tollWanted', Config::get('aion.paypal.points_per_euro'), [
                    'class'    => 'input-range',
                    'required' => 'required',
                    'id'       => 'btn_toll_wanted',
                    'min'      => Config::get('aion.paypal.points_per_euro'),
                    'max'      => Config::get('aion.paypal.maxShopPoints'),
                    'step'     => Config::get('aion.paypal.points_per_euro')
                ]) !!}

                {!! Form::input('hidden', 'business', Config::get('aion.paypal.email')) !!}
                {!! Form::input('hidden', 'notify_url', Config::get('app.url').'/paypal-ipn') !!}
                {!! Form::input('hidden', 'return', Config::get('app.url').'/paypal-valid') !!}
                {!! Form::input('hidden', 'item_name', Config::get('aion.paypal.points_per_euro')." Shop's Points", ['id' => 'paypal_name']) !!}
                {!! Form::input('hidden', 'quantity', '1') !!}
                {!! Form::input('hidden', 'currency_code', Config::get('aion.paypal.currency_code')) !!}
                {!! Form::input('hidden', 'amount', 1, ['id' => 'money']) !!}
                {!! Form::input('hidden', 'cmd', '_xclick') !!}
                {!! Form::input('hidden', 'uid', $uid, ['id' => "user_id"]) !!}
                {!! Form::input('hidden', 'custom', 'points='.Config::get('aion.paypal.points_per_euro').'&uid='.$uid, ['id' => "custom_paypal"]) !!}

                <br> <br>

                <center id="money_need">{{Lang::get('all.paypal.buy')}} {{Config::get('aion.paypal.points_per_euro')}} Shop's Points {{Lang::get('all.paypal.for')}} 1{{Config::get('aion.paypal.currency_display')}}</center>
                <input type="submit" class="btn btn-primary" value="{{Lang::get('all.paypal.buy')}}">

              {!! Form::close() !!}
          @endif

          @if ($step == 2)
              <p>{{Lang::get('all.paypal.congratulations')}}</p>
          @endif

        </div>
    </div>
@stop

@section('javascript')
    @parent

    <script>
        $(document).ready(function(){
            var inputTypeRange = $("input[type=range]");

            if(inputTypeRange.length > 0) {

                inputTypeRange.on('input', function() {

                    var nbTool    = $(this).val(); // 5000
                    var moneyNeed = $(this).val() / Number("{{ Config::get('aion.paypal.points_per_euro') }}");
                    var uid		  = $('#user_id').val();

                    $('#money_need').text("{{Lang::get('all.paypal.buy')}} "+ nbTool +" Shop's Points {{Lang::get('all.paypal.for')}} "+ moneyNeed +"€");
                    $('#paypal_name').val(nbTool+" Shop's Points");
                    $('#money').val(moneyNeed);
                    $('#custom_paypal').val('points='+nbTool+'&uid='+uid);
                });
            }
        });
    </script>
@stop