@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center page-header">
                <h1>Search Result</h1>
            </div>
            <div class="col-md-12">
                @if ($searchType == 'shop_item_name' || $searchType == 'shop_item_id')
                    @include('admin.search.shop')
                @elseif ($searchType == 'character')
                    @include('admin.search.character')
                @endif
            </div>
        </div>
        <!-- Pagination -->
        <div class="row text-center">
            <div class="col col-md-12">
                {!!$results->render()!!}
            </div>
        </div>
    </div>
@stop
