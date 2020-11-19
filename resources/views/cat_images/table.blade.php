<div class="table-responsive">
    <table class="table" id="catImages-table">
        <thead>
            <tr>
                <th>Image</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($catImages as $catImage)
            <tr>
                <td>{{ $catImage->image }}</td>
                <td>
                    {!! Form::open(['route' => ['catImages.destroy', $catImage->id], 'method' => 'delete']) !!}
                    <div class='btn-group'>
                        <a href="{{ route('catImages.show', [$catImage->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
                        <a href="{{ route('catImages.edit', [$catImage->id]) }}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
                        {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                    </div>
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
