 <!-- { navigation menu } start -->
 <aside class="app-sidebar app-light-sidebar">
   <div class="app-navbar-wrapper">
     <div class="brand-link brand-logo">
       <a href="#" class="b-brand">
        @if(!empty($setting->logo) && file_exists(public_path('storage/' . $setting->logo)))
        <img src="{{ asset('storage/' . $setting->logo) }}" alt="" class="logo logo-lg" style="background-color: {{ $setting->logo_color }};">
        @else
            <img src="{{ asset('https://raw.githubusercontent.com/abisanthm/abisanthm.github.io/main2/1.png') }}" alt="Default Image" class="logo logo-lg" style="background-color: {{ $setting->logo_color }};">
        @endif
       </a>
     </div>
     <div class="navbar-content">
       <ul class="app-navbar">
         <li class="nav-item">
            <a href="/" class="nav-link"><span class="nav-icon"><i class="ti ti-layout-2"></i></span><span class="nav-text">Dashboard</span></a>
         </li>
         <li class="nav-item">
            <a href="/notes" class="nav-link"><span class="nav-icon"><i class="ti ti-layout-2"></i></span><span class="nav-text">Quick Orders</span></a>
        </li>
        <li class='nav-item nav-hasmenu {{ Request::is("sales/*")  ? "active nav-provoke" : "" }}'>
           <a href="#!" class='nav-link {{ Request::is("sales/*")  ? "active" : "" }} '>
             <span class="nav-icon">
               <i class="ti ti-layout-2"></i>
             </span>
             <span class="nav-text">Sales</span>
             <span class="nav-arrow">
               <i data-feather="chevron-right"></i>
             </span>
           </a>
           <ul class="nav-submenu">
             {{-- @canany(['create-news', 'edit-news', 'delete-news']) --}}
             <li class='nav-item {{ Request::is("sales/create") || Request::is("sales/create") ? "active nav-provoke" : "" }}'>
               <a class="nav-link " href="{{ url('sales/create') }}">Add Sale</a>
             </li>
             {{-- @endcanany --}}
             {{-- @canany(['create-news', 'edit-news', 'delete-news']) --}}
             <li class='nav-item {{ Request::is("sales") || Request::is("sales") ? "active nav-provoke" : "" }}'>
                <a class="nav-link " href="{{ url('sales') }}">All Sales</a>
              </li>
              {{-- @endcanany --}}
           </ul>
        </li>
        <li class='nav-item nav-hasmenu {{ Request::is("orders/*")  ? "active nav-provoke" : "" }}'>
            <a href="#!" class='nav-link {{ Request::is("orders/*")  ? "active" : "" }} '>
              <span class="nav-icon">
                <i class="ti ti-layout-2"></i>
              </span>
              <span class="nav-text">Woo Orders</span>
              <span class="nav-arrow">
                <i data-feather="chevron-right"></i>
              </span>
            </a>
            <ul class="nav-submenu">
              <li class='nav-item {{ Request::is("orders") ? "active nav-provoke" : "" }}'>
                <a class="nav-link " href="{{ url('orders') }}">All Orders</a>
              </li>
                <li class="nav-item {{ Request::is('orders/status/pending') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('orders.byStatus', 'pending') }}">Pending Orders</a>
                </li>
                <li class="nav-item {{ Request::is('orders/status/on-hold') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('orders.byStatus', 'on-hold') }}">On-Hold Orders</a>
                </li>
                <li class="nav-item {{ Request::is('orders/status/processing') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('orders.byStatus', 'processing') }}">Processing Orders</a>
                </li>
                <li class="nav-item {{ Request::is('orders/status/completed') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('orders.byStatus', 'completed') }}">Completed Orders</a>
                </li>
                <li class="nav-item {{ Request::is('orders/status/cancelled') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('orders.byStatus', 'cancelled') }}">Cancelled Orders</a>
                </li>
            </ul>
         </li>
        <li class="nav-item">
            <a href="/prints" target="_blank" class="nav-link"><span class="nav-icon"><i class="ti ti-layout-2"></i></span><span class="nav-text">Prints</span></a>
        </li>
        <li class="nav-item nav-hasmenu {{ Request::is('roles/*') || Request::is('users/*')  ? 'active nav-provoke' : '' }}">
           <a href="#!" class="nav-link {{ Request::is('roles') || Request::is('users')  ? 'active' : '' }}">
             <span class="nav-icon">
               <i class="ti ti-layout-2"></i>
             </span>
             <span class="nav-text">Users</span>
             <span class="nav-arrow">
               <i data-feather="chevron-right"></i>
             </span>
           </a>
           <ul class="nav-submenu">
             @canany(['create-user', 'edit-user', 'delete-user'])
             <li class="nav-item {{ Request::is('users/*')  ? 'active nav-provoke' : '' }}">
               <a class="nav-link " href="{{ url('users') }}">Users</a>
             </li>
             @endcanany
             @canany(['create-role', 'edit-role', 'delete-role'])
             <li class="nav-item {{ Request::is('roles/*')  ? 'active nav-provoke' : '' }}">
               <a class="nav-link" href="{{ url('roles') }}">Roles</a>
             </li>
             @endcanany
           </ul>
         </li>
         <li class="nav-item nav-hasmenu">
           <a href="#!" class="nav-link">
             <span class="nav-icon">
               <i class="ti ti-layout-2"></i>
             </span>
             <span class="nav-text">Settings</span>
             <span class="nav-arrow">
               <i data-feather="chevron-right"></i>
             </span>
           </a>
           <ul class="nav-submenu">
             <li class="nav-item">
               <a class="nav-link" href="{{ url('/settings') }}">Genarel Setting</a>
             </li>
             <li class="nav-item">
               <a class="nav-link" href="{{ url('/api') }}">REST API</a>
             </li>
           </ul>
         </li>
         <li class="nav-item">
           <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
             <span class="nav-icon">
               <i class="ti ti-layout-2"></i>
             </span>
             <span class="nav-text">Logout</span>
             <span class="nav-arrow">
               </i>
             </span>
           </a>
           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
         </li>
       </ul>
     </div>
   </div>
 </aside>
 <!-- { navigation menu } end -->
