<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ env('APP_NAME') }}</title>
  <link rel="icon" type="image/x-icon" href="{{ url('/images/ebidmo.png') }}">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
  <script
      src="https://code.jquery.com/jquery-3.7.1.min.js"
      integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
      crossorigin="anonymous"></script>
  <meta name="_token" content="{{ csrf_token() }}">
  <script>
    $(function() {
  $.ajaxSetup({
    headers: {
      'X-CSRF-Token': $('meta[name="_token"]').attr('content')
    }
  });
});
    </script> 
</head>
<body>
    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
        <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fw-bold" href="#"><img class="rounded" style="height:32px; width:32px;" src="{{ url('/images/ebidmo.png') }}" alt=""> eBidmo</a>
        <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav">
            <div class="nav-item text-nowrap">
                <a class="nav-link px-3" href="{{ url('/ebidmo-admin/logout') }}">Sign out</a>
            </div>
        </div>
    </header>
      
      <div class="container-fluid">
        <div class="row">
          <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
              <ul class="nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" aria-current="page" href="/ebidmo-admin"><span data-feather="home"></span> Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/ebidmo-admin/customers"><span data-feather="home"></span> Customers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/ebidmo-admin/vendors"><span data-feather="home"></span> Vendors</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/ebidmo-admin/products"><span data-feather="home"></span> Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/ebidmo-admin/transactions"><span data-feather="home"></span> Transactions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="/ebidmo-admin/auctions"><span data-feather="home"></span> Auctions</a>
                </li>
              </ul>
            </div>
          </nav>
      
          <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
              <h1 class="h2">{{ $page['name'] }}</h1>
              {{-- <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2">
                  <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                  <button type="button" class="btn btn-sm btn-outline-secondary">Code</button>
                </div>
              </div> --}}
            </div>
                @include('alert/message')
                @yield('content')
            </div>
          </main>
        </div>
      </div>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>