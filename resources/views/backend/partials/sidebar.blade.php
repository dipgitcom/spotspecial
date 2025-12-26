<!-- navbar vertical -->
<div class="app-menu">
    <div class="navbar-vertical navbar nav-dashboard">
        <div class="h-100" data-simplebar>
            <!-- Brand logo -->
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <img
                    src="{{ isset($admin_setting->logo) ? asset($admin_setting->logo) : asset('uploads/default.png') }}" />
            </a>
            <!-- Navbar nav -->
            <ul class="navbar-nav flex-column" id="sideNavbar">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        <i data-feather="bar-chart-2" class="nav-icon me-2 icon-xxs"></i>
                        Dashboard
                    </a>
                </li>




                {{-- <li class="nav-item {{ request()->is('chat*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('chat.index') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-message-circle-more-icon lucide-message-circle-more me-2 icon-xxs">
                            <path
                                d="M2.992 16.342a2 2 0 0 1 .094 1.167l-1.065 3.29a1 1 0 0 0 1.236 1.168l3.413-.998a2 2 0 0 1 1.099.092 10 10 0 1 0-4.777-4.719" />
                            <path d="M8 12h.01" />
                            <path d="M12 12h.01" />
                            <path d="M16 12h.01" />
                        </svg>
                        <span class="side-menu__label">Chatting System</span>
                    </a>
                </li> --}}



                <li class="nav-title" {{--
                    style="font-weight:700; letter-spacing:2px; font-size:10x; color:#222; background:#f8f9fa; border-radius:6px; margin:11px 0; padding:7px 0; text-align:center;">
                    Tag & Truck Management
                </li>
                <li class="nav-item {{ request()->routeIs('tag.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#tagManagementCollapse"
                        aria-expanded="{{ request()->routeIs('tag.*') ? 'true' : 'false' }}"
                        aria-controls="tagManagementCollapse">
                        <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                        Tag
                    </a>

                    <div id="tagManagementCollapse" class="collapse {{ request()->routeIs('tag.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">

                        <ul class="nav flex-column ms-3">

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('tag.*') ? 'active' : '' }}"
                                    href="{{ route('tag.index') }}">
                                    Tags
                                </a>
                            </li>


                        </ul>
                    </div>
                </li> --}}





                {{-- <li class="nav-item {{ request()->routeIs('truck_manage.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#truckManagementCollapse"
                        aria-expanded="{{ request()->routeIs('truck_manage.*') ? 'true' : 'false' }}"
                        aria-controls="truckManagementCollapse">
                        <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                        Truck
                    </a>

                    <div id="truckManagementCollapse"
                        class="collapse {{ request()->routeIs('truck_manage.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">

                        <ul class="nav flex-column ms-3">

                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('truck_manage.*') ? 'active' : '' }}"
                                    href="{{ route('truck_manage.index') }}">
                                    Truck Manage
                                </a>
                            </li>


                        </ul>
                    </div>
                </li> --}}




                <!-- Section title centered and bold -->
                <li class="nav-title"
                    style="font-weight:700; letter-spacing:2px; font-size:10x; color:#222; background:#f8f9fa; border-radius:6px; margin:11px 0; padding:7px 0; text-align:center;">
                    Site Section Management
                </li>
                {{-- <li class="nav-item {{ request()->routeIs('post_manage.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#postManagementCollapse"
                        aria-expanded="{{ request()->routeIs('post_manage.*') ? 'true' : 'false' }}"
                        aria-controls="postManagementCollapse">
                        <i data-feather="file-text" class="nav-icon me-2 icon-xxs"></i>
                        Post
                    </a>
                    <div id="postManagementCollapse"
                        class="collapse {{ request()->routeIs('post_manage.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('post_manage.index') ? 'active' : '' }}"
                                    href="{{ route('post_manage.index') }}">
                                    Posts
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                <li class="nav-item {{ request()->routeIs('admin.hero-section.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.hero-section.edit') }}">
                        <i data-feather="zap" class="nav-icon me-2 icon-xxs"></i>
                        Hero Section
                    </a>
                </li>


                <li class="nav-item {{ request()->routeIs('admin.navbar.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.navbar.index') }}">
                        <i data-feather="sliders" class="nav-icon me-2 icon-xxs"></i>
                        Navbar Management
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('admin.service-packages.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.service-packages.index') }}">
                        <i data-feather="package" class="nav-icon me-2 icon-xxs"></i>
                        Service Packages
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('why-us-panels.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('why-us-panels.index') }}">
                        <i data-feather="star" class="nav-icon me-2 icon-xxs"></i>
                        Why Us Panels
                    </a>
                </li>

                <li class="nav-item {{ request()->routeIs('process-steps.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('process-steps.index') }}">
                        <i data-feather="list" class="nav-icon me-2 icon-xxs"></i>
                        Process Steps
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('galleries.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('galleries.index') }}">
                        <i data-feather="image" class="nav-icon me-2 icon-xxs"></i>
                        Gallery
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('testimonials.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('testimonials.index') }}">
                        <i data-feather="message-circle" class="nav-icon me-2 icon-xxs"></i>
                        Testimonials
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('faqs.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('faqs.index') }}">
                        <i data-feather="help-circle" class="nav-icon me-2 icon-xxs"></i>
                        FAQs
                    </a>
                </li>

                <!-- Contact Dropdown in Sidebar -->
                <!-- Contact Section - Accordion/collapse style -->
                <li
                    class="nav-item {{ request()->routeIs('contact-section.*') || request()->routeIs('contact-submissions.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#contactSectionCollapse"
                        aria-expanded="{{ request()->routeIs('contact-section.*') || request()->routeIs('contact-submissions.*') ? 'true' : 'false' }}"
                        aria-controls="contactSectionCollapse">
                        <i data-feather="mail" class="nav-icon me-2 icon-xxs"></i>
                        Contact
                    </a>
                    <div id="contactSectionCollapse"
                        class="collapse {{ request()->routeIs('contact-section.*') || request()->routeIs('contact-submissions.*') ? 'show' : '' }}"
                        data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('contact-section.*') ? 'active' : '' }}"
                                    href="{{ route('contact-section.edit') }}">
                                    <i data-feather="settings" class="nav-icon me-2 icon-xxs"></i>
                                    Section Settings
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('contact-submissions.*') ? 'active' : '' }}"
                                    href="{{ route('contact-submissions.index') }}">
                                    <i data-feather="database" class="nav-icon me-2 icon-xxs"></i>
                                    Data
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ request()->routeIs('footer-settings.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('footer-settings.edit') }}">
                        <i data-feather="slash" class="nav-icon me-2 icon-xxs"></i>
                        Footer Settings
                    </a>
                </li>


                {{-- <li class="nav-item {{ request()->routeIs('admin.notification-settings.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('notification.settings.index') }}">
                        <i data-feather="bell" class="nav-icon me-2 icon-xxs"></i>
                        Notification Settings
                    </a>
                </li> --}}



                <!-- Sidebar report structure -->

                {{-- <li
                    class="nav-item {{ request()->routeIs('layouts.reports.*') || request()->routeIs('report_reason.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#reportsManagementCollapse"
                        aria-expanded="{{ request()->routeIs('layouts.reports.*') || request()->routeIs('report_reason.*') ? 'true' : 'false' }}"
                        aria-controls="reportsManagementCollapse">
                        <i data-feather="alert-triangle" class="nav-icon me-2 icon-xxs"></i>
                        Reports
                    </a>
                    <div id="reportsManagementCollapse"
                        class="collapse {{ request()->routeIs('layouts.reports.*') || request()->routeIs('report_reason.*') ? 'show' : '' }}"
                        data-bs-parent="#sideNavbar">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('layouts.reports.index') ? 'active' : '' }}"
                                    href="{{ route('layouts.reports.index') }}">
                                    <i data-feather="list" class="nav-icon me-2 icon-xxs"></i>
                                    Reports
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('report_reason.index') ? 'active' : '' }}"
                                    href="{{ route('report_reason.index') }}">
                                    <i data-feather="plus" class="nav-icon me-2 icon-xxs"></i>
                                    Report Reason Create
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}

                {{-- <li class="nav-item {{ request()->routeIs('feedback.*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('feedback.index') }}">
                        <i data-feather="message-square" class="nav-icon me-2 icon-xxs"></i>
                        Feedback
                    </a>
                </li> --}}










                <li class="nav-title"
                    style="font-weight:700; letter-spacing:2px; font-size:10x; color:#222; background:#f8f9fa; border-radius:6px; margin:11px 0; padding:7px 0; text-align:center;">
                    System Content Management
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dynamic-pages.index') }}">
                        <i class="bi bi-file-earmark-text fs-4 me-2"></i>
                        Dynamic Pages
                    </a>
                </li>

                {{-- User Management
                <li class="nav-item {{ request()->routeIs('product.*', 'category.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" href="#!" data-bs-toggle="collapse" data-bs-target="#productCollapse"
                        aria-expanded="{{ request()->routeIs('product.*', 'category.*') ? 'true' : 'false' }}"
                        aria-controls="productCollapse">
                        <i data-feather="box" class="nav-icon me-2 icon-xxs"></i>Customer Management
                    </a>
                    <div id="productCollapse"
                        class="collapse {{ request()->routeIs('product.*', 'category.*') ? 'show' : '' }}"
                        data-bs-parent="#productCollapse">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('product.index') ? 'active' : '' }}" href="">
                                    Customer List
                                </a>
                            </li>

                        </ul>
                    </div>
                </li> --}}


















                {{-- Role Management --}}
                <li class="nav-item {{ request()->routeIs('user.*', 'role.*', 'permission.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" data-bs-toggle="collapse" data-bs-target="#roleManagementCollapse"
                        aria-expanded="{{ request()->routeIs('users.*', 'roles.*', 'permissions.*') ? 'true' : 'false' }}"
                        aria-controls="roleManagementCollapse">
                        <i data-feather="shield" class="nav-icon me-2 icon-xxs"></i>
                        Role Management
                    </a>

                    <div id="roleManagementCollapse"
                        class="collapse {{ request()->routeIs('user.*', 'role.*', 'permission.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">

                        <ul class="nav flex-column ms-3">
                            {{-- Users --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}"
                                    href="{{ route('user.index') }}">
                                    Users
                                </a>
                            </li>

                            {{-- Roles --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('role.*') ? 'active' : '' }}"
                                    href="{{ route('role.index') }}">
                                    Roles
                                </a>
                            </li>

                            {{-- Permissions --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('permission.*') ? 'active' : '' }}"
                                    href="{{ route('permission.index') }}">
                                    Permissions
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>




                {{-- Settings --}}
                <li class="nav-title"
                    style="font-weight:700; letter-spacing:2px; font-size:10x; color:#222; background:#f8f9fa; border-radius:6px; margin:11px 0; padding:7px 0; text-align:center;">
                    System Settings
                </li>
                <li
                    class="nav-item {{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'active' : '' }}">
                    <a class="nav-link has-arrow" href="" data-bs-toggle="collapse" data-bs-target="#settingsCollapse"
                        aria-expanded="{{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'true' : 'false' }}"
                        aria-controls="settingsCollapse">
                        <i data-feather="settings" class="nav-icon me-2 icon-xxs"></i>Settings
                    </a>

                    <div id="settingsCollapse"
                        class="collapse {{ request()->routeIs('profile.*', 'mail.*', 'system.*', 'admin.*') ? 'show' : '' }}"
                        data-bs-parent="#sidebarMenu">
                        <ul class="nav flex-column ms-3">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('profile.index') ? 'active' : '' }}"
                                    href="{{ route('profile.index') }}">
                                    Profile Setting
                                </a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('system.index') ? 'active' : '' }}"
                                    href="{{ route('system.index') }}">
                                    Website Setting
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.setting.index') ? 'active' : '' }}"
                                    href="{{ route('admin.setting.index') }}">
                                    Admin Setting
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('mail.index') ? 'active' : '' }}"
                                    href="{{ route('mail.index') }}">
                                    Mail Setting
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Logout --}}
                {{-- <li class="nav-item">
                    <a class="nav-link" href="#"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i data-feather="log-out" class="nav-icon me-2 icon-xxs"></i>
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li> --}}
            </ul>

        </div>
    </div>
</div>