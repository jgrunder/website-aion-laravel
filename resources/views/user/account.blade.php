@extends('_layouts.master')

@section('content')
    <div class="container">
        <div class="container_left">

            <!-- CALL TO ACTION -->
            @include('_modules.call_to_action')

            <!-- NEWS -->
            <div class="news">
                <div class="news_top">
                    <h1>{{ Lang::get('all.my_account.title') }}</h1>
                </div>
                <div class="news_body">
                    <h2>{{ Lang::get('all.my_account.my_informations') }} :</h2>

                    <ul>
                        <li>{{ Lang::get('all.my_account.username') }} : {{$user['name']}}</li>
                        <li>Pseudo : {{$user['pseudo']}}</li>
                        <li>Email : {{$user['email']}}</li>
                    </ul>

                    <a href="{{Route('user.account.edit')}}" class="btn btn-small">{{ Lang::get('all.my_account.modify_my_account') }}</a>

                    <br><br>

                    <h2>{{ Lang::get('all.my_account.shop') }} :</h2>

                    {{ Lang::get('all.my_account.on_your_account') }} <strong class="text-blue">{{$user['shop_points']}} Shop's Points</strong>
                    @if(Config::get('aion.enable_account_level'))
                        {{ Lang::get('all.my_account.and_you_spent') }} <strong class="text-blue">@if(!$level) 0€ @else {{$level['total'].'€'}} @endif </strong><br>
                        {{ Lang::get('all.my_account.to_achieve_the') }}  <strong class="text-blue">{{$nextLevel['level']}}</strong> {{ Lang::get('all.my_account.must_spend') }} <strong class="text-blue">{{$nextLevel['price']}}€</strong>
                    @endif

                    <br><br>

                    <h2>{{ Lang::get('all.my_account.characters') }} :</h2>
                    <table>
                        <thead>
                        <tr>
                            <th>{{ Lang::get('all.my_account.table.name') }}</th>
                            <th>{{ Lang::get('all.my_account.table.faction') }}</th>
                            <th>{{ Lang::get('all.my_account.table.level') }}</th>
                            <th>{{ Lang::get('all.my_account.table.classe') }}</th>
                            <th>{{ Lang::get('all.my_account.table.legion') }}</th>
                            <th>{{ Lang::get('all.my_account.table.action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($players as $index => $player)
                            <tr>
                                <td class="strong">{{$player->name}}</td>
                                <td>{{$player->exp}}</td>
                                <td><span class="{{Lang::get('aion.race_logo.'.$player->race)}}"></span></td>
                                <td><span class="charactericon-class {{Lang::get('aion.class_logo.'.$player->player_class)}}"></span></td>
                                @if($player->memberOfALegion)
                                    <td>{{$player->memberOfALegion->legion->name}}</td>
                                @else
                                    <td></td>
                                @endif
                                <td><a class="btnUnluckPlayer" player-id="{{$player->id}}" account-id="{{Session::get('user.id')}}">{{ Lang::get('all.my_account.table.unlock') }}</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

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
