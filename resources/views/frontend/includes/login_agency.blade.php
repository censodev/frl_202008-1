<div class="modal" tabindex="-1" role="dialog" id="LoginAgency">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Đại Lý đăng nhập</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('login-agency') }}" method="POST" enctype="multipart/form-data" accept-charset="utf-8" style="width: 100%;">
                    @csrf
                    <div class="form-group">
                        <label for="username" class="col-form-label">Tên đăng nhập:</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-form-label">Mật khẩu:</label>
                        <input type="text" class="form-control" id="password" name="password">
                    </div>
                    <button type="submit" class="btn btn-secondary float-right">Đăng Nhập</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
