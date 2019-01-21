<a class="nav-link btn btn-link" href="{{ route('docblog::logout') }}"
   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
    Logout
</a>

<form id="logout-form" action="{{ route('docblog::logout') }}" method="POST" style="display: one;">
    {{ csrf_field() }}
</form>