<form action="{{ $url }}" method="POST" onsubmit="return confirm('Confirm DELETE ?');">
    {{ csrf_field() }}
    {{ method_field('DELETE') }}

    <button type="submit" class="btn btn-danger btn-sm" title="Delete">
        Delete
    </button>
</form>