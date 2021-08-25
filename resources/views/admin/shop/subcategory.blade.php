@extends('_layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col col-md-12 text-center page-header">
                <h1>Sub-categories list</h1>
            </div>
            <div class="col col-md-4 col-md-offset-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th class="text-center">Catégorie</th>
                        <th class="text-center">Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($subCategories as $subCategory)
                        <tr>
                            <th scope="row">{{$subCategory->id}}</th>
                            <th class="text-center">
                              <a href="{{Route('admin.shop.category.items', $subCategory->category->id)}}">
                                {{$subCategory->category->category_name}}
                              </a>
                            </th>
                            <td class="text-center">
                              <a href="{{Route('admin.shop.subcategory.items', $subCategory->id)}}">
                                {{$subCategory->name}}
                              </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 col-md-offset-4 text-center">

                {!! Form::open(['class' => 'form-inline']) !!}


                <div class="form-group">
                    {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <div class="form-group">
                    {!! Form::text('sub_category_name', null, ['placeholder' => "Title", 'class' => 'form-control', 'required' => 'required']) !!}
                </div>

                <br> <br>

                <button type="submit" class="btn btn-primary">Add Sub-category</button>


                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop
