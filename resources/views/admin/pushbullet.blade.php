@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center page-header">
                <h1>PushBullet notification</h1>
            </div>

            <!-- Success -->
            @if($count)
                <div class="col col-md-4 col-md-offset-4 text-center">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        The notification was sent to {{$count}} @if($count == 0 || $count == 1) person @else people @endif.
                    </div>
                </div>
            @endif

            <!-- Add new image -->
            <div class="col-md-8 col-md-offset-2">
                {!! Form::open() !!}

                <div class="form-group">
                    {!! Form::text('title', null, ['placeholder' => "Title", 'class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::text('content', null, ['placeholder' => "Description ...", 'class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <input type="submit" class="btn btn-primary" value="Send">

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
