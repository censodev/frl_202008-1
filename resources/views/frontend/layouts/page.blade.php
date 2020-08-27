<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  @include('frontend.includes.head')
  <body class="page-site">

  <div id="fb-root"></div>
  <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v8.0&appId=192981648374769&autoLogAppEvents=1" nonce="DmliMxmJ"></script>

  @if( !empty( $scripts->script_body ) )
      {!! $scripts->script_body !!}
    @endif

    <!-- Main Body Area Start Here -->
    <div class="ereaders-main-wrapper">
      <!-- Main Header-->
      @include('frontend.includes.header')
      <!--End Main Header -->

      <!-- Contains page content -->
        @yield('content')
      <!-- End Contains page content -->

      <!-- Main Footer -->
      @include('frontend.includes.footer')
      <!-- End Main Footer -->

        <!-- Cart -->
        @include('frontend.includes.cart')
        <!-- End Cart -->

    </div>
    <!--end wrapper -->

    <!-- Script -->
    @include('frontend.includes.jquery')
    <!-- End Script -->

    <!-- Social -->
{{--    @include('frontend.includes.social')--}}
    <!-- End Social -->

    <!-- Search Form -->
    @include('frontend.includes.search-form')
    <!-- End Search Form -->

  </body>
</html>
