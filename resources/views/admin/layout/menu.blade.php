<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
    <li class="nav-item">
        <a href="{{ url('admin/home') }}" class="nav-link {{ !empty($menu) && $menu=="home"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Dashboard</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/category') }}" class="nav-link {{ !empty($menu) && $menu=="category"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Category</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/image') }}" class="nav-link {{ !empty($menu) && $menu=="image"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Images</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/user') }}" class="nav-link  {{ !empty($menu) && $menu=="user"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>User</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/setting') }}" class="nav-link  {{ !empty($menu) && $menu=="setting"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Settings</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ url('admin/privacy') }}" class="nav-link  {{ !empty($menu) && $menu=="privacy"?"active":"" }}">
            <i class="fas fa-circle nav-icon"></i>
            <p>Privacy</p>
        </a>
    </li>
    <li class="nav-item ">
        <a href="{{ url('admin/logout') }}" class="nav-link text-danger" >
            <i class="fas fa-sign-out-alt nav-icon"></i>
            <p>Logout</p>
        </a>
    </li>

</ul>