@foreach($news as $article)
    <div class="news">
      <div class="news_top">
        <h2><a href="{{Route('news', ["slug" => $article->slug, "id" => $article->id])}}">{{$article->title}}</a></h2>
      </div>
      <div class="news_body">
        <p>
          @if(isset($full))
            {!! $article->text !!}
          @else
            {!! Str::limit($article->text, 500) !!}
          @endif
        </p>
      </div>
      <div class="news_footer">
        <p>{{Lang::get('all.news.by')}} {{($article->creator->pseudo !== '') ? $article->creator->pseudo : 'Admin'}} {{\Carbon\Carbon::parse($article->created_at)->format('d/m/Y H:i')}}</p>
          @if(!isset($full))
              <a href="{{Route('news', ["slug" => $article->slug, "id" => $article->id])}}">{{Lang::get('all.news.next')}} &raquo;</a>
          @endif
      </div>
    </div>
@endforeach

<!-- PAGINATION -->
@if(!isset($full))
    {!! $news->render() !!}
@endif
