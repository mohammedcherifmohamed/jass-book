<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link rel="icon" type="image/png" href="{{ asset('storage/logo/logo.webp') }}">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'لوحة التحكم') - jass.books</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;900&display=swap" rel="stylesheet">
    <style>
        :root { --crimson: #800020; --deep: #5a0016; --gold: #c8a84b; --gold-light: #e8d5a3; --warm-gray: #8b7d6b; --ink: #241b0c; --parchment: #faf6f0; }
        body { font-family: 'Cairo', sans-serif; background: #f5f0e8; color: var(--ink); }
        .sidebar { background: var(--deep); min-height: 100vh; color: #fff; }
        .sidebar a { color: var(--gold-light); text-decoration: none; padding: 12px 20px; display: block; transition: all .2s; border-right: 3px solid transparent; font-size: 14px; font-weight: 600; }
        .sidebar a:hover, .sidebar a.active { background: rgba(200,168,75,.12); color: #fff; border-right-color: var(--gold); }
        .sidebar .brand { padding: 20px; font-size: 20px; font-weight: 800; border-bottom: 1px solid rgba(255,255,255,.1); text-align: center; letter-spacing: 1px; }
        .content { padding: 28px; min-height: 100vh; }
        .card { border: none; border-radius: 14px; box-shadow: 0 1px 4px rgba(36,27,12,.06), 0 4px 20px rgba(36,27,12,.04); background: #fff; }
        .card-header { background: #fff; border-bottom: 1px solid #eee; padding: 18px 24px; font-weight: 700; font-size: 16px; border-radius: 14px 14px 0 0 !important; }
        .card-body { padding: 24px; }
        .btn-crimson { background: var(--crimson); color: #fff; border: none; padding: 8px 20px; border-radius: 8px; font-weight: 700; transition: all .2s; }
        .btn-crimson:hover { background: var(--deep); color: #fff; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(90,0,22,.25); }
        .btn-gold { background: var(--gold); color: var(--ink); border: none; padding: 6px 14px; border-radius: 8px; font-weight: 700; transition: all .2s; }
        .btn-gold:hover { background: var(--gold-light); color: var(--ink); }
        .btn-sm { padding: 4px 10px; font-size: 13px; border-radius: 6px; }
        .table { margin-bottom: 0; }
        .table th { border-top: none; color: var(--deep); font-weight: 700; font-size: 13px; text-transform: uppercase; letter-spacing: .3px; background: #faf6f0; }
        .table td { vertical-align: middle; font-size: 14px; }
        .table tr:last-child td { border-bottom: none; }
        .table-hover tbody tr:hover { background: rgba(128,0,32,.03); }
        .alert { border-radius: 12px; border: none; }
        .pagination { justify-content: center; margin-top: 20px; }
        .pagination svg { width: 1.25rem; height: 1.25rem; }
        .page-item.active .page-link { background: var(--crimson); border-color: var(--crimson); box-shadow: 0 2px 8px rgba(128,0,32,.3); }
        .page-link { color: var(--crimson); border-radius: 8px !important; margin: 0 2px; border: none; font-weight: 600; padding: 8px 14px; }
        .page-link:hover { background: var(--gold-light); color: var(--deep); }
        img.thumb { width: 56px; height: 76px; object-fit: cover; border-radius: 6px; box-shadow: 0 2px 6px rgba(0,0,0,.1); }
        .form-control, .form-select { border-radius: 8px; border: 1.5px solid #e0d8cc; padding: 10px 14px; font-size: 14px; transition: border-color .2s, box-shadow .2s; }
        .form-control:focus, .form-select:focus { border-color: var(--gold); box-shadow: 0 0 0 3px rgba(200,168,75,.15); }
        .form-label { font-weight: 700; font-size: 14px; color: var(--ink); margin-bottom: 6px; }
        .form-check-input:checked { background-color: var(--crimson); border-color: var(--crimson); }
        .badge { font-size: 12px; padding: 4px 12px; border-radius: 20px; font-weight: 700; }
        .text-muted { color: var(--warm-gray) !important; }
        .mobile-topbar { display: none; background: var(--deep); padding: 12px 16px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 1030; }
        .mobile-topbar .brand { color: #fff; font-size: 18px; font-weight: 800; }
        .mobile-topbar .hamburger { background: none; border: none; color: var(--gold-light); font-size: 24px; cursor: pointer; padding: 4px 8px; border-radius: 6px; transition: background .2s; }
        .mobile-topbar .hamburger:hover { background: rgba(255,255,255,.08); }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1040; }
        .sidebar-overlay.show { display: block; }
        .table-responsive { border-radius: 0; }
        @media (max-width: 767px) {
            .sidebar { position: fixed; top: 0; right: -280px; width: 260px; z-index: 1050; transition: right .3s ease; min-height: 100vh; box-shadow: -4px 0 20px rgba(0,0,0,.2); }
            .sidebar.open { right: 0; }
            .mobile-topbar { display: flex; }
            .content { padding: 16px; }
            .card-body { padding: 16px; }
        }
    </style>
</head>
<body>
    <div class="mobile-topbar">
        <span class="brand">jass.books</span>
        <button class="hamburger" onclick="toggleSidebar()" aria-label="القائمة">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-0 desktop-sidebar" id="adminSidebar">
                <div class="brand">jass.books</div>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fas fa-tags ms-2"></i> التصنيفات
                </a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fas fa-book ms-2"></i> المنتجات
                </a>
                <a href="{{ route('home') }}" target="_blank">
                    <i class="fas fa-external-link-alt ms-2"></i> عرض الموقع
                </a>
                <hr style="border-color:rgba(255,255,255,.1);margin:10px 20px;">
                <div style="padding:10px 20px;font-size:12px;color:rgba(255,255,255,.4);">
                    {{ Auth::user()->email }}
                </div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" style="background:none;border:none;color:var(--gold-light);padding:10px 20px;display:block;width:100%;text-align:right;font-family:'Cairo',sans-serif;font-size:14px;cursor:pointer;transition:all .2s;" onmouseover="this.style.color='#fff'" onmouseout="this.style.color=''">
                        <i class="fas fa-sign-out-alt ms-2"></i> تسجيل الخروج
                    </button>
                </form>
            </div>
            <div class="col-md-10 content">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
                    </div>
                @endif
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function toggleSidebar() {
        document.getElementById('adminSidebar').classList.toggle('open');
        document.getElementById('sidebarOverlay').classList.toggle('show');
    }
    </script>
</body>
</html>
