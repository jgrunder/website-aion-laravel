@extends('_layouts.master')

@section('content')
    <div class="container">
        <div class="container_left">

            <!-- CALL TO ACTION -->
            @include('_modules.call_to_action')

                    <!-- NEWS -->
            <div class="news">
                <div class="news_top">
                    <h1>{{ Lang::get('all.login.missing_password') }}</h1>
                </div>
                <div class="news_body center">

                    @if($step == 1)

                        <p>{{ Lang::get('all.forgot_password.intro') }}</p>

                        <br>

                        @if($success) {{$success}} @else {{$errors}} @endif

                        <br>

                        {!! Form::open() !!}

                        {!! Form::email('email', null, ['placeholder' => Lang::get('all.subscribe.email'), 'class' => 'input', 'required' => 'required']) !!}

                        <input type="submit" class="btn" value="{!! Lang::get('all.forgot_password.submit') !!}">

                        {!! Form::close() !!}

                    @else

                        @if($success) {{$success}} @else {{$errors}} @endif

                    @endif

                </div>
                <div class="news_footer">
                </div>
            </div>

        </div>
        <!-- RIGHT SIDEBAR -->
        <div class="container_right">
            @include('_modules.right_sidebar')
        </div>
    </div>
@stop
