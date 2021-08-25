@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center page-header">
                <h1>Edit news : {{$news->id}} </h1>
            </div>
            <div class="col-md-12">
                {!! Form::open() !!}

                <div class="form-group">
                    {!! Form::text('title', $news->title, ['placeholder' => "Title", 'class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::textarea('content', $news->text, ['placeholder' => "Your beautiful text", 'class' => 'form-control ckeditor', 'required' => 'required', 'rows' => 10, 'cols' => 40]) !!}
                </div>

                <input type="submit" class="btn btn-primary" value="Edit the news">

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
