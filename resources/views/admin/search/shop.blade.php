<table class="table">
    <thead>
    <tr>
        <th>#</th>
        <th>Category</th>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Number of purchase</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $result)
        <tr>
            <th scope="row">{{$result->id_item}}</th>
            <td>
              <a href="{{Route('admin.shop.category.items', $result->sub->category->id)}}">
                {{$result->sub->category->category_name}}
              </a> /
              <a href="{{Route('admin.shop.subcategory.items', $result->sub->id)}}">
                {{$result->sub->name}}
              </a>
            </td>
            <td>
                <a href="http://aiondatabase.net/en/item/{{$result->id_item}}" target="_blank">{{$result->name}}</a>
            </td>
            <td>{{$result->quantity}}</td>
            <td>{{$result->price}}</td>
            <td>{{$result->purchased}}</td>
            <td>
                <a class="btn btn-warning btn-xs" href="{{Route('admin.shop.edit', $result->id_item)}}">
                    <i class="fa fa-pencil-square-o"></i> Edit
                </a>
                <a class="btn btn-danger btn-xs" href="{{Route('admin.shop.delete', $result->id_item)}}">
                    <i class="fa fa-trash"></i> Delete
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>