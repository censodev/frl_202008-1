$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function(){
	/* Delete Item */
	$('.deleteItemModal').on('click', function(){
		let id 	= $(this).data('id');
		var url = $(this).data('url');

		$('.deleteItem').on('click', function(){
			$.ajax({
				url : url,
				dataType : 'json',
				type : 'DELETE',
				success : function( $result ) {
					messageSuccess( $result.result, 5000 );
					$('#modal-danger-delete').modal('hide');
					reloadTimeout();
				}
			});
		});
	});

    /* Contact View Info */
    $('.contact-view-info').on('click', function(){
        let id  = $(this).data('id');
        var url = $(this).data('url');

        $.ajax({
            url : url,
            dataType : 'json',
            type : 'GET',
            data : {id: id},
            success : function( $result ) {
                if( $result.error ) {
                    $('#modal-lg-show-info .modal-body').html('<div class="alert alert-danger">' + $result.error + '</div>');
                }else {
                    $('#modal-lg-show-info .modal-title').text('Nội Dung Liên Hệ');
                    $('#modal-lg-show-info .modal-body').text($result.message);
                }
            }
        });
    });

    /* switchChange ajax */
    $('.switch_element_ajax').on('switchChange.bootstrapSwitch', function(event, state) {
        if (state)
        {
            //On
        }else
        {
            //Off
        }

        var url = $(this).data('url');

        $.ajax({
            url : url,
            type : 'POST',
            dataType: 'JSON',
            success: function (response) {
                if( response.error ) {
                    var error = response.error;
                    messageError( error, 5000 );
                    reloadTimeout();
                }else {
                    var msg = response.message;
                    messageSuccess( msg, 5000 );
                }
            },
            error: function (error) {
                var msg = error;
                messageError( msg, 5000 );
                reloadTimeout();
            }
        });

    });

    $('.select-change-agency').change(function(){
        var r = confirm("Bạn muốn chọn hoặc thay đổi đại lý");

        if (r == true) {
            var id_order = $(this).data('id-order');
            var id_agency = $(this).val();

            var sendData = {};
            sendData.id_order = id_order;
            sendData.id_agency = id_agency;

            $.ajax({
                url: '/admin/order/change_agency',
                type: 'POST',
                data: sendData,
                dataType: 'JSON',
                success: function (response) {
                    if (response.error) {
                        var error = response.error;
                        messageError(error, 5000);
                        reloadTimeout();
                    } else {
                        var msg = response.message;
                        messageSuccess(msg, 5000);
                    }
                },
                error: function (error) {
                    var msg = error;
                    messageError(msg, 5000);
                    reloadTimeout();
                }
            });
        }
    });

    $('.change-status-order').change(function(){
        var id_order    = $(this).data('id-order');
        var order_status      = $(this).val();

        var sendData = {};
        sendData.id_order           = id_order;
        sendData.order_status       = order_status;

        $.ajax({
            url : '/admin/order/change_order_status',
            type : 'POST',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                if( response.error ) {
                    var error = response.error;
                    messageError( error, 5000 );
                    reloadTimeout();
                }else {
                    var msg = response.message;
                    messageSuccess( msg, 5000 );
                }
            },
            error: function (error) {
                var msg = error;
                messageError( msg, 5000 );
                reloadTimeout();
            }
        });
    });

});

/* toastr notification */
function messageSuccess($message, $timeout){
    toastr.success($message, 'Thông báo', {timeOut: $timeout});
}
function messageError($message, $timeout){
    toastr.error($message, 'Thông báo', {timeOut: $timeout});
}

function reloadTimeout( timeout = 2000 ) {
	setTimeout(
	  	function()
	  	{
	    	location.reload();
	  	}, timeout);
}

/**/
function isInArray(value, array) {
    return array.indexOf(value) > -1;
}

var Discount = {
    listArticleSelected : [],
    listProductSelected : [],
	listProductNewSelected : [],
	listProductHotSelected : [],
	listProductSaleSelected : [],
	listProductSellingSelected : [],
	listArticleServiceSelected : [],
    listPostHotSelected : [],
    listGallerySelected : [],
    listSliderSelected  : [],
    listTeamSelected    : [],
	listPartnerSelected : [],
	listCertifySelected : [],
	listTvSelected : [],
	listNewspaperSelected : [],
	listEndowSelected : [],
	listHotSelected : [],
	listHotSelected2 : [],
    listBannerSelected : [],
    listAboutSelected: [],
    listAlbumSelected: [],
    listVideoSelected: [],
    ini : function(){
    	var self = this;

        $("body").on("click", '.block-search-appliesto .gallery_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-gallery").remove();
            }
            self.searchGallery(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .article_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-article").remove();
            }
            self.searchArticle(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .article_search_hot', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-article-hot").remove();
            }
            self.searchArticleHot(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .product_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-product").remove();
            }
            self.searchProduct(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .product_search_new', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-product-new").remove();
            }
            self.searchProductNew(block,isAppend);
        });

		$("body").on("click", '.block-search-appliesto .product_search_hot', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-product-hot").remove();
            }
            self.searchProductHot(block,isAppend);
        });

		$("body").on("click", '.block-search-appliesto .product_search_sale', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-product-sale").remove();
            }
            self.searchProductSale(block,isAppend);
        });

		$("body").on("click", '.block-search-appliesto .product_search_selling', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-product-selling").remove();
            }
            self.searchProductSelling(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .article_service_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-article-service").remove();
            }
            self.searchArticleService(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .slider_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-slider").remove();
            }
            self.searchSlider(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .team_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-team").remove();
            }
            self.searchTeam(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .partner_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-partner").remove();
            }
            self.searchPartner(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .endow_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-endow").remove();
            }
            self.searchEndow(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .hot_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-hot").remove();
            }
            self.searchHot(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .hot_search_2', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-hot2").remove();
            }
            self.searchHot2(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .certify_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-certify").remove();
            }
            self.searchCertify(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .tv_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-tv").remove();
            }
            self.searchTv(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .newspaper_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-newspaper").remove();
            }
            self.searchNewspaper(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .banner_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-banner").remove();
            }
            self.searchBanner(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .about_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-about").remove();
            }
            self.searchAbout(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .album_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-album").remove();
            }
            self.searchAlbum(block,isAppend);
        });

        $("body").on("click", '.block-search-appliesto .video_search', function (e) {
            var block = $(this).attr('search');
            var isAppend =  parseInt($(this).attr('is-append'));

            if(!isAppend){
                $("#modal-lg-video").remove();
            }
            self.searchVideo(block,isAppend);
        });

        $("body").on("change", '.ul-item input[type="checkbox"]', function (e) {
            var isChecked = $(this).is(':checked');
            var itemID = $(this).val();
            $('.ul-item.'+itemID).removeClass('checked');
            if(isChecked){
                $('.ul-item.'+itemID).addClass('checked');
            }
        });

		$("body").on("change", '.ul-item-product-hot input[type="checkbox"]', function (e) {
            var isChecked = $(this).is(':checked');
            var itemID = $(this).val();
            $('.ul-item-product-hot.'+itemID).removeClass('checked');
            if(isChecked){
                $('.ul-item-product-hot.'+itemID).addClass('checked');
            }
        });

		$("body").on("change", '.ul-item-product-sale input[type="checkbox"]', function (e) {
            var isChecked = $(this).is(':checked');
            var itemID = $(this).val();
            $('.ul-item-product-sale.'+itemID).removeClass('checked');
            if(isChecked){
                $('.ul-item-product-sale.'+itemID).addClass('checked');
            }
        });

		$("body").on("change", '.ul-item-product-selling input[type="checkbox"]', function (e) {
            var isChecked = $(this).is(':checked');
            var itemID = $(this).val();
            $('.ul-item-product-selling.'+itemID).removeClass('checked');
            if(isChecked){
                $('.ul-item-product-selling.'+itemID).addClass('checked');
            }
        });

        $("body").on("click", '.block-gallery-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeGallery(itemID);

        });

        $("body").on("click", '.block-article-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeArticle(itemID);

        });

        $("body").on("click", '.block-product-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeProduct(itemID);

        });

		$("body").on("click", '.block-product-hot-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeProductHot(itemID);

        });

		$("body").on("click", '.block-product-sale-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeProductSale(itemID);

        });

		$("body").on("click", '.block-product-selling-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeProductSelling(itemID);

        });

        $("body").on("click", '.block-article-service-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeArticleService(itemID);

        });

        $("body").on("click", '.block-slider-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeSlider(itemID);

        });

        $("body").on("click", '.block-team-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeTeam(itemID);

        });

        $("body").on("click", '.block-partner-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removePartner(itemID);

        });

        $("body").on("click", '.block-tv-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeTv(itemID);

        });

        $("body").on("click", '.block-newspaper-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeNewspaper(itemID);

        });

        $("body").on("click", '.block-certify-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeCertify(itemID);

        });

        $("body").on("click", '.block-banner-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeBanner(itemID);

        });

        $("body").on("click", '.block-hot-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeHot(itemID);

        });

        $("body").on("click", '.block-hot-2-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeHot2(itemID);

        });

        $("body").on("click", '.block-about-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeAbout(itemID);

        });

        $("body").on("click", '.block-album-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeAlbum(itemID);

        });

        $("body").on("click", '.block-video-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeVideo(itemID);

        });

        $("body").on("click", '.block-endow-list .remove-item__action', function (e) {
            var itemID = $(this).attr('itemID');
            self.removeEndow(itemID);

        });

        $("body").on("click", '.addappliesto.gallery', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-gallery input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listGallerySelected);
                if(!is){
                    self.listGallerySelected.push(itemID)
                    var block  = $('#modal-lg-gallery .ul-item.'+itemID);
                    var image  = $('#modal-lg-gallery .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-gallery .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_gallery[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-gallery-list').append(html)
                }
            });
            $('#modal-lg-gallery').modal('hide');

        });

        $("body").on("click", '.addappliesto.article', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-article input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listArticleSelected);
                if(!is){
                    self.listArticleSelected.push(itemID)
                    var block  = $('#modal-lg-article .ul-item.'+itemID);
                    var image  = $('#modal-lg-article .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-article .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_post[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-article-list').append(html)
                }
            });
            $('#modal-lg-article').modal('hide');

        });

        $("body").on("click", '.addappliesto.product', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-product input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listProductSelected);
                if(!is){
                    self.listProductSelected.push(itemID)
                    var block  = $('#modal-lg-product .ul-item.'+itemID);
                    var image  = $('#modal-lg-product .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-product .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_product[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-product-list').append(html)
                }
            });
            $('#modal-lg-product').modal('hide');

        });

        $("body").on("click", '.addappliesto.product_new', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-product-new input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listProductNewSelected);
                if(!is){
                    self.listProductNewSelected.push(itemID)
                    var block  = $('#modal-lg-product-new .ul-item-product-new.'+itemID);
                    var image  = $('#modal-lg-product-new .ul-item-product-new.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-product-new .ul-item-product-new.'+itemID + ' span.text').text();
                    html = '<li class="ul-item-product-new '+itemID+'">\
                                <input type="hidden" name="related_product_new[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-product-new-list').append(html)
                }
            });
            $('#modal-lg-product-new').modal('hide');

        });

		$("body").on("click", '.addappliesto.product_hot', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-product-hot input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listProductHotSelected);
                if(!is){
                    self.listProductHotSelected.push(itemID)
                    var block  = $('#modal-lg-product-hot .ul-item-product-hot.'+itemID);
                    var image  = $('#modal-lg-product-hot .ul-item-product-hot.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-product-hot .ul-item-product-hot.'+itemID + ' span.text').text();
                    html = '<li class="ul-item-product-hot '+itemID+'">\
                                <input type="hidden" name="related_product_hot[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-product-hot-list').append(html)
                }
            });
            $('#modal-lg-product-hot').modal('hide');

        });

		$("body").on("click", '.addappliesto.product_sale', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-product-sale input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listProductSaleSelected);
                if(!is){
                    self.listProductSaleSelected.push(itemID)
                    var block  = $('#modal-lg-product-sale .ul-item-product-sale.'+itemID);
                    var image  = $('#modal-lg-product-sale .ul-item-product-sale.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-product-sale .ul-item-product-sale.'+itemID + ' span.text').text();
                    html = '<li class="ul-item-product-sale '+itemID+'">\
                                <input type="hidden" name="related_product_sale[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-product-sale-list').append(html)
                }
            });
            $('#modal-lg-product-sale').modal('hide');

        });

		$("body").on("click", '.addappliesto.product_selling', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-product-selling input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listProductSellingSelected);
                if(!is){
                    self.listProductSellingSelected.push(itemID)
                    var block  = $('#modal-lg-product-selling .ul-item-product-selling.'+itemID);
                    var image  = $('#modal-lg-product-selling .ul-item-product-selling.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-product-selling .ul-item-product-selling.'+itemID + ' span.text').text();
                    html = '<li class="ul-item-product-selling '+itemID+'">\
                                <input type="hidden" name="related_product_selling[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-product-selling-list').append(html)
                }
            });
            $('#modal-lg-product-selling').modal('hide');

        });

        $("body").on("click", '.addappliesto.article-service', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-article-service input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listArticleServiceSelected);
                if(!is){
                    self.listArticleServiceSelected.push(itemID)
                    var block  = $('#modal-lg-article-service .ul-item.'+itemID);
                    var image  = $('#modal-lg-article-service .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-article-service .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_post_service[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-article-service-list').append(html)
                }
            });
            $('#modal-lg-article-service').modal('hide');

        });

        $("body").on("click", '.addappliesto.post_hot', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';

            $("#modal-lg-post-hot input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listPostHotSelected);

                if(!is){
                    self.listPostHotSelected.push(itemID)
                    var block  = $('#modal-lg-post-hot .ul-item-post-hot.'+itemID);
                    var image  = $('#modal-lg-post-hot .ul-item-post-hot.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-post-hot .ul-item-post-hot.'+itemID + ' span.text').text();
                    html = '<li class="ul-item-post-hot '+itemID+'">\
                                <input type="hidden" name="related_post_hot[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-post-hot-list').append(html)
                }
            });
            $('#modal-lg-post-hot').modal('hide');

        });

        $("body").on("click", '.addappliesto.slider', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-slider input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listSliderSelected);
                if(!is){
                    self.listSliderSelected.push(itemID)
                    var block  = $('#modal-lg-slider .ul-item.'+itemID);
                    var image  = $('#modal-lg-slider .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-slider .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_slider[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-slider-list').append(html)
                }
            });
            $('#modal-lg-slider').modal('hide');

        });

        $("body").on("click", '.addappliesto.team', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-team input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listTeamSelected);
                if(!is){
                    self.listTeamSelected.push(itemID)
                    var block  = $('#modal-lg-team .ul-item.'+itemID);
                    var image  = $('#modal-lg-team .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-team .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_team[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-team-list').append(html)
                }
            });
            $('#modal-lg-team').modal('hide');

        });

        $("body").on("click", '.addappliesto.partner', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-partner input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listPartnerSelected);
                if(!is){
                    self.listPartnerSelected.push(itemID)
                    var block  = $('#modal-lg-partner .ul-item.'+itemID);
                    var image  = $('#modal-lg-partner .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-partner .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_partner[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-partner-list').append(html)
                }
            });
            $('#modal-lg-partner').modal('hide');

        });

        $("body").on("click", '.addappliesto.hot', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-hot input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listHotSelected);
                if(!is){
                    self.listHotSelected.push(itemID)
                    var block  = $('#modal-lg-hot .ul-item.'+itemID);
                    var image  = $('#modal-lg-hot .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-hot .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_hot[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-hot-list').append(html)
                }
            });
            $('#modal-lg-hot').modal('hide');

        });

        $("body").on("click", '.addappliesto.hot', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-hot2 input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listHotSelected2);
                if(!is){
                    self.listHotSelected2.push(itemID)
                    var block  = $('#modal-lg-hot2 .ul-item.'+itemID);
                    var image  = $('#modal-lg-hot2 .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-hot2 .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_hot_2[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-hot-2-list').append(html)
                }
            });
            $('#modal-lg-hot2').modal('hide');

        });

        $("body").on("click", '.addappliesto.endow', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-endow input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listEndowSelected);
                if(!is){
                    self.listEndowSelected.push(itemID)
                    var block  = $('#modal-lg-endow .ul-item.'+itemID);
                    var image  = $('#modal-lg-endow .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-endow .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_endow[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-endow-list').append(html)
                }
            });
            $('#modal-lg-endow').modal('hide');

        });

        $("body").on("click", '.addappliesto.certify', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-certify input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listCertifySelected);
                if(!is){
                    self.listCertifySelected.push(itemID)
                    var block  = $('#modal-lg-certify .ul-item.'+itemID);
                    var image  = $('#modal-lg-certify .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-certify .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_certify[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-certify-list').append(html)
                }
            });
            $('#modal-lg-certify').modal('hide');

        });

        $("body").on("click", '.addappliesto.tv', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-tv input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listTvSelected);
                if(!is){
                    self.listTvSelected.push(itemID)
                    var block  = $('#modal-lg-tv .ul-item.'+itemID);
                    var image  = $('#modal-lg-tv .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-tv .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_tv[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-tv-list').append(html)
                }
            });
            $('#modal-lg-tv').modal('hide');

        });

        $("body").on("click", '.addappliesto.newspaper', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-newspaper input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listNewspaperSelected);
                if(!is){
                    self.listNewspaperSelected.push(itemID)
                    var block  = $('#modal-lg-newspaper .ul-item.'+itemID);
                    var image  = $('#modal-lg-newspaper .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-newspaper .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_newspaper[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-newspaper-list').append(html)
                }
            });
            $('#modal-lg-newspaper').modal('hide');

        });

        $("body").on("click", '.addappliesto.banner', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-banner input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listBannerSelected);
                if(!is){
                    self.listBannerSelected.push(itemID)
                    var block  = $('#modal-lg-banner .ul-item.'+itemID);
                    var image  = $('#modal-lg-banner .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-banner .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_banner[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-banner-list').append(html)
                }
            });
            $('#modal-lg-banner').modal('hide');

        });

        $("body").on("click", '.addappliesto.about', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-about input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listAboutSelected);
                if(!is){
                    self.listAboutSelected.push(itemID)
                    var block  = $('#modal-lg-about .ul-item.'+itemID);
                    var image  = $('#modal-lg-about .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-about .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_about[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-about-list').append(html)
                }
            });
            $('#modal-lg-about').modal('hide');

        });

        $("body").on("click", '.addappliesto.album', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-album input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listAlbumSelected);
                if(!is){
                    self.listAlbumSelected.push(itemID)
                    var block  = $('#modal-lg-album .ul-item.'+itemID);
                    var image  = $('#modal-lg-album .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-album .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_album[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-album-list').append(html)
                }
            });
            $('#modal-lg-album').modal('hide');

        });

        $("body").on("click", '.addappliesto.video', function (e) {
            var listValue = '';
            var itemID = 0;
            var block = '';
            var html = '';
            $("#modal-lg-video input[type=checkbox]:checked").each(function() {
                var itemID = this.value;
                var is = isInArray(itemID, self.listVideoSelected);
                if(!is){
                    self.listVideoSelected.push(itemID)
                    var block  = $('#modal-lg-video .ul-item.'+itemID);
                    var image  = $('#modal-lg-video .ul-item.'+itemID + ' img').attr('src');
                    var title  = $('#modal-lg-video .ul-item.'+itemID + ' span.text').text();
                    html = '<li class="ul-item '+itemID+'">\
                                <input type="hidden" name="related_video[]" value="'+itemID+'">\
                                <!-- drag handle -->\
                                <span class="handle">\
                                  <i class="fas fa-ellipsis-v"></i>\
                                  <i class="fas fa-ellipsis-v"></i>\
                                </span>\
                                <img width="40px" height="40px" src="'+image+'">\
                                <span class="text">\
                                    <a href="">'+title+'</a>\
                                </span>\
                                <div class="tools">\
                                    <div class="remove-item__action" itemID="'+itemID+'"><i class="fas fa-trash"></i></div>\
                                </div>\
                            </li>';
                    $('.appliesto-value.block-video-list').append(html)
                }
            });
            $('#modal-lg-video').modal('hide');

        });

    },
    removeGallery : function(itemID,isSendAjax){
        $('.appliesto-value.block-gallery-list .ul-item.'+itemID).remove();
    },
    removeArticle : function(itemID,isSendAjax){
        $('.appliesto-value.block-article-list .ul-item.'+itemID).remove();
    },
    removeProduct : function(itemID,isSendAjax){
        $('.appliesto-value.block-product-list .ul-item.'+itemID).remove();
    },
	removeProductHot : function(itemID,isSendAjax){
        $('.appliesto-value.block-product-hot-list .ul-item-product-hot.'+itemID).remove();
    },
	removeProductSale : function(itemID,isSendAjax){
        $('.appliesto-value.block-product-sale-list .ul-item-product-sale.'+itemID).remove();
    },
	removeProductSelling : function(itemID,isSendAjax){
        $('.appliesto-value.block-product-selling-list .ul-item-product-selling.'+itemID).remove();
    },
    removeArticleService : function(itemID,isSendAjax){
        $('.appliesto-value.block-article-service-list .ul-item.'+itemID).remove();
    },
    removeSlider : function(itemID,isSendAjax){
        $('.appliesto-value.block-slider-list .ul-item.'+itemID).remove();
    },
    removeTeam : function(itemID,isSendAjax){
        $('.appliesto-value.block-team-list .ul-item.'+itemID).remove();
    },
    removePartner : function(itemID,isSendAjax){
        $('.appliesto-value.block-partner-list .ul-item.'+itemID).remove();
    },
    removeEndow : function(itemID,isSendAjax){
        $('.appliesto-value.block-endow-list .ul-item.'+itemID).remove();
    },
    removeTv : function(itemID,isSendAjax){
        $('.appliesto-value.block-tv-list .ul-item.'+itemID).remove();
    },
    removeNewspaper : function(itemID,isSendAjax){
        $('.appliesto-value.block-newspaper-list .ul-item.'+itemID).remove();
    },
    removeCertify : function(itemID,isSendAjax){
        $('.appliesto-value.block-certify-list .ul-item.'+itemID).remove();
    },
    removeHot : function(itemID,isSendAjax){
        $('.appliesto-value.block-hot-list .ul-item.'+itemID).remove();
    },
    removeHot2 : function(itemID,isSendAjax){
        $('.appliesto-value.block-hot-2-list .ul-item.'+itemID).remove();
    },
    removeBanner : function(itemID,isSendAjax){
        $('.appliesto-value.block-banner-list .ul-item.'+itemID).remove();
    },
    removeAbout : function(itemID,isSendAjax){
        $('.appliesto-value.block-about-list .ul-item.'+itemID).remove();
    },
    removeAlbum : function(itemID,isSendAjax){
        $('.appliesto-value.block-album-list .ul-item.'+itemID).remove();
    },
    removeVideo : function(itemID,isSendAjax){
        $('.appliesto-value.block-video-list .ul-item.'+itemID).remove();
    },

    setSelected : function(newSelected){
        this.listGallerySelected    = listGallerySelected;
        this.listArticleSelected    = listArticleSelected;
        this.listProductSelected    = listProductSelected;
		this.listProductHotSelected     = listProductHotSelected;
		this.listProductNewSelected     = listProductNewSelected;
		this.listProductSaleSelected    = listProductSaleSelected;
		this.listProductSellingSelected    = listProductSellingSelected;
        this.listArticleServiceSelected    = listArticleServiceSelected;
        this.listPostHotSelected    = listPostHotSelected;
        this.listSliderSelected     = listSliderSelected;
        this.listTeamSelected       = listTeamSelected;
        this.listPartnerSelected    = listPartnerSelected;
        this.listEndowSelected    = listEndowSelected;
        this.listCertifySelected    = listCertifySelected;
        this.listTvSelected         = listTvSelected;
        this.listBannerSelected    = listBannerSelected;
        this.listHotSelected    = listHotSelected;
        this.listHotSelected2    = listHotSelected2;
        this.listAlbumSelected = listAlbumSelected;
        this.listAboutSelected = listAboutSelected;
        this.listVideoSelected = listVideoSelected;
        this.listNewspaperSelected = listNewspaperSelected;
    },

    searchGallery : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listGallerySelected;
        $.ajax({
            type: "GET",
            url: '/admin/Gallery/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-gallery").modal()
                    }else{
                        $("#modal-lg-gallery .block-gallery-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchArticle : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listArticleSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Post/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-article").modal()
                    }else{
                        $("#modal-lg-article .block-article-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchArticleHot : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listPostHotSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Post/searchRelativeHot',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-post-hot").modal()
                    }else{
                        $("#modal-lg-post-hot .block-post-hot-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchProduct : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listProductSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Product/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-product").modal()
                    }else{
                        $("#modal-lg-product .block-product-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchProductNew : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listProductNewSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Product/searchRelativeNew',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-product-new").modal()
                    }else{
                        $("#modal-lg-product-new .block-product-new-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                console.log(error);
                // alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

	searchProductHot : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listProductHotSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Product/searchRelativeHot',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-product-hot").modal()
                    }else{
                        $("#modal-lg-product-hot .block-product-hot-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

	searchProductSale : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listProductSaleSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Product/searchRelativeSale',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-product-sale").modal()
                    }else{
                        $("#modal-lg-product-sale .block-product-sale-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

	searchProductSelling : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listProductSellingSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Product/searchRelativeSelling',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-product-selling").modal()
                    }else{
                        $("#modal-lg-product-selling .block-product-selling-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchArticleService : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listArticleServiceSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Post/searchRelativeService',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-article-service").modal()
                    }else{
                        $("#modal-lg-article-service .block-article-service-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchSlider : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listSliderSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Slider/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-slider").modal()
                    }else{
                        $("#modal-lg-slider .block-slider-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchTeam : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listTeamSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Team/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-team").modal()
                    }else{
                        $("#modal-lg-team .block-team-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchPartner : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listPartnerSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Partner/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-partner").modal()
                    }else{
                        $("#modal-lg-partner .block-partner-list").html(response.message)
                    }
                }
            },
            error: function (error) {
             alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },


    searchHot : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listHotSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Hot/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-hot").modal()
                    }else{
                        $("#modal-lg-hot .block-hot-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchHot2 : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listHotSelected2;
        $.ajax({
            type: "GET",
            url: '/admin/Hot/searchRelative2',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-hot2").modal()
                    }else{
                        $("#modal-lg-hot2 .lock-hot-list-2").html(response.message)
                    }
                }
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchEndow : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listEndowSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Endow/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-endow").modal()
                    }else{
                        $("#modal-lg-endow .block-endow-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchTv : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listTvSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Tv/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-tv").modal()
                    }else{
                        $("#modal-lg-tv .block-tv-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchAbout : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listAboutSelected;
        $.ajax({
            type: "GET",
            url: '/admin/About/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-about").modal()
                    }else{
                        $("#modal-lg-about .block-about-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                console.log(error)
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchAlbum : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listAlbumSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Album/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-album").modal()
                    }else{
                        $("#modal-lg-album .block-album-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                console.log(error)
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchVideo : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listVideoSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Video/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-video").modal()
                    }else{
                        $("#modal-lg-video .block-video-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                console.log(error)
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchNewspaper : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listNewspaperSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Newspaper/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-newspaper").modal()
                    }else{
                        $("#modal-lg-newspaper .block-newspaper-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchBanner : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listBannerSelected;
        $.ajax({
            type: "GET",
            url: '/admin/Banner/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-banner").modal()
                    }else{
                        $("#modal-lg-banner .block-banner-list").html(response.message)
                    }
                }
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },

    searchCertify : function(block,isAppendModal){
        var sendData = {};
        sendData.q = $('.block-search-appliesto.'+block + ' input').val();
        sendData.isAppendModal = isAppendModal;
        sendData.notFindID = this.listCertifySelected;
        $.ajax({
            type: "GET",
            url: '/admin/Certify/searchRelative',
            data: sendData,
            dataType: 'JSON',
            success: function (response) {
                html = '';
                var msg = response.message;
                if(response.status){
                    if(!isAppendModal){
                        $('body').append(response.message);
                        $("#modal-lg-certify").modal()
                    }else{
                        $("#modal-lg-certify .block-certify--list").html(response.message)
                    }
                }
            },
            error: function (error) {
                alert('Không thể tải lên dữ liệu. Vui lòng thử lại.')
            }
        });
    },
}

$(function() {
	Discount.ini()
});
