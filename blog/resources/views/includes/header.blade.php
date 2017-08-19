<header>
    <nav class="main-nav">
        <ul>
            <li><a href="{{route('blog.index')}}">Blog</a></li>
            <li><a href="{{route('about')}}">About me</a></li>
            <li><a href="{{route('contact')}}">Contact</a></li>
            @if(!Auth::check())
                <li><a href="{{route('admin.login')}}">Login</a></li>
            @endif
        </ul>
    </nav>
</header>