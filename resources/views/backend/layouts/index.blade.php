<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  @include('backend.includes.head')
  <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">

      <!-- Navbar -->
      @include('backend.includes.header')
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      @include('backend.includes.sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">

        @yield('content')

      </div>
      <!-- /.content-wrapper -->
      @include('backend.includes.footer')

      <!-- Control Sidebar -->
      <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
      </aside>
      <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('backend.includes.modal')

    @include('backend.includes.jquery')

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
      @csrf
    </form>

    @if( session('message') )
      <script type="text/javascript">
        messageSuccess('{{ session('message') }}', 5000);
      </script>
    @endif
    @if( session('error') )
      <script type="text/javascript">
        messageError('{{ session('error') }}', 5000);
      </script>
    @endif
  </body>
</html>