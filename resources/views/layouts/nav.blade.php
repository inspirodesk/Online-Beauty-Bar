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
        <li class='nav-item nav-hasmenu {{ Request::is("newses/*") || Request::is("categories/*") || Request::is("sites/*") ? "active nav-provoke" : "" }}'>
           <a href="#!" class='nav-link {{ Request::is("newses/*") || Request::is("categories/*") || Request::is("sites/*")  ? "active" : "" }} '>
             <span class="nav-icon">
               <i class="ti ti-layout-2"></i>
             </span>
             <span class="nav-text">Newses</span>
             <span class="nav-arrow">
               <i data-feather="chevron-right"></i>
             </span>
           </a>
           <ul class="nav-submenu">
             @canany(['create-news', 'edit-news', 'delete-news'])
             <li class='nav-item {{ Request::is("newses") || Request::is("newses/*/edit") ? "active nav-provoke" : "" }}'>
               <a class="nav-link " href="{{ url('newses') }}">All News</a>

             </li>
             @endcanany
             @canany(['create-news', 'edit-news', 'delete-news'])
             <li class="nav-item {{ Request::is('newses/create') ? 'active nav-provoke' : '' }}">
               <a class="nav-link" href="{{ url('newses/create') }}">Add New</a>
             </li>
             @endcanany
             @canany(['create-site', 'edit-site', 'delete-site'])
             <li class="nav-item {{ Request::is('sites/*') ? 'active nav-provoke' : '' }}">
               <a class="nav-link" href="{{ url('sites') }}">Sites</a>
             </li>
             @endcanany
             @canany(['create-category', 'edit-category', 'delete-category'])
             <li class="nav-item {{ Request::is('categories/*')  ? 'active nav-provoke' : '' }}">
               <a class="nav-link" href="{{ url('categories') }}">Categories</a>
             </li>
             @endcanany
           </ul>
        </li>
        <li class="nav-item nav-hasmenu {{ Request::is('obituaries') || Request::is('obituaries/*')  ? 'active nav-provoke' : '' }}">
           <a href="#!" class="nav-link {{ Request::is('obituaries') || Request::is('obituaries/*')  ? 'active' : '' }}">
             <span class="nav-icon">
               <i class="ti ti-layout-2"></i>
             </span>
             <span class="nav-text">Obituaries</span>
             <span class="nav-arrow">
               <i data-feather="chevron-right"></i>
             </span>
           </a>
           <ul class="nav-submenu">
             @canany(['create-obituary', 'edit-obituary', 'delete-obituary'])
             <li class="nav-item {{ Request::is('obituaries') || Request::is('obituaries/*/edit') ? 'active nav-provoke' : '' }}">
               <a class="nav-link " href="{{ url('obituaries') }}">All Obituary</a>
             </li>
             @endcanany
             @canany(['create-obituary', 'edit-obituary', 'delete-obituary'])
             <li class="nav-item {{ Request::is('obituaries/create') ? 'active nav-provoke' : '' }}">
               <a class="nav-link" href="{{ url('obituaries/create') }}">Add New</a>
             </li>
             @endcanany
           </ul>
        </li>
        <li class="nav-item nav-hasmenu {{ Request::is('rememberences') || Request::is('rememberences/*')  ? 'active nav-provoke' : '' }}">
           <a href="#!" class="nav-link {{ Request::is('rememberences') || Request::is('rememberences/*')  ? 'active' : '' }}">
             <span class="nav-icon">
               <i class="ti ti-layout-2"></i>
             </span>
             <span class="nav-text">Remembrances</span>
             <span class="nav-arrow">
               <i data-feather="chevron-right"></i>
             </span>
           </a>
           <ul class="nav-submenu">
             @canany(['create-rememberence', 'edit-rememberence', 'delete-rememberence'])
             <li class="nav-item {{ Request::is('/rememberences') || Request::is('rememberences/*/edit') ? 'active nav-provoke' : '' }}">
               <a class="nav-link " href="{{ url('/rememberences') }}">All Remembrance</a>
             </li>
             @endcanany
             @canany(['create-rememberence', 'edit-rememberence', 'delete-rememberence'])
             <li class="nav-item {{ Request::is('/rememberences/create') ? 'active nav-provoke' : '' }}">
               <a class="nav-link" href="{{ url('/rememberences/create') }}">Add New</a>
             </li>
             @endcanany
           </ul>
        </li>
        <li class="nav-item nav-hasmenu {{ Request::is('advertisements') || Request::is('advertisements/*')  ? 'active nav-provoke' : '' }}">
           <a href="#!" class="nav-link {{ Request::is('advertisements') || Request::is('advertisements/*')  ? 'active' : '' }}">
             <span class="nav-icon">
               <i class="ti ti-layout-2"></i>
             </span>
             <span class="nav-text">Advertisements</span>
             <span class="nav-arrow">
               <i data-feather="chevron-right"></i>
             </span>
           </a>
           <ul class="nav-submenu">
             @canany(['create-advertisement', 'edit-advertisement', 'delete-advertisement'])
             <li class="nav-item {{ Request::is('advertisements') || Request::is('advertisements/*/edit') ? 'active nav-provoke' : '' }}">
               <a class="nav-link " href="{{ url('advertisements') }}">All Advertisement</a>
             </li>
             @endcanany
             @canany(['create-advertisement', 'edit-advertisement', 'delete-advertisement'])
             <li class="nav-item {{ Request::is('advertisements/create') ? 'active nav-provoke' : '' }}">
               <a class="nav-link" href="{{ url('advertisements/create') }}">Add New</a>
             </li>
             @endcanany
           </ul>
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
            <a href="/pages" class="nav-link"><span class="nav-icon"><i class="ti ti-layout-2"></i></span><span class="nav-text">Pages</span></a>
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
