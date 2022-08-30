<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('admin.main.index') }}" class="nav-link @if(Route::is('admin.main.*')) active @endif">
        <i class="fa fa-house-user"></i>
        <p>Главная</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('admin.news.index') }}" class="nav-link @if(Route::is('admin.news.*')) active @endif">
        <i class="fa fa-newspaper"></i>
        <p>Новости</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.team.index') }}" class="nav-link @if(Route::is('admin.team.*')) active @endif">
        <i class="fa fa-users"></i>
        <p>Команда</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.clients.index') }}" class="nav-link @if(Route::is('admin.clients.*')) active @endif">
        <i class="fa fa-handshake"></i>
        <p>Клиенты</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.contacts.index') }}" class="nav-link @if(Route::is('admin.contacts.*')) active @endif">
        <i class="fa fa-address-book"></i>
        <p>Контакты</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.partners.index') }}" class="nav-link @if(Route::is('admin.partners.*')) active @endif">
        <i class="fa fa-user-tie"></i>
        <p>Партнёры</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.patronages.index') }}" class="nav-link @if(Route::is('admin.patronages.*')) active @endif">
        <i class="fa fa-coins"></i>
        <p>Меценаты</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.careers.index') }}" class="nav-link @if(Route::is('admin.careers.*')) active @endif">
        <i class="fa fa-chart-line"></i>
        <p>Карьера</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.about.index') }}" class="nav-link @if(Route::is('admin.about.*')) active @endif">
        <i class="fa fa-address-card"></i>
        <p>О нас</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.favours.index') }}" class="nav-link @if(Route::is('admin.favours.*')) active @endif">
        <i class="fa fa-gear"></i>
        <p>Услуги</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.footer.index') }}" class="nav-link @if(Route::is('admin.footer.*')) active @endif">
        <i class="fa fa-arrow-down"></i>
        <p>Футер</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('admin.whales.index') }}" class="nav-link @if(Route::is('admin.whales.*')) active @endif">
        <img src="/img/whale.png" alt="">
        <p>Каталог анимированных китов</p>
    </a>
</li>
