@extends('_layouts.master')

@section('content')
    <div class="container">
        <div class="container_left">

            <!-- CALL TO ACTION -->
            @include('_modules.call_to_action')

            <!-- NEWS -->
            <div class="news">
                <div class="news_top">
                    <h1>{{ Lang::get('all.edit_account.title') }}</h1>
                </div>
                <div class="news_body">

                    {!! Form::open() !!}

                    <span>Pseudo : </span>
                    {!! Form::text('pseudo', $user->pseudo, ['placeholder' => 'Pseudo', 'class' => 'input block']) !!}
                    @if(isset($errors['pseudo']))
                        <span class="error">{{$errors['pseudo']}}</span>
                    @elseif(isset($success['pseudo']))
                        <span class="success">{{$success['pseudo']}}</span>
                    @endif

                    @if(Config::get('services.pushbullet.apiKey'))
                        <span>PushBullet : </span>
                        {!! Form::email('pushbullet', $user->pushbullet, ['placeholder' => 'Email Pushbullet', 'class' => 'input block']) !!}
                        @if(isset($errors['pushbullet']))
                            <span class="error">{{$errors['pushbullet']}}</span>
                        @elseif(isset($success['pushbullet']))
                            <span class="success">{{$success['pushbullet']}}</span>
                        @endif
                    @endif

                    <span>{{ Lang::get('all.edit_account.new_password') }} : </span>
                    {!! Form::password('password', ['placeholder' => Lang::get('all.subscribe.password'), 'class' => 'input block']) !!}
                    {!! Form::password('password_confirmation', ['placeholder' => Lang::get('all.subscribe.password_confirm'), 'class' => 'input block']) !!}
                    @if(isset($errors['password']))
                        <span class="error">{{$errors['password']}}</span>
                    @elseif(isset($success['password']))
                        <span class="success">{{$success['password']}}</span>
                    @endif

                    <input type="submit" class="btn btn-primary" value="{{ Lang::get('all.edit_account.edit') }}">

                    {!! Form::close() !!}

                </div>

                <div class="news_footer"></div>

            </div>

        </div>
        <!-- RIGHT SIDEBAR -->
        <div class="container_right">
            @include('_modules.right_sidebar')
        </div>
    </div>
@stop
