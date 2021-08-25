@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center page-header">
                <h1>Add Points's Shop</h1>
            </div>

            <!-- ERROR MESSAGE -->
            @if ($errors)
                <div class="col col-md-4 col-md-offset-4 text-center">
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{$errors}}
                    </div>
                </div>
            @endif

            <!-- SUCCESS MESSAGE -->
            @if ($success)
                <div class="col col-md-4 col-md-offset-4 text-center">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{$success}}
                    </div>
                </div>
            @endif

            <div class="col-md-4 col-md-offset-4 text-center">
                {!! Form::open() !!}

                <div class="form-group">
                    {!! Form::text('account_name', null, ['placeholder' => "Account name", 'class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::text('reason', null, ['placeholder' => "Reason", 'class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::input('number', 'points', null, ['placeholder' => 50, 'class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <input type="submit" class="btn btn-primary" value="Add shop Points">

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
