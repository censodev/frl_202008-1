<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  @include('frontend.includes.head')
  <body>
    @if( !empty( $scripts->script_body ) )
      {!! $scripts->script_body !!}
    @endif

    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->

    <!-- Main Body Area Start Here -->
    <div id="wrapper" class="wrapper">
      <!-- Main Header-->
      @include('frontend.includes.header_landing')
      <!--End Main Header -->

      <!-- Contains page content -->
        @yield('content')
      <!-- End Contains page content -->

      <!-- Main Footer -->
      @include('frontend.includes.footer')
      <!-- End Main Footer -->

    </div>
    <!--end wrapper -->

    <!-- Script -->
    @include('frontend.includes.jquery')
    <!-- End Script -->

    <!-- Social -->
    @include('frontend.includes.social')
    <!-- End Social -->

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
