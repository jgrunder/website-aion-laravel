<!-- NOUS REJOINDRE -->
<div class="bloc_without_header">
  <a href="{{Route('page.joins-us')}}" class="joinus @if(Cookie::get('language') == 'en') ? en : '' @endif"></a>
</div>

<!-- VOTEZ POUR NOUS -->
@if(Config::get('aion.vote.activated'))
    <div class="bloc_with_header bloc_vote">
      <div class="bloc_header">
        <h2>{{Lang::get('all.vote.title')}}</h2>
        @if(Config::get('aion.vote.boost'))
          <p>{{Lang::get('all.vote.boost')}}</p>
        @endif
        <p>1 vote = <span class="strong">{{(!Config::get('aion.vote.boost')) ? Config::get('aion.vote.shop_points_per_vote') : Config::get('aion.vote.shop_points_per_vote') + Config::get('aion.vote.boost_value')}} Shop's Points</span></p>
      </div>
      <div class="bloc_body center">
        @foreach(Config::get('aion.vote.links') as $key => $vote)

          @if(Session::has('connected') && $accountVotes[$key]['status'])
              <a href="{{ URL::route('vote', $key) }}">{{Lang::get('all.vote.vote')}} {{$vote['name']}}</a>
          @elseif (Session::has('connected') && !$accountVotes[$key]['status'])
              <p>
                  {{$vote['name']}} <br>
                  <span class="text-blue text-size-little">
                      @if($accountVotes[$key]['diff_hours'])
                          {{$accountVotes[$key]['diff_hours']}}Heure et
                      @endif
                      {{$accountVotes[$key]['diff_minutes']}}min</span>

              </p>
          @else
              <a href="{{$vote['link']}}">{{Lang::get('all.vote.vote')}} {{$vote['name']}}</a>
          @endif

        @endforeach
      </div>
    </div>
@endif

<!-- TOP VOTER -->
<div class="bloc_with_header bloc_vote">
    <div class="bloc_header">
        <h2>{{Lang::get('all.top_vote.title')}}</h2>
        <p>{{Lang::get('all.top_vote.description')}}</p>
    </div>
    <div class="bloc_body center">
        <table>
            <thead>
                <tr>
                    <th width="18%">#</th>
                    <th style="text-align: left;">Pseudo</th>
                    <th>Votes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topVotes as $index => $account)
                    <tr>
                        <td width="18%" class="strong">{{$index + 1}}</td>
                        <td style="text-align: left;">@if(empty($account->pseudo)) {{$account->name}} @else {{$account->pseudo}} @endif</td>
                        <td>{{$account->vote}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@if(Config::get('aion.enable_weddings') && isset($weddings) && $weddings->count() > 0)
<div class="bloc_with_header bloc_vote">
    <div class="bloc_header" style="background-color: #e6549f">
        <h2 style="color: white">{{Lang::get('all.weddings.title')}}</h2>
        <p style="color: white">{{Lang::get('all.weddings.sub_title')}}</p>
    </div>
    <div class="bloc_body center">
        <table>
            <tbody>
                @foreach($weddings as $wedding)
                    <tr>
                        <td width="100%" style="text-align: center">
                            {{$wedding->firstPlayer->name}}
                            <span style="color: #e6549">♥</span>
                            {{$wedding->secondPlayer->name}}
                         </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif