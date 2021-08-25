<table class="table">
    <thead>
    <tr>
        <th>Name</th>
        <th>Account ID</th>
        <th>Account Name</th>
        <th>Race</th>
        <th>Classe</th>
        <th class="text-center">Online ?</th>
    </tr>
    </thead>
    <tbody>
    @foreach($results as $result)
        <tr>
            <td>{{$result->name}}</td>
            <td>{{$result->account_id}}</td>
            <td>{{$result->account_name}}</td>
            <td>{{$result->race}}</td>
            <td>{{$result->player_class}}</td>
            <td class="text-center"> @if($result->online == 1) Yes @else No @endif </td>
        </tr>
    @endforeach
    </tbody>
</table>