$(document).ready(function() {
	run_trigger();
	seo_keyup();

	/* Seo */
	var seo_title_val = $('[name=seo_title]').val();
	var seo_description_val = $('[name=seo_desciption]').val();
	$("#validatetitleseo").html( 0 );
	$("#validateseomota").html( 0 );

	if( $("#validateseomota").length ) {
		if( seo_title_val.length > 0 ) {
			$("#validatetitleseo").html( seo_title_val.length );
		}
	}

	if( $("#validateseomota").length ) {
		if( seo_description_val.length > 0 ) {
			$("#validateseomota").html( seo_description_val.length );
		}
	}

	/* Clone thumbnail */
	var count_item = 1;
	var update_count_item = $('.btn-clone-thumbnail').data('count');
	if( update_count_item ) {
		count_item = update_count_item;
	}

	$('.btn-clone-thumbnail').on('click', function() {
		var html = $(".area-clone-thumbnail-cli").html();
		html	 = html.replace(/number/g, count_item);

      	$(".increment-thumbnail").append(html);

      	$('.btn-remove-thumbnail').on('click', function() {
			$(this).parents(".clone-thumbnail-cli").remove();
		});

		$('[class*="lfm-mul"]').each(function() {
	        $(this).filemanager('file');
	    });

		count_item++;
	});

    /* Clone Product */
    $('.btn-clone-product').on('click', function() {
        var html = $(".area-clone-product-cli").html();
        $(".increment-product").append(html);

        $('.btn-remove-product').on('click', function() {
            $(this).parents(".clone-product-cli").remove();
        });
    });

	/* Clone Video */
	$('.btn-clone-video').on('click', function() {
		var html = $(".area-clone-video-cli").html();
      	$(".increment-video").append(html);

      	$('.btn-remove-video').on('click', function() {
			$(this).parents(".clone-video-cli").remove();
		});
	});

	/* Clone Funfact */
	$('.btn-clone-funfact').on('click', function() {
		var html = $(".area-clone-funfact-cli").html();
      	$(".increment-funfact").append(html);

      	$('.btn-remove-funfact').on('click', function() {
			$(this).parents(".clone-funfact-cli").remove();
		});
	});

	/* Clone Why */
	$('.btn-clone-why').on('click', function() {
		var html = $(".area-clone-why-cli").html();
      	$(".increment-why").append(html);

      	$('.btn-remove-why').on('click', function() {
			$(this).parents(".clone-why-cli").remove();
		});
	});

	$('.btn-clone-services').on('click', function() {
		var html = $(".clone-services-area").html();
      	$(".increment-services").append(html);

      	$('.btn-remove-service').on('click', function() {
			$(this).parents(".clone-service-cli").remove();
		});
	});

	/* Checked Icon Default Social */
	$('.form-social input[name=icon_default]').on('switchChange.bootstrapSwitch', function(event, state) {
	    if (state)
	    {
	        $('.form-social .icon_default_hide').hide();
	        $('.form-social #holder').empty();
	        $('.form-social .icon-default-required').val('');
	        $('.form-social .icon-default-required').removeAttr('required');
	    }else
	    {
	        $('.form-social .icon_default_hide').show();
	        $('.form-social .icon-default-required').attr("required", true);
	    }
	});

	if( $('.form-social input[name=icon_default]').is(':checked') ){
	  	$('.icon_default_hide').hide();
        $('#holder').empty();
        $('.icon-default-required').val('');
        $('.icon-default-required').removeAttr('required');
	}

	$('.form-social [name=select_link]').on('change', function() {
		var select_link = this.value;
		if( select_link == 4 ) {
			$('.form-social [name=link]').val('');
			$('.form-social [name=link]').attr('disabled', 'disabled');
		}else {
			$('.form-social [name=link]').removeAttr("disabled");
		}
	});

	/* Remove Text Info */
	$('#modal-lg-show-info').on('hidden.bs.modal', function () {
	  	$('#modal-lg-show-info .modal-title').empty();
        $('#modal-lg-show-info .modal-body').empty();
	});
});

function seo_keyup() {
	$("[name=seo_title]").keyup(function(){
		$("#validatetitleseo").html($(this).val().length);
		if($(this).val().length>60){
	        //$("#seotitleerror").show();
	        $("#seotitleerror .change-text").text('Không chuẩn SEO');
	    }
	    else
	    {
	        //$("#seotitleerror").hide();
	        $("#seotitleerror .change-text").text('Chuẩn SEO');
	    }
	});

	$("[name=seo_desciption]").keyup(function(){
		$("#validateseomota").html($(this).val().length);
	    if($(this).val().length>160){
	        //$("#seodeserror").show();
	       $("#seodeserror .change-text").text('Không chuẩn SEO');
	    }
	    else
	    {
	        //$("#seodeserror").hide();
	        $("#seodeserror .change-text").text('Chuẩn SEO');
	    }
	});
}

function run_trigger() {
	var options = {
	    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
	    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
	    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
	    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
	};
	$('#lfm').filemanager('file');

	$('[class*="lfm-mul"]').each(function() {
        $(this).filemanager('file');
    });

	if( $('#sapo').length ) {
      	CKEDITOR.replace('sapo', options);
  	}
  	if( $('#description').length ) {
      	CKEDITOR.replace('description', options);
  	}
	if( $('.ckeditor-lfm').length ) {
      	$('.ckeditor-lfm').ckeditor(options);
  	}

  	$('.btn-remove-thumbnail').on('click', function() {
		$(this).parents(".clone-thumbnail-cli").remove();
	});

	$('.btn-remove-video').on('click', function() {
		$(this).parents(".clone-video-cli").remove();
	});

    $('.btn-remove-product').on('click', function() {
        $(this).parents(".clone-product-cli").remove();
    });

	$('.btn-remove-funfact').on('click', function() {
		$(this).parents(".clone-funfact-cli").remove();
	});

	$('.btn-remove-why').on('click', function() {
		$(this).parents(".clone-why-cli").remove();
	});
    $('.btn-remove-service').on('click', function() {
        $(this).parents(".clone-service-cli").remove();
    });


	$("input[data-bootstrap-switch]").each(function(){
      	$(this).bootstrapSwitch('state', $(this).prop('checked'));
    });

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' });
    $('[data-mask]').inputmask();

    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
    $('.custom-select').select2();
    $('.select-change-agency').select2();
    $('.change-status-order').select2();

    $('.add-date-time span i').on('click', function() {
        var html = $(".clone-day-time").html();
        $(".list-date-time").append(html);

        $('.select-day-schema').select2();
        $(".time_open").datetimepicker({format: 'HH:mm:ss'});
        $(".time_close").datetimepicker({format: 'HH:mm:ss'});
    });

    $(".time_open").datetimepicker({format: 'HH:mm:ss'});
    $(".time_close").datetimepicker({format: 'HH:mm:ss'});

    $('.add-breadcrum').on('click', function() {
        var html = $(".clone-breadcrum").html();
        $(".list-breadcrum").append(html);

        $('.close-item-breadcrum').on('click', function() {
            $(this).parents(".breadcrum-item").remove();
        });
    });

    $('.close-item-breadcrum').on('click', function() {
        $(this).parents(".breadcrum-item").remove();
    });

    $('.add-question').on('click', function() {
        var html = $(".clone-question").html();
        $(".list-question").append(html);

        $('.close-item-question').on('click', function() {
            $(this).parents(".question-item").remove();
        });
    });

    $('.close-item-question').on('click', function() {
        $(this).parents(".question-item").remove();
    });

    $('.add-qa').on('click', function() {
        var html = $(".clone-qa").html();
        $(".list-qa").append(html);
        $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});

        $('.close-item-qa').on('click', function() {
            $(this).parents(".qa-item").remove();
        });
    });

    $('.add-tutorial').on('click', function() {
        var html = $(".clone-tutorial").html();
        $(".list-tutorial").append(html);

        $('.close-item-tutorial').on('click', function() {
            $(this).parents(".tutorial-item").remove();
        });
    });

    $('.close-item-qa').on('click', function() {
        $(this).parents(".qa-item").remove();
    });

    $('.close-item-tutorial').on('click', function() {
        $(this).parents(".tutorial-item").remove();
    });

    $('.btn-clone-color').on('click', function() {
        var html = $(".area-clone-color-cli").html();

        $(".increment-color").append(html);

        $('.btn-remove-color').on('click', function() {
            $(this).parents(".clone-color-cli").remove();
        });
    });

    $('.btn-remove-color').on('click', function() {
        $(this).parents(".clone-color-cli").remove();
    });


    $('.btn-clone-material').on('click', function() {
        var html = $(".area-clone-material-cli").html();

        $(".increment-material").append(html);

        $('.btn-remove-material').on('click', function() {
            $(this).parents(".clone-material-cli").remove();
        });
    });

    $('.btn-remove-material').on('click', function() {
        $(this).parents(".clone-material-cli").remove();
    });

    $(".begin_guarantee").datepicker({format: 'dd/mm/yyyy'});
    $(".end_guarantee").datepicker({format: 'dd/mm/yyyy'});

}
