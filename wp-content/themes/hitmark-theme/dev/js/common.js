jQuery(document).ready(function ($) {

    let $title = $('.product_list_title');
    $title.each(function () {
        $(this).html($(this).text().replace('µ', '<span class="lowercase">µ</span>'))
    })


    $('j.q-selectbox__select').focusin(function () {
        $(this).closest('.managers_choose').addClass('toup');
    });

    $('#manage').change(function () {
        $(this).blur().parent().removeClass('toup');
    });

    $('.hamburger').click(function () {
        $('.bg').fadeIn(400);
        $('#mobile_menu').fadeIn(450);
    });

    $('.menu_close, .bg').click(function () {
        $('#mobile_menu').fadeOut(400);
        $('.bg').fadeOut(450);
    })

    $('.js-show').click(function () {
        const item = $('.gallery_item');
        let count = 0;
        item.each(function () {
            count++
            if ($(window).width() <= 768) {
                if (count > 3) {
                    if ($(this).hasClass('show')) {
                        $(this).removeClass('show');
                        $(this).css('display', 'none');
                    } else {
                        $(this).addClass('show');
                        $(this).css('display', 'block');
                    }
                } else {
                    $(this).css('display', 'block');
                }
            } else {
                if (count > 6) {
                    if ($(this).hasClass('show')) {
                        $(this).removeClass('show');
                        $(this).css('display', 'none');
                    } else {
                        $(this).addClass('show');
                        $(this).css('display', 'block');
                    }
                } else {
                    $(this).css('display', 'block');
                }
            }
        })


    });

    const text = $('.content_more').text();
    $('.content_more').click(function (event) {
        event.preventDefault();

        $(this).toggleClass('open').closest('.content_wrapper').find('.content_hide').slideToggle(500);
        if ( $(this).hasClass('open') ) {
            $(this).text('pokaż mniej');
        } else {
            $(this).text(text);
        }
    });

    $('.js-open').click(function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).siblings('.js-desc').slideUp(500);
            $(this).find('.product_list_btn').html('<i class="fal fa-plus"></i>');
            $(this).find('.product_list_btn').removeAttr('style');
        } else {
            $(this).addClass('open');
            $(this).siblings('.js-desc').slideDown(500);
            $(this).find('.product_list_btn').html('<i class="fal fa-minus"></i>');
            $(this).find('.product_list_btn').css('border-radius', 0);
        }

    })

    $('#manage').change(function () {
        let postId = $(this).val();
        let data = {action: 'post_filter', 'postId': postId};

        $.ajax({
            url: ajax_web_url,
            data: data,
            type: 'post',
            success: function (response, data) {
                // console.log(response)
                $('#result').html(response);
            },
        });
    });

    // $('.header_btn').click(function (e) {
    //     e.preventDefault();
    //     $.fancybox.open(
    //         {
    //             src: '#form',
    //             type : 'inline',
    //             btnTpl: {
    //                 smallBtn: '<button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="{{CLOSE}}"><img src="/wp-content/uploads/2020/10/close.png" alt="Close"></button>'
    //             }
    //         }
    //     );
    // });

    $("[data-fancybox]").fancybox({
        infobar: false,
        loop: true,
        smallBtn: true,
        toolbar: false,
        btnTpl: {
            smallBtn: '<button type="button" data-fancybox-close class="fancybox-button fancybox-close-small" title="{{CLOSE}}"><i class="fal fa-times"></i></button>',
        },
        afterShow: function () {
            let caps = $('.fancybox-slide--current').parent().siblings('.fancybox-caption').find('.fancybox-caption__body').text()
            $('.fancybox-slide--current').find('.fancybox-content').append('<div class="fancybox-caption-custom">' + caps + '</div>')
        }
    })

    $('.managers_list').styler({
        selectSmartPositioning: -1,
        selectVisibleOptions: 16,
        onSelectOpened: function () {
            $(this).closest('.managers_choose').addClass('toup');
        },
        onSelectClosed: function () {
            $(this).closest('.managers_choose').removeClass('toup');
        }
    })

    $('.managers_choose_arrow').on('click', function(e) {
        e.preventDefault();
        const choose = $(this).closest('.managers_choose');
        if (choose.hasClass('toup')) {
            $(this).siblings('.managers_list').find('.jq-selectbox__dropdown').css('display', 'none').trigger('refresh')
            $(this).closest('.managers_choose').removeClass('toup');
        } else {
            $(this).siblings('.managers_list').find('.jq-selectbox__dropdown').css('display', 'block').trigger('refresh')
            $(this).closest('.managers_choose').addClass('toup');
        }  
    })

    // anchor code
    var $page = $('html, body');
    $('a[href*="#"]').click(function () {
        event.preventDefault();
        $page.animate({
            scrollTop: $($.attr(this, 'href')).offset().top
        }, 1000);
        return false;
    });

   const textMore = $('.post_more_btn').text();
    $('.post_more_btn').on('click', function() {
        $(this).toggleClass('open')
        if ( $(this).hasClass('open') ) {
            $(this).text('pokaż mniej')
        } else {
            $(this).text(textMore);
        }
        let div = $(this).closest('.post_more').siblings('.product_chars').find('.product_chars_wrap')
       $.each(div, function(index, value) {
           if (index > 4) {
               $(value).slideToggle(500)
           }
       })
    })
})