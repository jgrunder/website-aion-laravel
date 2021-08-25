@extends('_layouts.master')

@section('content')
    <div class="container">
        <!-- LEFT CONTENT -->
        <div class="container_left">
            <div class="news">
                <div class="news_top">
                    <h2>{!! Lang::get('all.shop.title') !!} 
					@if(isset($top)) 
						({!! Lang::get('all.shop.best_sales') !!}) 
					@elseif(isset($searchValue))
						({!! Lang::get('all.shop.search_result') !!} "{{$searchValue}}" )
					@endif</h2>
                </div>
                <div class="news_body shop_container">

                    @foreach($items as $item)
                        <div class="item_shop">

                            <h3>
                                <img src="" alt="">
                                <a href="http://aiondatabase.net/{{Cookie::get('language')}}/item/{{$item->id_item}}" target="_blank" class="databaseItem quality-{{\Illuminate\Support\Str::lower($item->quality_item)}}" data-id="{{$item->id_item}}">
                                    {{\Illuminate\Support\Str::limit($item->name, 20, '...')}}
                                </a>
                            </h3>

                            <ul>
                                <li class="quantity">{!! Lang::get('all.shop.qt') !!} : <strong class="value">{{number_format($item->quantity, 0, '.', '.')}}</strong></li>
                                <li class="price">{!! Lang::get('all.shop.price') !!} :  <strong class="value">{{number_format($item->price, 0, '.', '.')}}</strong></li>
                                @if(Config::get('aion.enable_account_level'))
                                    <li class="price">{!! Lang::get('all.shop.level') !!} :  <strong class="value">{{$item->level}}</strong></li>
                                @endif
                            </ul>

                            <div class="buttons">
                                @if((isset($accountLevel->level) && $accountLevel->level >= $item->level) || (!isset($accountLevel) && $item->level == 0))
                                    <a href="#" class="addItemInCart" data-id="{{$item->id_item}}">Add</a>
                                @else
                                    <a style="opacity: 0;"></a>
                                @endif
                                @if($item->preview)
                                  <a href="#" class="previewItem" data-id="{{$item->id_item}}">Preview</a>
                                @else
                                  <a style="opacity: 0;"></a>
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>
                <div class="news_footer">
                    @if(!isset($top)) {!! $items->render() !!} @endif
                </div>
            </div>
        </div>
        <!-- RIGHT SIDEBAR -->
        <div class="container_right">
            <!-- Search Function -->
			@include('_modules.shop_search')

            <!-- CART -->
            <div class="bloc_with_header bloc_vote">
                <div class="bloc_header">
                    <h2>{!! Lang::get('all.shop.shopping_cart') !!}</h2>
                    <p>{!! Lang::get('all.shop.shopping_cart_desc') !!}</p>
                </div>
                <div class="bloc_body center container_shop_cart">
                    @include('_modules.cart')
                </div>
            </div>

            <!-- CATEGORIES -->
            <div class="bloc_with_header bloc_vote">
                <div class="bloc_header">
                    <h2>{!! Lang::get('all.shop.categories') !!}</h2>
                    <p>{!! Lang::get('all.shop.categories_desc') !!}</p>
                </div>
                <div class="bloc_body center container_shop_categories">

                    <ul class="categories">
                        @foreach($categories as $index => $category)
                            <li class="top_categorie">
                                <h4>> {{$category->category_name}}</h4>
                                <ul class="sub_categorie" style="display: none; font-size: 12px">
                                    @foreach($category->name as $sub_category)
                                        <li><a href="/shop/category/{{$sub_category->id}}">{{$sub_category->name}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>
    </div>
@stop
