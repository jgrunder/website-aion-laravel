@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-12 text-center page-header">
                <h1>Edit object</h1>
                <small>{{$item->name}}</small>
            </div>

            <!-- SUCCESS MESSAGE -->
            @if ($success)
                <div class="col col-md-6 col-md-offset-3 text-center">
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        {{$success}}
                    </div>
                </div>
            @endif

            <div class="col col-md-6 col-md-offset-3">
                {!! Form::open() !!}

                <div class="form-group">
                    {!! Form::label('id_item', "Item's ID") !!}
                    {!! Form::input('number', 'id_item', $item->id_item, ['class' => 'form-control', 'required' => 'required', 'id' => 'idItem']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('id_sub_category', "Name of the Sub-Category") !!}
                    {!! Form::select('id_sub_category', $categories, $item->id_sub_category, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('race', "For a specific race?") !!}
                    {!! Form::select('race', ['ALL' => 'ALL', 'ELYOS' => 'ELYOS', 'ASMODIANS' => 'ASMODIANS'], $item->race, ['class' => 'form-control', 'required' => 'required', 'id' => 'race']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('name', "Item's name") !!}
                    {!! Form::text('name', $item->name, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('price', "Price per unit") !!}
                    {!! Form::input('number', 'price', $item->price, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('quantity', "Quantity") !!}
                    {!! Form::input('number', 'quantity', $item->quantity, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                  {!! Form::label('preview', "Item's preview") !!}
                  {!! Form::select('preview', ['1' => 'Yes', '0' => 'No'], (string) $item->preview) !!}
                </div>

                @if(Config::get('aion.enable_account_level'))
                    <div class="form-group">
                        {!! Form::label('level', "Level") !!}
                        {!! Form::input('number', 'level', $item->level, ['placeholder' => "0", 'class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                @endif

                <input type="submit" class="btn btn-warning" value="Edit item">

                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
