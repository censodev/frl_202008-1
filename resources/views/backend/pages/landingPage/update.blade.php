@php
    use App\Models\backend\Slider;
    use App\Models\backend\Product;
    use App\Models\backend\Post;
    use App\Models\backend\Newspaper;
    use App\Models\backend\Tv;
    use App\Models\backend\Endow;
    use App\Models\backend\About;
    use App\Models\backend\Image;
    use App\Models\backend\Video;
    use App\Models\backend\Hot;
@endphp

@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection

@php
    $types = $data['types'];
    $landingPage = $data['landingPage'];
    $sections = $data['sections'];
@endphp

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $data->title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Trang Quản Trị</a></li>
                        <li class="breadcrumb-item active">{{ $data->title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form role="form" action="{{ route('landingPage.update',$landingPage->id) }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="title">Tiêu Đề LandingPage</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">@</span>
                        </div>
                        <input type="text" id="title" name="title" value="{{ $landingPage->title ?? old('title') }}" class="form-control" placeholder="Tiêu Đề LandingPage" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề LandingPage.')" oninput="setCustomValidity('')">
                    </div>
                    @if( $errors->has('title') )
                        <div class="alert alert-danger">{{ $errors->first('title') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="alias">Đường Dẫn Thân Thiện</label>
                    <input type="text" id="alias" name="alias" value="{{ $landingPage->alias ?? old('alias') }}" class="form-control" required placeholder="Nhập đường dẫn thân thiện" oninvalid="this.setCustomValidity('Vui lòng nhập đường dẫn thân thiện.')" oninput="setCustomValidity('')">
                    @if( $errors->has('alias') )
                        <div class="alert alert-danger">{{ $errors->first('alias') }}</div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="category_id">Chọn Danh Mục ( Bài Viết )</label>
                    <select class="form-control custom-select" name="category_id" required oninvalid="this.setCustomValidity('Vui lòng chọn danh mục cha.')" oninput="setCustomValidity('')">
                        <option selected disabled>--- Chọn Danh Mục ---</option>
                        @php
                            $level = 0;
                            $category_level = $data['category_level']->toArray();
                            showListCategoryPost($category_level,$level,$landingPage->category_id);
                        @endphp
                    </select>
                </div>
                <div id="holder_landing" class="thumbnail text-center">
                    <img src="{{ $landingPage->image_landing }}" style="height: 5rem;">
                </div>
                <div class="input-group">
              <span class="input-group-btn">
                <a id="lfm" data-input="thumbnail_landing" data-preview="holder_landing" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Chọn Ảnh Đại Diện
                </a>
              </span>
                    <input id="thumbnail_landing" class="form-control" type="text" name="image_landing" value="{{ $landingPage->image_landing ?? old('image_landing') }}">
                </div>

                <div class="row mt-1rem">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title_image">Tiêu Đề Hình Ảnh</label>
                            <input type="text" name="title_image_landing" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $landingPage->title_image_landing ?? old('title_image_landing') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="alt_image">Mô Tả Hình Ảnh</label>
                            <input type="text" name="alt_image_landing" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $landingPage->alt_image_landing ?? old('alt_image_landing') }}">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="seo_title">SEO Tiêu Đề <span id="seotitleerror" class="error alert-danger"><span class="change-text">Chuẩn SEO</span> <span id="validatetitleseo"> </span>/60 kí tự</span></label>
                    <input type="text" id="seo_title" name="seo_title" placeholder="Nhập Seo tiêu đề" class="form-control" value="{{ $landingPage->seo_title ?? old('seo_title') }}">
                </div>
                <div class="form-group">
                    <label for="seo_desciption">SEO Mô Tả <span id="seodeserror" class="error alert-danger" ><span class="change-text">Chuẩn SEO</span> <span id="validateseomota"></span>/160 kí tự</span></label>
                    <input type="text" id="seo_desciption" name="seo_desciption" placeholder="Nhập Seo mô tả" class="form-control" value="{{ $landingPage->seo_desciption ?? old('seo_desciption') }}">
                </div>
                <div class="form-group">
                    <label for="seo_keyword">SEO Từ Khóa</label>
                    <input type="text" id="seo_keyword" name="seo_keyword" placeholder="Nhập Seo từ khóa" class="form-control" value="{{ $landingPage->seo_keyword ?? old('seo_keyword') }}">
                </div>


                <div class="card card-solid">
                    <div class="card-header">
                        <h3 class="card-title">Section</h3>
                    </div>
                    <div class="card-body pb-0">
                        <div class="row d-flex align-items-stretch increment-section">
                            @if(!empty($sections) && count($sections) > 0)
                                @foreach($sections as $key_section => $section)
                                    <div class="col-12 col-sm-12 col-md-12 align-items-stretch section-item @if($key_section > 0) clone-section-cli @endif">
                                        <div class="card bg-light">
                                            <div class="card-header text-muted border-bottom-0">
                                                Section
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <input type="hidden" value="{{ $section->id }}" name="item_id[]">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label>Tiêu đề</label>
                                                            <input type="text" name="name[]" placeholder="Nhập tiêu đề" class="form-control" value="{{ $section->name }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Chọn loại modules</label>
                                                            <select name="type[]" class="form-control" required>
                                                                <option value="">---chọn loại---</option>
                                                                @foreach($types as $key => $type)
                                                                    <option value="{{ $key }}" @if($section->type == $key) selected @endif>{{ $type }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label>Thứ tự</label>
                                                            <input type="number" name="ordering[]" class="form-control" value="{{ $section->ordering }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div id="holder-{{ $key }}" class="thumbnail text-center">
                                                                <img src="{{ $section->images }}" style="height: 5rem;">
                                                            </div>
                                                            <div class="input-group">
                                                        <span class="input-group-btn">
                                                          <a data-input="thumbnail-{{ $key }}" data-preview="holder-{{ $key }}" class="lfm-mul btn btn-primary">
                                                            <i class="fa fa-picture-o"></i> Chọn Ảnh Desktop
                                                          </a>
                                                        </span>
                                                                <input id="thumbnail-{{ $key }}" value="{{ $section->images }}" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="title_image">Tiêu Đề Hình Ảnh Desktop</label>
                                                            <input type="text" id="title_image" name="title_image[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $section->title_image }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="alt_image">Mô Tả Hình Ảnh Desktop</label>
                                                            <input type="text" id="alt_image" name="alt_image[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $section->alt_image }}" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <div id="holder_mobile-{{ $key }}" class="thumbnail text-center">
                                                                <img src="{{ $section->images_mobile }}" style="height: 5rem;">
                                                            </div>

                                                            <div class="input-group">
                                                        <span class="input-group-btn">
                                                          <a data-input="thumbnail_mobile-{{ $key }}" data-preview="holder_mobile-{{ $key }}" class="lfm-mul btn btn-primary">
                                                            <i class="fa fa-picture-o"></i> Chọn Ảnh Mobile
                                                          </a>
                                                        </span>
                                                                <input id="thumbnail_mobile-{{ $key }}" value="{{ $section->images_mobile }}" class="form-control" type="text" name="images_mobile[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="title_image">Tiêu Đề Hình Ảnh Mobile</label>
                                                            <input type="text" name="title_image_mobile[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="{{ $section->title_image_mobile }}" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="alt_image">Mô Tả Hình Ảnh Mobile</label>
                                                            <input type="text" name="alt_image_mobile[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="{{ $section->alt_image_mobile }}" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="description">Chi Tiết</label>
                                                            <textarea name="description[]" class="form-control" rows="4">{{ $section->description }}</textarea>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Tiêu Đề Kêu Gọi Hành Động</label>
                                                            <input name="title_action[]" class="form-control" value="{{ $section->title_action ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>Icon Kêu Gọi Hành Động</label>
                                                            <input name="icon_action[]" class="form-control" value="{{ $section->icon_action ?? '' }}">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label>ID Form Đăng Ký</label>
                                                            <input name="id_action[]" class="form-control" value="{{ $section->id_action ?? '' }}">
                                                        </div>
                                                    </div> --}}

                                                    @php
                                                        $button_class = $section->type .'_search';
                                                        $target = '#modal-lg-'. $section->type;
                                                        $search = 'in'. ucfirst($section->type);
                                                        $ul_class = 'block-'. $section->type .'-list';
                                                        $type = $section->type;


                                                        $Ids = $listItems = [];
                                                        if(isset($section->items) && !empty($section->items)) {
                                                            $Ids                        = json_decode($section->items,true);
                                                            if($type == 'article'){
                                                                $listItems              = Post::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_post[]';
                                                            }
                                                            if($type == 'product'){
                                                                $listItems              = Product::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_product[]';
                                                            }
                                                            if($type == 'slider'){
                                                                $listItems              = Slider::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_slider[]';
                                                            }
                                                            if($type == 'newspaper'){
                                                                $listItems              = Newspaper::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_newspaper[]';
                                                            }
                                                            if($type == 'tv'){
                                                                $listItems              = Tv::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_tv[]';
                                                            }
                                                            if($type == 'endow'){
                                                                $listItems              = Endow::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_endow[]';
                                                            }
                                                            if($type == 'about'){
                                                                $listItems              = About::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_about[]';
                                                            }
                                                            if($type == 'album'){
                                                                $listItems              = Image::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_album[]';
                                                            }
                                                            if($type == 'video'){
                                                                $listItems              = Video::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_video[]';
                                                            }
                                                            if($type == 'hot'){
                                                                $listItems              = Hot::whereIn('id', $Ids)->where('status',1)->get();
                                                                $related                = 'related_hot[]';
                                                            }
                                                        }

                                                    @endphp

                                                    <div class="col-md-12 list-value">
                                                        <div class="form-group block-search-appliesto">
                                                            <button class="btn btn-info {{ $button_class }}" type="button" data-toggle="modal" data-target="{{ $target }}" search="{{ $search }}" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
                                                        </div>
                                                        <div class="form-group">
                                                            <ul class="todo-list appliesto-value {{ $ul_class }}" data-widget="todo-list">
                                                                @if( !empty( $listItems ) && count( $listItems ) > 0 )
                                                                    @foreach( $listItems as $listItems )
                                                                        @php
                                                                            if($type == 'product'){
                                                                                $images         = json_decode( $listItems->images );
                                                                                $title_image    = json_decode( $listItems->title_image );
                                                                                $alt_image      = json_decode( $listItems->alt_image );
                                                                            }else{
                                                                                $images = $post->images ?? asset('assets/admin/dist/img/no_image.png');
                                                                            }

                                                                        @endphp
                                                                        <li class="ul-item {{ $listItems->id }}">
                                                                            <input type="hidden" name="{{ $related }}" value="{{ $listItems->id }}">
                                                                            <!-- drag handle -->
                                                                            <span class="handle">
                                                                                  <i class="fas fa-ellipsis-v"></i>
                                                                                  <i class="fas fa-ellipsis-v"></i>
                                                                                </span>
                                                                            @if($type == 'product')
                                                                                <img width="40px" height="40px" src="{{ $images[0] }}" title="{{ $title_image[0] }}" alt="{{ $alt_image[0] }}">
                                                                            @elseif($type == 'album' || $type == 'video')
                                                                                <img src="{{ $listItems->image }}" width="40px" height="40px">
                                                                            @elseif($type == 'tv' || $type == 'newspaper' || $type == 'hot')
                                                                                <img src="{{ $listItems->images }}" width="40px" height="40px">
                                                                            @else
                                                                                <img src="{{ $images }}" width="40px" height="40px">
                                                                            @endif
                                                                            <span class="text">
                                                                                @if($type == 'tv' || $type == 'newspaper' || $type == 'endow' || $type == 'hot')
                                                                                    <a href="">{{ $listItems->name }}</a>
                                                                                @else
                                                                                    <a href="">{{ $listItems->title }}</a>
                                                                                @endif
                                                                            </span>
                                                                            <div class="tools">
                                                                                <div class="remove-item__action" itemID="{{ $listItems->id }}"><i class="fas fa-trash"></i></div>
                                                                            </div>
                                                                        </li>
                                                                    @endforeach
                                                                @endif
                                                            </ul>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            @if($key_section > 0)
                                                <div class="card-footer">
                                                    <div class="text-right">
                                                        <button class="btn btn-sm btn-danger btn-remove-section" type="button">
                                                            <i class="fas fa-trash"></i> Xóa
                                                        </button>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-12 col-sm-12 col-md-12 align-items-stretch section-item">
                                    <div class="card bg-light">
                                        <div class="card-header text-muted border-bottom-0">
                                            Section
                                        </div>
                                        <div class="card-body pt-0">
                                            <div class="row">
                                                <input type="hidden" value="" name="item_id[]">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Tiêu đề</label>
                                                        <input type="text" name="name[]" placeholder="Nhập tiêu đề" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Chọn loại modules</label>
                                                        <select name="type[]" class="form-control" required>
                                                            <option value="">---chọn loại---</option>
                                                            @foreach($types as $key => $type)
                                                                <option value="{{ $key }}">{{ $type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>Thứ tự</label>
                                                        <input type="number" name="ordering[]" class="form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div id="holder" class="thumbnail text-center"></div>
                                                        <div class="input-group">
                                                    <span class="input-group-btn">
                                                      <a data-input="thumbnail" data-preview="holder" class="lfm-mul btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Chọn Ảnh Desktop
                                                      </a>
                                                    </span>
                                                            <input id="thumbnail" class="form-control" type="text" name="images[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="title_image">Tiêu Đề Hình Ảnh Desktop</label>
                                                        <input type="text" id="title_image" name="title_image[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="alt_image">Mô Tả Hình Ảnh Desktop</label>
                                                        <input type="text" id="alt_image" name="alt_image[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <div id="holder_mobile" class="thumbnail text-center"></div>
                                                        <div class="input-group">
                                                    <span class="input-group-btn">
                                                      <a data-input="thumbnail_mobile" data-preview="holder_mobile" class="lfm-mul btn btn-primary">
                                                        <i class="fa fa-picture-o"></i> Chọn Ảnh Mobile
                                                      </a>
                                                    </span>
                                                            <input id="thumbnail_mobile" class="form-control" type="text" name="images_mobile[]" required oninvalid="this.setCustomValidity('Vui lòng chọn hình ảnh.')" oninput="setCustomValidity('')">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="title_image">Tiêu Đề Hình Ảnh Mobile</label>
                                                        <input type="text" name="title_image_mobile[]" placeholder="Nhập tiêu đề hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập tiêu đề.')" oninput="setCustomValidity('')">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="alt_image">Mô Tả Hình Ảnh Mobile</label>
                                                        <input type="text" name="alt_image_mobile[]" placeholder="Nhập mô tả hình ảnh" class="form-control" value="" required oninvalid="this.setCustomValidity('Vui lòng nhập mô tả.')" oninput="setCustomValidity('')">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="description">Chi Tiết</label>
                                                        <textarea name="description[]" class="form-control" rows="4"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 list-value">
                                                    <div class="form-group block-search-appliesto">
                                                        <button class="btn btn-info " disabled type="button" data-toggle="modal" data-target="" search="" is-append="0"><i class="fas fa-search"></i> Tìm kiếm</button>
                                                    </div>
                                                    <div class="form-group">
                                                        <ul class="todo-list appliesto-value" data-widget="todo-list">

                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                        <div class="form-group text-right">
                            <button class="btn-clone-section btn btn-info" type="button"><i class="fas fa-plus"></i> Thêm Section</button>
                        </div>
                    </div>
                </div>



                <div class="row">
                    <div class="col-12">
                        <a href="{{ route('landingPage.index') }}" class="btn btn-secondary">Thoát</a>
                        <input type="submit" value="Lưu" class="btn btn-success float-right">
                    </div>
                </div>
            </form>
            <!-- /.form -->
        </div>
    </section>
    <!-- /.content -->

    <!-- Clone -->

    @include('backend.includes.clone-section-landing')

@endsection
