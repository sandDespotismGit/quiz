<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: #df9f1f!important">
  <div class="container-fluid">
    <a class="navbar-brand" href="{{ route('home') }}">Главная</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
            <a class="nav-link" href="{{ route('course-list') }}">Продукция</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="course-list" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Список
          </a>
          <ul class="dropdown-menu" style="background-color: #eecd8a">
            <li><a class="dropdown-item" href="http://127.0.0.1:8000/admin">Администраторская панель</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
      </ul>
      <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Поиск</button>
      </form>
    </div>
  </div>
</nav>
