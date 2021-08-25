@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center page-header">
                <h1>{{$title}}</h1>
            </div>
            <div class="col-md-12">
              @include('admin.search.shop')
            </div>
        </div>
        <!-- Pagination -->
        <div class="row text-center">
            <div class="col col-md-12">
                {!! $results->render() !!}
            </div>
        </div>
    </div>
@stop
