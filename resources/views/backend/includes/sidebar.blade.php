<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/admin" class="brand-link" target="_blank">
    <img src="{{ asset('assets/admin/dist/img/greenteccons-logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">Điện Máy</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex hide">
      <div class="image">
        <img src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Alexander Pierce</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item has-treeview menu-open hide">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Quản Lý Trang Chủ
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview hide">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Trang Chủ
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('homepageManager.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('homepageManager.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Quản Lý</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Quản Lý Nội Dung
            </p>
          </a>
        </li>
{{--          <li class="nav-item has-treeview">--}}
{{--              <a href="#" class="nav-link">--}}
{{--                  <i class="nav-icon fas fa-book"></i>--}}
{{--                  <p>--}}
{{--                      LandingPage--}}
{{--                      <i class="fas fa-angle-left right"></i>--}}
{{--                      <span class="badge badge-info right">2</span>--}}
{{--                  </p>--}}
{{--              </a>--}}
{{--              <ul class="nav nav-treeview">--}}
{{--                  <li class="nav-item">--}}
{{--                      <a href="{{ route('landingPage.index') }}" class="nav-link">--}}
{{--                          <i class="far fa-circle nav-icon"></i>--}}
{{--                          <p>Danh Sách</p>--}}
{{--                      </a>--}}
{{--                  </li>--}}
{{--                  <li class="nav-item">--}}
{{--                      <a href="{{ route('landingPage.create') }}" class="nav-link">--}}
{{--                          <i class="far fa-circle nav-icon"></i>--}}
{{--                          <p>Thêm LandingPage</p>--}}
{{--                      </a>--}}
{{--                  </li>--}}
{{--              </ul>--}}
{{--          </li>--}}
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                  LandingPage
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right">2</span>
              </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="{{ route('landingPage.index') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Danh Sách</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('landingPage.create') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Thêm LandingPage</p>
                  </a>
              </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Danh Mục
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('category.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('category.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Danh Mục</p>
              </a>
            </li>
          </ul>
        </li>

{{--      <li class="nav-item">--}}
{{--          <a href="{{ route('productConfig.edit',1) }}" class="nav-link">--}}
{{--              <i class="far fa-circle nav-icon"></i>--}}
{{--              <p>Cấu Hình Sản Phẩm</p>--}}
{{--          </a>--}}
{{--      </li>--}}

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Sản Phẩm
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('product.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('product.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Sản Phẩm</p>
              </a>
            </li>
          </ul>
        </li>

{{--          <li class="nav-item has-treeview">--}}
{{--              <a href="#" class="nav-link">--}}
{{--                  <i class="nav-icon fas fa-copy"></i>--}}
{{--                  <p>--}}
{{--                      Màu--}}
{{--                      <i class="fas fa-angle-left right"></i>--}}
{{--                      <span class="badge badge-info right">2</span>--}}
{{--                  </p>--}}
{{--              </a>--}}
{{--              <ul class="nav nav-treeview">--}}
{{--                  <li class="nav-item">--}}
{{--                      <a href="{{ route('color.index') }}" class="nav-link">--}}
{{--                          <i class="far fa-circle nav-icon"></i>--}}
{{--                          <p>Danh Sách</p>--}}
{{--                      </a>--}}
{{--                  </li>--}}
{{--                  <li class="nav-item">--}}
{{--                      <a href="{{ route('color.create') }}" class="nav-link">--}}
{{--                          <i class="far fa-circle nav-icon"></i>--}}
{{--                          <p>Thêm Màu</p>--}}
{{--                      </a>--}}
{{--                  </li>--}}
{{--              </ul>--}}
{{--          </li>--}}

          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Vật Liệu
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('material.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('material.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Vật Liệu</p>
                      </a>
                  </li>
              </ul>
          </li>

{{--          <li class="nav-item">--}}
{{--              <a href="{{ route('configProduct.index') }}" class="nav-link">--}}
{{--                  <i class="far fa-circle nav-icon"></i>--}}
{{--                  <p>Cấu Hình Sản Phẩm</p>--}}
{{--              </a>--}}
{{--          </li>--}}

{{--          <li class="nav-item has-treeview">--}}
{{--              <a href="#" class="nav-link">--}}
{{--                  <i class="nav-icon fas fa-copy"></i>--}}
{{--                  <p>--}}
{{--                      Đại Lý--}}
{{--                      <i class="fas fa-angle-left right"></i>--}}
{{--                      <span class="badge badge-info right">2</span>--}}
{{--                  </p>--}}
{{--              </a>--}}
{{--              <ul class="nav nav-treeview">--}}
{{--                  <li class="nav-item">--}}
{{--                      <a href="{{ route('agency.index') }}" class="nav-link">--}}
{{--                          <i class="far fa-circle nav-icon"></i>--}}
{{--                          <p>Danh Sách</p>--}}
{{--                      </a>--}}
{{--                  </li>--}}
{{--                  <li class="nav-item">--}}
{{--                      <a href="{{ route('agency.create') }}" class="nav-link">--}}
{{--                          <i class="far fa-circle nav-icon"></i>--}}
{{--                          <p>Thêm Đại Lý</p>--}}
{{--                      </a>--}}
{{--                  </li>--}}
{{--              </ul>--}}
{{--          </li>--}}

          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Đơn Hàng
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('order.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
              </ul>
          </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Bài Viết
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('post.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('post.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Bài Viết</p>
              </a>
            </li>
          </ul>
        </li>

{{--        <li class="nav-item has-treeview">--}}
{{--          <a href="#" class="nav-link">--}}
{{--            <i class="nav-icon far fa-image"></i>--}}
{{--            <p>--}}
{{--              Gallery--}}
{{--              <i class="fas fa-angle-left right"></i>--}}
{{--              <span class="badge badge-info right">2</span>--}}
{{--            </p>--}}
{{--          </a>--}}
{{--          <ul class="nav nav-treeview">--}}
{{--            <li class="nav-item">--}}
{{--              <a href="{{ route('gallery.index') }}" class="nav-link">--}}
{{--                <i class="far fa-circle nav-icon"></i>--}}
{{--                <p>Danh Sách</p>--}}
{{--              </a>--}}
{{--            </li>--}}
{{--            <li class="nav-item">--}}
{{--              <a href="{{ route('gallery.create') }}" class="nav-link">--}}
{{--                <i class="far fa-circle nav-icon"></i>--}}
{{--                <p>Thêm Gallery</p>--}}
{{--              </a>--}}
{{--            </li>--}}
{{--          </ul>--}}
{{--        </li>--}}
      {{--
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Dịch Vụ
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('service.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('service.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Dịch Vụ</p>
              </a>
            </li>
          </ul>
        </li>
      --}}

        <li class="nav-item has-treeview hide">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Đội Ngũ
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('team.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('team.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Thành Viên</p>
              </a>
            </li>
          </ul>
        </li>

        {{-- <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-copy"></i>
            <p>
              Đối Tác
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('partner.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('partner.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Đối Tác</p>
              </a>
            </li>
          </ul>
        </li> --}}

          {{-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Chứng Nhận
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('certify.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('certify.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Chứng Nhận</p>
                      </a>
                  </li>
              </ul>
          </li> --}}

          {{-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Báo Chí
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('newspaper.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('newspaper.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Báo Chí</p>
                      </a>
                  </li>
              </ul>
          </li> --}}

          {{-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Truyền Hình
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('tv.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('tv.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Truyền Hình</p>
                      </a>
                  </li>
              </ul>
          </li> --}}

          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Ưu Đãi
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('endow.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('endow.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Ưu Đãi</p>
                      </a>
                  </li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Danh mục nổi bật
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('hot.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('hot.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Danh mục nổi bật</p>
                      </a>
                  </li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Banner
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('banner.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('banner.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Banner</p>
                      </a>
                  </li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Seeding
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('seeding.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('seeding.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Seeding</p>
                      </a>
                  </li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                    Seeding FB
                    <i class="fas fa-angle-left right"></i>
                    <span class="badge badge-info right">2</span>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('seeding-fb-comments.index') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Danh Sách</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('seeding-fb-comments.create') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Thêm Seeding</p>
                    </a>
                </li>
            </ul>
          </li>

{{--          <li class="nav-item">--}}
{{--              <a href="{{ route('popup.edit',1) }}" class="nav-link">--}}
{{--                  <i class="far fa-circle nav-icon"></i>--}}
{{--                  <p>Popup</p>--}}
{{--              </a>--}}
{{--          </li>--}}

          {{-- <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Schema Bài Viết
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('schema_post.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('schema_post.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Schema Bài Viết</p>
                      </a>
                  </li>
              </ul>
          </li> --}}

          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Schema Sản Phẩm
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('schema_product.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('schema_product.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Schema Sản Phẩm</p>
                      </a>
                  </li>
              </ul>
          </li>

          <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                  <i class="nav-icon fas fa-copy"></i>
                  <p>
                      Schema Breadcrum
                      <i class="fas fa-angle-left right"></i>
                      <span class="badge badge-info right">2</span>
                  </p>
              </a>
              <ul class="nav nav-treeview">
                  <li class="nav-item">
                      <a href="{{ route('schema_breadcrumb.index') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Danh Sách</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{ route('schema_breadcrumb.create') }}" class="nav-link">
                          <i class="far fa-circle nav-icon"></i>
                          <p>Thêm Schema Breadcrum</p>
                      </a>
                  </li>
              </ul>
          </li>

      <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>Schema
                  <i class="fas fa-angle-left right"></i>
                  <span class="badge badge-info right">3</span>
              </p>
          </a>
          <ul class="nav nav-treeview">
              <li class="nav-item">
                  <a href="{{ route('schema_business') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Schema Doanh Nghiệp</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('schema_logo') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Schema Logo</p>
                  </a>
              </li>
              <li class="nav-item">
                  <a href="{{ route('schema_search') }}" class="nav-link">
                      <i class="far fa-circle nav-icon"></i>
                      <p>Schema Ô Tìm Kiếm</p>
                  </a>
              </li>
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_breadcrumb') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Breadcrumb</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_product') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Sản Phẩm</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_article') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Bài Viết</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_course') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Course</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_event') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Sự Kiện</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_question') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Câu Hỏi</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_rate') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Đánh Giá</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_video') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Video</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_qa') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Hỏi Đáp</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
{{--              <li class="nav-item">--}}
{{--                  <a href="{{ route('schema_tutorial') }}" class="nav-link">--}}
{{--                      <i class="far fa-circle nav-icon"></i>--}}
{{--                      <p>Schema Hướng Dẫn</p>--}}
{{--                  </a>--}}
{{--              </li>--}}
          </ul>
      </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Quản Lý Banner
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Slider
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('slider.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('slider.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Slider</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-book"></i>
            <p>
              Ý Kiến Khách Hàng
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right">2</span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('feedback.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Danh Sách</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('feedback.create') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Thêm Ý Kiến</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Quản Lý Khách Hàng
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('contact.index') }}" class="nav-link">
            <i class="nav-icon far fa-envelope"></i>
            <p>
              Yêu Cầu Liên Hệ
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('signupOffer.index') }}" class="nav-link">
            <i class="nav-icon far fa-envelope"></i>
            <p>
              Đăng Ký Nhận Ưu Đãi
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>
              Quản Lý Tài Khoản
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="{{ route('user.index') }}" class="nav-link">
            <i class="nav-icon fas fa-user-secret"></i>
            <p>
              Tài Khoản Quản Trị
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview menu-open">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-cogs"></i>
            <p>
              Cấu Hình
            </p>
          </a>
        </li>
        <li class="nav-item">
		  <a href="{{ route('configSeo.edit',1) }}" class="nav-link">
			<i class="far fa-circle nav-icon"></i>
			<p>
			  SEO Website
			</p>
		  </a>
		</li>
		<li class="nav-item">
		  <a href="" class="nav-link">
			<i class="nav-icon far fa-envelope"></i>
			<p>
			  Quản Lý Logo
			  <i class="right fas fa-angle-left"></i>
			  <span class="badge badge-info right">1</span>
			</p>
		  </a>
		  <ul class="nav nav-treeview">
			<li class="nav-item">
			  <a href="{{ route('configLogo.index') }}" class="nav-link">
				<i class="far fa-dot-circle nav-icon"></i>
				<p>Danh Sách</p>
			  </a>
			</li>
			<li class="nav-item hide">
			  <a href="{{ route('configLogo.create') }}" class="nav-link">
				<i class="far fa-dot-circle nav-icon"></i>
				<p>Thêm Logo</p>
			  </a>
			</li>
		  </ul>
		</li>
		<li class="nav-item">
		  <a href="{{ route('configScript.edit',1) }}" class="nav-link">
			<i class="far fa-circle nav-icon"></i>
			<p>
			  Chèn Script, Style
			</p>
		  </a>
		</li>
		<li class="nav-item">
		  <a href="{{ route('configFooter.edit',1) }}" class="nav-link">
			<i class="far fa-circle nav-icon"></i>
			<p>
			  Footer
			</p>
		  </a>
		</li>
		<li class="nav-item">
		  <a href="{{ route('configContact.edit',1) }}" class="nav-link">
			<i class="fas fa-id-card-alt nav-icon"></i>
			<p>
			  Liên Hệ
			</p>
		  </a>
		</li>
		<li class="nav-item">
		  <a href="{{ route('configEmail.edit',1) }}" class="nav-link">
			<i class="far fa-envelope nav-icon"></i>
			<p>
			  Mail
			</p>
		  </a>
		</li>
		<li class="nav-item">
		  <a href="" class="nav-link">
			<i class="fas fa-share-alt-square nav-icon"></i>
			<p>
			  Mạng Xã Hội TopBar
			  <i class="right fas fa-angle-left"></i>
			  <span class="badge badge-info right">2</span>
			</p>
		  </a>
		  <ul class="nav nav-treeview">
			<li class="nav-item">
			  <a href="{{ route('configSocialTopbar.index') }}" class="nav-link">
				<i class="far fa-dot-circle nav-icon"></i>
				<p>Danh Sách</p>
			  </a>
			</li>
			<li class="nav-item">
			  <a href="{{ route('configSocialTopbar.create') }}" class="nav-link">
				<i class="far fa-dot-circle nav-icon"></i>
				<p>Thêm Social TopBar</p>
			  </a>
			</li>
		  </ul>
		</li>
		<li class="nav-item">
		  <a href="" class="nav-link">
			<i class="fas fa-share-alt-square nav-icon"></i>
			<p>
			  Mạng Xã Hội
			  <i class="right fas fa-angle-left"></i>
			  <span class="badge badge-info right">2</span>
			</p>
		  </a>
		  <ul class="nav nav-treeview">
			<li class="nav-item">
			  <a href="{{ route('configSocial.index') }}" class="nav-link">
				<i class="far fa-dot-circle nav-icon"></i>
				<p>Danh Sách</p>
			  </a>
			</li>
			<li class="nav-item">
			  <a href="{{ route('configSocial.create') }}" class="nav-link">
				<i class="far fa-dot-circle nav-icon"></i>
				<p>Thêm Social</p>
			  </a>
			</li>
		  </ul>
		</li>
		<li class="nav-item">
		  <a href="{{ route('configPolicy.edit',1) }}" class="nav-link">
			<i class="far fa-circle nav-icon"></i>
			<p>
			  Chính Sách
			</p>
		  </a>
		</li>

        <li class="nav-item">
          <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>
              Thoát
            </p>
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
