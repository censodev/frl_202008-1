$(document).ready(function(){
    $(".language-click , .icon-cart , .icon-setting").on("click", function() {
        $(this).parent().find('.language-dropdown , .shopping-cart-content , .setting-wrapper').slideToggle('medium');
    });

    var wow = new WOW();
    wow.init();

    //thêm sản phẩm vào giỏ hàng
    $('.product-add-to-card button').click(function(){
        var elment          = $(this);
        var type            = $(this).data('type');
        var div             = $(this).closest('.product-add-to-card');
        var input           = div.find('input');
        var quantity        = input.val();
        var id              = input.attr('data-id');


        var sendData = {};
        sendData.id = id;
        sendData.type = type;
        sendData.quantity = quantity;
        $.ajax({
            type: "GET",
            url: '/add-to-cart',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {

                $('.count-amount').text(response.cart_total);
                $('.shop-total').text(response.cart_total);
                $('.count-style').text(response.count_cart);
                $('.shopping-cart-content ul li').remove();
                $('.shopping-cart-content ul').append(response.html);

                $('#add-cart-success').show();
                $('#add-cart-success').fadeOut(3000);

                //chuyển trang
                if(type){
                    var redirect = window.location.origin + '/cart';
                    window.location.href = redirect;
                }

            },
            error: function (error) {
                console.log(error);
                // alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    });

    //cập nhật giỏ hàng
    $('.pro-dec-cart input.cart-plus-minus-box').change(function(){
        var elment = $(this);
        var id          = $(this).attr('arrt_id');
        var quantity    = $(this).val();

        var sendData = {};
        sendData.id = id;
        sendData.quantity = quantity;
        $.ajax({
            type: "GET",
            url: '/update-to-cart',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {

                var tr = $(elment).closest("tr");
                var td = tr.find(".red-text");

                $(td).text(response.total_price);
                $("h4.grand-totall-title span").text(response.cart_total);
                $("form #total_price_form").val(response.total_price_form);

                $('.count-amount').text(response.cart_total);
                $('.shop-total').text(response.cart_total);
                $('.count-style').text(response.count_cart);
                $('.shopping-cart-content ul li').remove();
                $('.shopping-cart-content ul').append(response.html);
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    });

    //xoá toàn bộ giỏ hàng
    $('.cart-main-area .delete-cart').click(function(){
        var sendData = {};
        $.ajax({
            type: "GET",
            url: '/del-all-cart',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                $('.count-amount').text(response.cart_total);
                $('.shop-total').text(response.cart_total);
                $('.count-style').text(response.count_cart);
                $('.shopping-cart-content ul li').remove();

                $(".cart-main-area .container .row").remove();
                $(".cart-main-area .container").append(response.html);

                var redirect = window.location.origin;
                window.location.href = redirect;
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.');
            }
        });
    });

    //xoá từng sản phẩm trong giỏ hàng
    $(document.body).on('click', '.product-remove a, .shopping-cart-delete a', function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        var sendData = {};
        sendData.id = id;
        $.ajax({
            type: "GET",
            url: '/del-product',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                if (response.count_cart > 0)
                {
                    $("h4.grand-totall-title span").text(response.cart_total);
                    $("form #total_price_form").val(response.cart_total);
                    $(".cart-main-area table tbody tr").remove();
                    $(".cart-main-area table tbody").append(response.html_table);

                }else{
                    var alert = '<h3 class="page-title">Không có sản phẩm nào trong giỏ hàng</h3>';
                    $(".cart-main-area .container .row").remove();
                    $(".cart-main-area .container").append(alert);

                    var redirect = window.location.origin;
                    window.location.href = redirect;
                }


                $('.count-amount').text(response.cart_total);
                $('.shop-total').text(response.cart_total);
                $('.count-style').text(response.count_cart);
                $('.shopping-cart-content ul li').remove();
                $('.shopping-cart-content ul').append(response.html);
            },
            error: function (error) {
                console.log(error);
                // alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    });

    $(window).scroll(function (event) {
        var scroll = $(window).scrollTop();
        if(scroll<150){
            $("#cart-middle").removeClass('show-cart');
        }else{
            $("#cart-middle").addClass('show-cart');
        }
    });

    $('.pro-dec-cart input.cart-plus-minus-box').change(function(){
        var elment = $(this);
        var id          = $(this).attr('arrt_id');
        var quantity    = $(this).val();
    });

    $('.single-ship input').click(function(){
        $('.ship-wrapper > .single-ship > div').css('display','none');
        var div_parent = $(this).closest('.single-ship');
        var div_show = $(div_parent).find("div");
        $(div_show).css('display', 'block');
    });


    // Search Menu JS
    $(".search-box i").on("click", function(event){
        event.preventDefault();
        $(".search-overlay").toggle();
    });
    $(".search-overlay-close").on("click", function(){
        $(".search-overlay").toggle();
    });


    $(".show_video").on('click', function () {
        $video = $(this).data('video') + '?autoplay=1';
        $name = $(this).data('name');

        $("#myModalVideo iframe").attr('src', $video);
        $('#myModalVideo').modal('show');
        $('#myModalVideo .modal-title').text($name);


        $(".close, .modal-footer button").on('click', function () {
            var element = $(this);
            var div = element.closest('#myModalVideo');
            var iframe = div.find('iframe');
            iframe.attr('src', '');
        });
    });

    var modal = document.getElementById("myModalVideo");
    window.onclick = function (event) {
        if (event.target == modal) {
            $("#myModalVideo iframe").attr('src', '');
            modal.style.display = "none";
        }
    };

    $("#list-pay-method input").click(function(){
        $name = $(this).val();
        if($name != 'COD'){
            $('.province-country, .order-email').css('display', 'block');
            $('.order-province input, .order-country input, .order-email input').attr("required", true);
        }else{
            $('.province-country, .order-email').css('display', 'none');
            $('.order-province input, .order-country input, .order-email input').attr("required", false);
        }
    });

    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:20,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    })

    $("body").on("click", '.image-box', function (e) {
        var certify_id = $(this).attr('certify_id');

        $.ajax({
            type: "GET",
            url: '/certify',
            data: {id:certify_id},
            dataType: 'JSON',
            success: function (response) {
                console.log(response);
                $(".modal-content .list-images .mySlides").remove();
                $(".modal-content .list-images").append(response.message);
                $(".modal-content .list-images .mySlides:first-child").css("display", "block");
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    });

    var modal = document.getElementById("myModal");
    $(document.body).on('click', function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });

    //popup hình ảnh sản phẩm chi tiết
    $(document.body).on('click', '.ereaders-shop-thumb img', function (e) {
        $('#show-image-product').modal('show');
    });
    $(document.body).on('click', '#show-image-product .close', function (e) {
        $('#show-image-product').modal('hide');
    });

    $(document.body).on('click', '.list-item .item', function (e) {
        var element = $(this);
        var id = $(this).data('id-item');
        var span = $(this).find('span');

        $.ajax({
            type: "GET",
            url: '/select-price',
            data: {id:id},
            dataType: 'JSON',
            success: function (response) {
                $('#price_buy').text(response.price_buy);
                $('#price_promotion').text(response.price_promotion);
                $('.ereaders-number-select input').attr('data-id', id);

                $('.list-item .item').css('background', '#fff');
                $('.list-item .item span').css('color', '#00aff0');
                element.css('background', '#00aff0');
                span.css('color', '#fff');
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });

    });

    //lọc sản phẩm theo tên
    $( "select[name='sort_name']").change(function(){

        var value = $(this).val();
        var url = location.protocol + '//' + location.host + location.pathname;
        location.href = url+'?name='+value;
    });

    // //lọc sản phẩm theo loại
    $( "select[name='sort_type']").change(function(){
        var value = $(this).val();
        var url = location.protocol + '//' + location.host + location.pathname;
        location.href = url+'?type='+value;
    });


    //lọc sản phẩm theo giá
    $( "select[name='sort_price']").change(function(){
        var value = $(this).val();
        var url = location.protocol + '//' + location.host + location.pathname;
        location.href = url+'?price='+value;
    });

    //lọc sản phẩm theo số lượng
    $( "select[name='sort_number']").change(function(){
        var value = $(this).val();
        var url = location.protocol + '//' + location.host + location.pathname;
        location.href = url+'?number='+value;
    });

    $('.modal-owl-carousel').owlCarousel({
        loop:true,
        margin:10,
        nav:true,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    })
});
