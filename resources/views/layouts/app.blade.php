<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>COPOMEX Test</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet"
        href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>
<body class="bg-light">
  <nav class="navbar navbar-dark bg-dark">
    <span class="navbar-brand">Prueba Técnica: Estados & Municipios</span>
    <form method="POST" action="{{ route('estados.sync') }}">
      @csrf
      <button class="btn btn-sm btn-outline-light">Sincronizar Estados</button>
    </form>
  </nav>

  <div class="container py-4">
    @yield('content')
  </div>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
  @stack('scripts')
</body>
</html>
