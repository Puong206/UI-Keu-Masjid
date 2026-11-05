<header class="admin-topbar {{ ($solid ?? false) ? 'admin-topbar--solid' : '' }}">
    <strong>{{ $title }}</strong>
    <div class="admin-topbar__right">
        <button type="button" class="admin-bell" aria-label="Notifikasi"><svg class="ic"><use href="#i-bell"/></svg><i></i></button>
        <span class="admin-avatar">SA</span>
    </div>
</header>
