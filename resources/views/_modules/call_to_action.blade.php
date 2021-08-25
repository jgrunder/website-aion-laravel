<div class="call_to_action">
  <a href="{{Route('stats.online')}}" class="online_player">
    <span class="elyos_count">{{$countPlayersOnlineElyos}}</span>
    <span class="asmo_count">{{$countPlayersOnlineAsmodians}}</span>
  </a>
  <a href="{{Route('donation')}}" class="donation"><span>{{Lang::get('all.nav.donate')}}</span></a>
  <a href="{{Route('shop')}}" class="shop"><span>{{Lang::get('all.nav.shop')}}</span></a>
</div>
