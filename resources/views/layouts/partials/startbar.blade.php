<div class="startbar d-print-none">
    <!--start brand-->
    <div class="brand">
        <a href="{{ route('any', 'home') }}" class="logo">
            <span>
                <img src="/images/kabelat3.png" alt="logo-small" class="logo-sm">
            </span>
        </a>
    </div>
    <!--end brand-->
    <!--start startbar-menu-->
    <div class="startbar-menu">
        <div class="startbar-collapse" id="startbarCollapse" data-simplebar>
            <div class="d-flex align-items-start flex-column w-100">
                <!-- Navigation -->
                <ul class="navbar-nav mb-auto w-100">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="iconoir-home-simple menu-icon"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('komunitas.members') ? 'active' : '' }}"
                            href="{{ route('second', ['Komunitas', 'komunitas']) }}">
                            <i class="iconoir-group menu-icon"></i>
                            <span>Member Komunitas</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('penduduk') }}">
                            <i class="iconoir-user-bag menu-icon"></i>
                            <span>Kelola User</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('kelolaKomunitas.create', 'detailStruktur') ? 'active' : '' }}" href="#sidebarKomunitas" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarKomunitas">
                            <i class="iconoir-community menu-icon"></i>
                            <span>Komunitas</span>
                        </a>
                        <div class="collapse {{ Route::is('kelolaKomunitas.create', 'detailStruktur') ? 'show' : '' }}" area id="sidebarKomunitas">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('kelolaKomunitas.create') ? 'active' : '' }}"
                                        href="{{ route('second', ['kelolaKomunitas', 'komunitas']) }}">Kelola
                                        Komunitas</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link {{ Route::is('detailStruktur') ? 'active' : '' }}" href="{{ route('kelolaStruktur') }}">Kelola
                                        Struktur</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  {{ Route::is('programDispusip.edit','programDispusip.create') ? 'active' : '' }}" href="{{ route('programDispusip') }}">
                            <i class="iconoir-calendar menu-icon"></i>
                            <span>Kelola Program Dispusip</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="">
                            <i class="iconoir-running menu-icon"></i>
                            <span>Kelola Kegiatan</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kategori.index') }}">
                            <i class="iconoir-activity menu-icon"></i>
                            <span>Kelola Kategori Kegiatan</span>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="#sidebarDashboards" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarDashboards">
                            <i class="iconoir-home-simple menu-icon"></i>
                            <span>Dashboards</span>
                        </a>
                        <div class="collapse " id="sidebarDashboards">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['dashboard', 'index'])}}">Analytics</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['dashboard', 'ecommerce-index'])}}">Ecommerce</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarDashboards-->
                    </li><!--end nav-item--> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarApplications" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarApplications">
                            <i class="iconoir-view-grid menu-icon"></i>
                            <span>Applications</span>
                        </a>
                        <div class="collapse " id="sidebarApplications">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="#sidebarAnalytics" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarAnalytics">
                                        <span>Analytics</span>
                                    </a>
                                    <div class="collapse " id="sidebarAnalytics">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a href="{{ route('second', ['application', 'analytics-customers']) }}"
                                                    class="nav-link ">Customers</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a href="{{ route('second', ['application', 'analytics-reports']) }}"
                                                    class="nav-link ">Reports</a>
                                            </li><!--end nav-item-->
                                        </ul><!--end nav-->
                                    </div>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="#sidebarProjects" data-bs-toggle="collapse" role="button"
                                        aria-expanded="false" aria-controls="sidebarProjects">
                                        <span>Projects</span>
                                    </a>
                                    <div class="collapse " id="sidebarProjects">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'projects', 'clients']) }}">Clients</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'projects', 'team']) }}">Team</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'projects', 'project']) }}">Project</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'projects', 'task']) }}">Task</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'projects', 'kanban-board']) }}">Kanban
                                                    Board</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'projects', 'users']) }}">Users</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'projects', 'create']) }}">Project
                                                    Create</a>
                                            </li><!--end nav-item-->
                                        </ul><!--end nav-->
                                    </div>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="#sidebarEcommerce" data-bs-toggle="collapse"
                                        role="button" aria-expanded="false" aria-controls="sidebarEcommerce">
                                        <span>Ecommerce</span>
                                    </a>
                                    <div class="collapse " id="sidebarEcommerce">
                                        <ul class="nav flex-column">
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'ecommerce', 'products']) }}">Products</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'ecommerce', 'customers']) }}">Customers</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'ecommerce', 'customer-details']) }}">Customer
                                                    Details</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'ecommerce', 'orders']) }}">Orders</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'ecommerce', 'order-details']) }}">Order
                                                    Details</a>
                                            </li><!--end nav-item-->
                                            <li class="nav-item">
                                                <a class="nav-link"
                                                    href="{{ route('third', ['application', 'ecommerce', 'refunds']) }}">Refunds</a>
                                            </li><!--end nav-item-->
                                        </ul><!--end nav-->
                                    </div>
                                </li><!--end nav-item-->

                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['application', 'chat']) }}">Chat</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['application', 'contact-list']) }}">Contact List</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['application', 'calendar']) }}">Calendar</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['application', 'invoice']) }}">Invoice</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarApplications-->
                    </li><!--end nav-item-->
                    <li class="menu-label mt-2">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>Components</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarElements" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarElements">
                            <i class="iconoir-compact-disc menu-icon"></i>
                            <span>UI Elements</span>
                        </a>
                        <div class="collapse " id="sidebarElements">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'alerts']) }}">Alerts</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'avatar']) }}">Avatar</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'buttons']) }}">Buttons</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'badges']) }}">Badges</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'cards']) }}">Cards</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['ui', 'carousels']) }}">Carousels</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['ui', 'dropdowns']) }}">Dropdowns</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'grids']) }}">Grids</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'images']) }}">Images</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'list']) }}">List</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'modals']) }}">Modals</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'navs']) }}">Navs</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'navbar']) }}">Navbar</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['ui', 'paginations']) }}">Paginations</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['ui', 'popover-tooltips']) }}">Popover &
                                        Tooltips</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'progress']) }}">Progress</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'spinners']) }}">Spinners</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'tabs-accordions']) }}">Tabs
                                        & Accordions</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['ui', 'typography']) }}">Typography</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['ui', 'videos']) }}">Videos</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarElements-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarAdvancedUI" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAdvancedUI">
                            <i class="iconoir-peace-hand menu-icon"></i>
                            <span>Advanced UI</span><span
                                class="badge rounded text-success bg-success-subtle ms-1">New</span>
                        </a>
                        <div class="collapse " id="sidebarAdvancedUI">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'animation']) }}">Animation</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'clipboard']) }}">Clip Board</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'dragula']) }}">Dragula</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'file-manager']) }}">File Manager</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'highlight']) }}">Highlight</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'rangeslider']) }}">Range Slider</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'ratings']) }}">Ratings</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'ribbons']) }}">Ribbons</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'sweetalerts']) }}">Sweet Alerts</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['advanced-ui', 'toasts']) }}">Toasts</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarAdvancedUI-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarForms" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarForms">
                            <i class="iconoir-journal-page menu-icon"></i>
                            <span>Forms</span>
                        </a>
                        <div class="collapse " id="sidebarForms">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['forms', 'elements']) }}">Basic
                                        Elements</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['forms', 'advanced']) }}">Advance
                                        Elements</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['forms', 'validation']) }}">Validation</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['forms', 'wizard']) }}">Wizard</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['forms', 'editors']) }}">Editors</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['forms', 'file-uploads']) }}">File
                                        Upload</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['forms', 'img-crop']) }}">Image
                                        Crop</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarForms-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarCharts" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarCharts">
                            <i class="iconoir-candlestick-chart menu-icon"></i>
                            <span>Charts</span>
                        </a>
                        <div class="collapse " id="sidebarCharts">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['charts', 'apex']) }}">Apex</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['charts', 'justgage']) }}">JustGage</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['charts', 'chartjs']) }}">Chartjs</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['charts', 'toast']) }}">Toast</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarCharts-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarTables" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarTables">
                            <i class="iconoir-table-rows menu-icon"></i>
                            <span>Tables</span>
                        </a>
                        <div class="collapse " id="sidebarTables">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['tables', 'basic']) }}">Basic</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['tables', 'datatable']) }}">Datatables</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarTables-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarIcons">
                            <i class="iconoir-trophy menu-icon"></i>
                            <span>Icons</span>
                        </a>
                        <div class="collapse " id="sidebarIcons">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['icons', 'fontawesome']) }}">Font
                                        Awesome</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['icons', 'lineawesome']) }}">Line
                                        Awesome</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['icons', 'icofont']) }}">Icofont</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['icons', 'iconoir']) }}">Iconoir</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarIcons-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarMaps" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarMaps">
                            <i class="iconoir-navigator-alt menu-icon"></i>
                            <span>Maps</span>
                        </a>
                        <div class="collapse " id="sidebarMaps">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['maps', 'google']) }}">Google
                                        Maps</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['maps', 'leaflet']) }}">Leaflet
                                        Maps</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['maps', 'vector']) }}">Vector
                                        Maps</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarMaps-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarEmailTemplates" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarEmailTemplates">
                            <i class="iconoir-send-mail menu-icon"></i>
                            <span>Email Templates</span>
                        </a>
                        <div class="collapse " id="sidebarEmailTemplates">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['email', 'template-basic']) }}">Basic Action
                                        Email</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['email', 'template-alert']) }}">Alert Email</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['email', 'template-billing']) }}">Billing Email</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarEmailTemplates-->
                    </li><!--end nav-item-->
                    <li class="menu-label mt-2">
                        <small class="label-border">
                            <div class="border_left hidden-xs"></div>
                            <div class="border_right"></div>
                        </small>
                        <span>Crafted</span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarPages" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarPages">
                            <i class="iconoir-page-star menu-icon"></i>
                            <span>Pages</span>
                        </a>
                        <div class="collapse " id="sidebarPages">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['pages', 'profile']) }}">Profile</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['pages', 'notifications']) }}">Notifications</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['pages', 'timeline']) }}">Timeline</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['pages', 'treeview']) }}">Treeview</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['pages', 'starter']) }}">Starter
                                        Page</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['pages', 'pricing']) }}">Pricing</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['pages', 'blogs']) }}">Blogs</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['pages', 'faqs']) }}">FAQs</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['pages', 'gallery']) }}">Gallery</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarPages-->
                    </li><!--end nav-item-->
                    <li class="nav-item">
                        <a class="nav-link" href="#sidebarAuthentication" data-bs-toggle="collapse" role="button"
                            aria-expanded="false" aria-controls="sidebarAuthentication">
                            <i class="iconoir-fingerprint-lock-circle menu-icon"></i>
                            <span>Authentication</span>
                        </a>
                        <div class="collapse " id="sidebarAuthentication">
                            <ul class="nav flex-column">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['auth', 'login']) }}">Log in</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['auth', 'register']) }}">Register</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['auth', 'recover-pw']) }}">Re-Password</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['auth', 'lock-screen']) }}">Lock
                                        Screen</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="{{ route('second', ['auth', 'maintenance']) }}">Maintenance</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['auth', 'error-404']) }}">Error
                                        404</a>
                                </li><!--end nav-item-->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('second', ['auth', 'error-500']) }}">Error
                                        500</a>
                                </li><!--end nav-item-->
                            </ul><!--end nav-->
                        </div><!--end startbarAuthentication-->
                    </li><!--end nav-item-->
                </ul><!--end navbar-nav--->
                <div class="update-msg text-center">
                    <div
                        class="d-flex justify-content-center align-items-center thumb-lg update-icon-box  rounded-circle mx-auto">
                        <i class="iconoir-peace-hand h3 align-self-center mb-0 text-primary"></i>
                    </div>
                    <h5 class="mt-3">Mannat Themes</h5>
                    <p class="mb-3 text-muted">Rizz is a high quality web applications.</p>
                    <a href="javascript: void(0);" class="btn text-primary shadow-sm rounded-pill">Upgrade your
                        plan</a>
                </div>
            </div>
        </div><!--end startbar-collapse-->
    </div><!--end startbar-menu-->
</div><!--end startbar-->
<div class="startbar-overlay d-print-none"></div>
