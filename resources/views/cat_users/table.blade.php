<div class="table-responsive">
    <table class="table" id="catUsers-table">
        <thead>
            <tr>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($catUsers as $catUser)
            <tr>
                <td>
                    <img src="{{ $catUser->avatar }}" id="catUser-table-avatar" style="width:100px;">
                </td>
                <td>{{ $catUser->name }}</td>
                <td>{{ $catUser->email }}</td>
                <td>{{ $catUser->password }}</td>
            
                <td>
                    {!! Form::open(['route' => ['catUsers.destroy', $catUser->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('catUsers.show', [$catUser->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('catUsers.edit', [$catUser->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
