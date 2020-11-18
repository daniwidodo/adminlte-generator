
<li class="{{ Request::is('users*') ? 'active' : '' }}">
    <a href="{!! route('users.index') !!}"><i class="fa fa-user"></i><span>Users</span></a>
</li>
<li class="{{ Request::is('catUsers*') ? 'active' : '' }}">
    <a href="{{ route('catUsers.index') }}"><i class="fa fa-edit"></i><span>Cat Users</span></a>
</li>

