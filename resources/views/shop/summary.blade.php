@extends('_layouts.master')

@section('content')
    <div class="container">
        <!-- LEFT CONTENT -->
        <div class="container_left">
            <div class="news">
                <div class="news_top">
                    <h2>{!! Lang::get('all.shop.summary') !!}</h2>
                </div>
                <div class="news_body container_shop_recap">

                    <table>
                        <thead>
                        <tr>
                            <th width="45%">{!! Lang::get('all.shop.name') !!}</th>
                            <th>{!! Lang::get('all.shop.price') !!}</th>
                            <th width="15%">{!! Lang::get('all.shop.qt') !!}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($items_cart as $item)
                            <tr>
                                <td width="45%">{{$item->name}}</td>
                                <td>{{number_format($item->price, 0, '.', '.')}}</td>
                                <td width="15%">{{number_format($item->qty * $item->options['quantity'], 0, '.', '.')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                        <!-- Total -->
                        <tr>
                            <td></td>
                            <td></td>
                            <td style="font-weight: bold">{{number_format($total, 0, '.', '.')}} Points's Shop</td>
                        </tr>
                    </table>

                    @if($players)
                        {!! Form::open() !!}

                        {!! Form::select('player_id', $players, null, ['class' => 'select']) !!}

                        <input type="submit" class="btn" value="Acheter"/>

                        {!! Form::close() !!}
                    @else
                        <br>
                        <center><a href="{{Route('shop')}}" class="btn">{!! Lang::get('all.shop.no_characters') !!}</a></center>
                    @endif

                </div>
                <div class="news_footer"></div>
            </div>
        </div>
        <!-- RIGHT SIDEBAR -->
        <div class="container_right">

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
                                <ul class="sub_categorie" style="display: none">
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
