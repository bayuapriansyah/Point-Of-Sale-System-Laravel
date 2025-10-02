<div class="dropdown">
    <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">
        {{ ucwords(Auth::user()->name) }}
    </button>
    <div class="dropdown-menu">
        <a class="dropdown-item" href="{{ route('users.change-password-form') }}">Ganti password</a>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="dropdown-item btn">Logout</button>
        </form>
    </div>
</div>