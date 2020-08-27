jQuery(document).ready(function($) {
        'use strict';
        jQuery(window).scroll(function() {
                if(jQuery(this).scrollTop()>170) {
                    jQuery('body').addClass("ereaders-sticky");
                }
                else {
                    jQuery('body').removeClass("ereaders-sticky");
                }
            }
        );
        jQuery('.ereaders-banner').slick( {
                slidesToShow:1, slidesToScroll:1, autoplay:true, autoplaySpeed:2000, infinite:true, dots:false, arrows:false, fade:true, responsive:[ {
                    breakpoint:1024, settings: {
                        slidesToShow: 1, slidesToScroll:1, infinite:true,
                    }
                }
                    , {
                        breakpoint:800, settings: {
                            slidesToShow: 1, slidesToScroll:1
                        }
                    }
                    , {
                        breakpoint:400, settings: {
                            slidesToShow: 1, slidesToScroll:1
                        }
                    }
                ]
            }
        );
        jQuery('.ereaders-partner-slider').slick( {
                slidesToShow:4, slidesToScroll:1, autoplay:true, autoplaySpeed:2000, infinite:true, dots:false, arrows:false, responsive:[ {
                    breakpoint:1024, settings: {
                        slidesToShow: 3, slidesToScroll:1, infinite:true,
                    }
                }
                    , {
                        breakpoint:800, settings: {
                            slidesToShow: 3, slidesToScroll:1
                        }
                    }
                    , {
                        breakpoint:400, settings: {
                            slidesToShow: 1, slidesToScroll:1
                        }
                    }
                ]
            }
        );
        jQuery('.ereaders-certify-slider').slick( {
                slidesToShow:5, slidesToScroll:1, autoplay:true, autoplaySpeed:2000, infinite:true, dots:false, arrows:false, responsive:[ {
                    breakpoint:1024, settings: {
                        slidesToShow: 3, slidesToScroll:1, infinite:true,
                    }
                }
                    , {
                        breakpoint:800, settings: {
                            slidesToShow: 3, slidesToScroll:1
                        }
                    }
                    , {
                        breakpoint:400, settings: {
                            slidesToShow: 1, slidesToScroll:1
                        }
                    }
                ]
            }
        );
        jQuery(function() {
                var austDay=new Date();
                austDay=new Date(austDay.getFullYear()+1, 1-1, 26);
                jQuery('#ereaders-countdown').countdown( {
                        until: austDay
                    }
                );
                jQuery('#year').text(austDay.getFullYear());
            }
        );
        jQuery('.ereaders-testimonial-slide').slick( {
                slidesToShow:1, slidesToScroll:1, autoplay:true, autoplaySpeed:2000, infinite:true, dots:true, prevArrow:"<span class='slick-arrow-left'><i class='fa fa-angle-left'></i></span>", nextArrow:"<span class='slick-arrow-right'><i class='fa fa-angle-right'></i></span>", responsive:[ {
                    breakpoint:1024, settings: {
                        slidesToShow: 1, slidesToScroll:1, infinite:true,
                    }
                }
                    , {
                        breakpoint:800, settings: {
                            slidesToShow: 1, slidesToScroll:1
                        }
                    }
                    , {
                        breakpoint:400, settings: {
                            slidesToShow: 1, slidesToScroll:1
                        }
                    }
                ]
            }
        );
        $(function() {
                $('[data-toggle="tooltip"]').tooltip()
            }
        )
        $(function() {
                $("#slider-range").slider( {
                        range:true, min:0, max:200, values:[30, 100], slide:function(event, ui) {
                            $("#amount").val("$"+ui.values[0]+" - $"+ui.values[1]);
                        }
                    }
                );
                $("#amount").val("$"+$("#slider-range").slider("values", 0)+ " - $"+$("#slider-range").slider("values", 1));
            }
        );
        jQuery('.progressbar1').progressBar( {
                percentage: false, animation:true, backgroundColor:"#ececec", barColor:"#00aff0", height:"8",
            }
        );
        jQuery('.ereaders-shop-thumb').slick( {
                slidesToShow: 1, autoplay:false, slidesToScroll:1, arrows:false, fade:true, asNavFor:'.ereaders-shop-thumb-list'
            }
        );
        jQuery('.ereaders-shop-thumb-list').slick( {
                slidesToShow:4, slidesToScroll:1, autoplay:false, asNavFor:'.ereaders-shop-thumb', dots:false, arrows:false, vertical:true, centerMode:false, focusOnSelect:true, responsive:[
                    {
                        breakpoint:1024, settings: {
                            slidesToShow: 4, slidesToScroll:1, infinite:true, vertical:true,
                        }
                    },
                    {
                        breakpoint:992, settings: {
                            slidesToShow: 3, slidesToScroll:1, infinite:true, vertical:true,
                        }
                    }
                    , {
                        breakpoint:768, settings: {
                            slidesToShow: 5, slidesToScroll:1, vertical:false,
                        }
                    }
                    , {
                        breakpoint:400, settings: {
                            slidesToShow: 3, slidesToScroll:1, vertical:false,
                        }
                    }
                ],
            }
        );

        jQuery(".fancybox").fancybox( {
                openEffect: 'elastic', closeEffect:'elastic',
            }
        );
    }

);

$(function() {
        $('body').addClass('js');
        var $menu=$('#menu'), $menulink=$('.menu-link'), $menuTrigger=$('.has-subnav');
        $menulink.on("click", function(e) {
                e.preventDefault();
                $menulink.toggleClass('active');
                $menu.toggleClass('active');
            }
        );
        $menuTrigger.on("click", function(e) {
                e.preventDefault();
                var $this=$(this);
                $this.toggleClass('active').next('ul').toggleClass('active');
            }
        );
    }

);
jQuery(window).on('load', function() {
        jQuery('.grid').isotope( {
                itemSelector:'.grid-item', percentPosition:true, masonry: {
                    fitWidth: true
                }
            }
        );
    }

);
$('.myform').on('submit', function() {
        $('.output_message').text('Loading...');
        var form=$(this);
        $.ajax( {
                url:form.attr('action'), method:form.attr('method'), data:form.serialize(), success:function(result) {
                    if(result=='success') {
                        $('.output_message').html('<span class="success-msg"><i class="fa fa-check-circle"></i> Message Sent successfully!</span>');
                    }
                    else if(result=='validate') {
                        $('.output_message').html('<span class="spam-error-msg"><i class="fa fa-warning"></i> You have already sent message. Try again after one hour.</span>');
                    }
                    else {
                        $('.output_message').html('<span class="error-msg"><i class="fa fa-times-circle"></i> Error Sending email!</span>');
                    }
                }
            }
        );
        return false;
    }

);
