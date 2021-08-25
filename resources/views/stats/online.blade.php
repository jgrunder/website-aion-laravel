@extends('_layouts.master')

@section('content')
  <div class="container_single">
    <div class="container_single_top">
      <h1>{{Lang::get('all.nav.online')}}</h1>
    </div>
    <div class="container_single_body">
      @if(count($users) === 0)
          <center>{{Lang::get('all.online.no_players_online')}}</center>
      @else
        <table>
          <thead>
            <tr>
              <th>{{Lang::get('all.online.name')}}</th>
              @if(Config::get('aion.page.online_players.display_level'))
                <th>{{Lang::get('all.online.level')}}</th>
              @endif
              @if(Config::get('aion.page.online_players.display_map') && Session::has('connected') && Session::get('user.access_level') >= Config::get('aion.page.online_players.display_map_access_level'))
                <th>{{Lang::get('all.online.world')}}</th>
              @endif
              <th>{{Lang::get('all.online.faction')}}</th>
              <th>{{Lang::get('all.online.classe')}}</th>
              <th>{{Lang::get('all.online.legion')}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($users as $user)
              <tr>
                <td class="strong">{{$user->name}}</td>
                @if(Config::get('aion.page.online_players.display_level'))
                  <td>{{$user->exp}}</td>
                @endif
                @if(Config::get('aion.page.online_players.display_map') && Session::has('connected') && Session::get('user.access_level') >= Config::get('aion.page.online_players.display_map_access_level'))
                  <td>{{$user->world_id}}</td>
                @endif
                <td><span class="{{Lang::get('aion.race_logo.'.$user->race)}}"></span></td>
                <td><span class="charactericon-class {{Lang::get('aion.class_logo.'.$user->player_class)}}"></span></td>
                @if($user->memberOfALegion)
                    <td>{{$user->memberOfALegion->legion->name}}</td>
                @else
                    <td></td>
                @endif
              </tr>
            @endforeach
          </tbody>
        </table>
      @endif
      <!-- Pagination -->
      {!! $users->render() !!}
    </div>
  </div>
@stop
