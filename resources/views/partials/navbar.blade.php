<nav class="navbar navbar-expand-lg navbar-dark bg-danger">
  <div class="container">
      <a class="navbar-brand" href="/">App</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
          aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            @if (Route::has('login'))
              @auth
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('karyawan') ? 'active' : '' }}"  href="/karyawan">Master Karyawan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('cuti') ? 'active' : '' }}"  href="/cuti">Master Cuti</a>
                </li>
              @endauth
            @endif
          </ul>

          <ul class="navbar-nav ms-auto">
              @if (Route::has('login'))
                @auth
                  <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Welcome back, {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li>
                          <form action="/logout" method="post">
                                @csrf
                              <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Logout</button>
                          </form>
                      </li>
                    </ul>
                  </li>
                @else
                <li class="nav-item">
                    <a href="/login" class="nav-link"><i class="bi bi-box-arrow-in-right"></i> Login</a>
                </li>
                @endauth
              @endif
            </ul>
          
      </div>
  </div>
</nav>