@extends($data->layout)

@section('title')
    {{ $data->title }}
@endsection

@section($data->content)
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $data->title }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/admin">Trang Quản Trị</a></li>
                        <li class="breadcrumb-item active">{{ $data->title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @php
        $schema = $data['schema'];
    @endphp

    <!-- Main content -->
    <section class="content">

    @include('backend.includes.search-form')

    <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ $data->title }}</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fas fa-minus"></i></button>
                </div>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped projects">
                    <thead>
                    <tr>
                        <th style="width: 1%">
                            STT
                        </th>
                        <th>
                            Tên
                        </th>
                        <th>
                            Loại
                        </th>
                        <th>
                            Danh Mục Bài Viết
                        </th>
                        <th>
                            Danh Mục Sản Phẩm
                        </th>
                        <th>
                            Bài Viết
                        </th>
                        <th>
                            Sản Phẩm
                        </th>
                        <th style="width: 15%">
                        </th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($schema as $key => $item)
                        <tr>
                            <td> {{ ($key + 1) }} </td>
                            <td>
                                    <a href="{{ route('schema_breadcrumb.edit',$item->id) }}"> {{ $item->name_breadcrumb }} </a>
                            </td>
                            <td>
                                <select class="form-control">
                                    <option selected></option>
                                    @foreach($data['show_where'] as $key => $type)
                                        <option value="{{ $item->type }}" @if($item->type == $key) selected @endif> {{ $type }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control">
                                    <option selected></option>
                                    @foreach($data['list_post_cat'] as $key => $post_cat)
                                        <option value="{{ $post_cat->id }}" @if($item->id_post_cat == $post_cat->id) selected @endif> {{ $post_cat->title }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control">
                                    <option selected></option>
                                    @foreach($data['list_product_cat'] as $key => $product_cat)
                                        <option value="{{ $product_cat->id }}" @if($item->id_product_cat == $product_cat->id) selected @endif> {{ $product_cat->title }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control">
                                    <option selected></option>
                                    @foreach($data['list_post'] as $key => $post)
                                        <option value="{{ $post->id }}" @if($item->id_post == $post->id) selected @endif> {{ $post->title }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select class="form-control">
                                    <option selected></option>
                                    @foreach($data['list_product'] as $key => $product)
                                        <option value="{{ $product->id }}" @if($item->id_product == $product->id) selected @endif> {{ $product->title }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('schema_breadcrumb.edit',$item->id) }}">
                                    <i class="fas fa-pencil-alt"></i> Sửa
                                </a>
                                <button type="button" class="btn btn-danger btn-sm deleteItemModal" data-toggle="modal" data-target="#modal-danger-delete" data-id="{{ $item->id }}" data-url="admin/schema_breadcrumb/{{ $item->id }}">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <nav aria-label="Contacts Page Navigation">
                    <ul class="pagination justify-content-center m-0">
                        {{ $schema->appends( request()->query() )->links() }}
                    </ul>
                </nav>
            </div>
            <!-- /.card-footer -->

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
