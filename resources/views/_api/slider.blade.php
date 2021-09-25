<!-- SLIDER -->
<ul id="bxslider">
    @foreach($slider as $value)
        <li><img src="{!! asset($value['path']) !!}" title="{{$value['title']}}"/></li>
    @endforeach
</ul>

<div class="slider_controller">
    <span id="slider-prev"></span>
    <span id="slider-next"></span>
</div>