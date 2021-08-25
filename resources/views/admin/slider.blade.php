@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center page-header">
                <h1>Slider's images</h1>
            </div>

            <!-- Liste des images -->
            <div class="col-md-8 col-md-offset-2">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Path</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($slider as $image)
                        <tr>
                            <th scope="row" class="text-center">{{$image->id}}</th>
                            <td class="text-center">{{$image->title}}</td>
                            <td class="text-center">{{$image->path}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Add new image -->
            <div class="col-md-8 col-md-offset-2">
                {!! Form::open(['files'=>true]) !!}

                <div class="form-group">
                    {!! Form::text('title', null, ['placeholder' => "Title", 'class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::file('path') !!}
                </div>

                <input type="submit" class="btn btn-primary" value="Add">

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
