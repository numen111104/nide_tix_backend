<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Wisata Numen</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="instagram.com/numen_18">NW</a>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('users*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('users.index') }}">Users</a>
                    </li>
                    <li class="{{ Request::is('tourist-destinations*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tourist-destinations.index') }}">Tourist Destinations</a>
                    </li>
                    <li class="{{ Request::is('tickets*') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('tickets.index') }}">Tickets</a>
                    </li>
                </ul>
            </li>
        </ul>
    </aside>
</div>
