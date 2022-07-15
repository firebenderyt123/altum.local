jQuery(function($) {
	var canBeLoaded = true;
	var bottomOffset = 2000;

	$(document).ready(function() {
		ajax_load();
	});

	$(window).scroll(function() {
		if( $(document).scrollTop() > ( $(document).height() - bottomOffset ) ) {
			ajax_load();
		}
	});


    // $('.taxonomy-list select').change(function() {
    //     let filters_select = [];
    //     let filters = [];

    //     $(".taxonomy-list select").each(function() {
    //         if ( !$(this).val().includes('--') ) {
    //             filters.push({
    //                 'taxonomy': $(this).find(">:first-child").attr('name'),
    //                 'terms': [ $(this).val() ]
    //             });
    //         }
    //     });

    //     loadmore_params.current_page = 0;
    //     $('.cards > *').remove();
    //     canBeLoaded = true;

    //     ajax_load(filters);
    // });

    //filters = [ {'taxonomy': string, 'terms': []} ]
	function ajax_load( filters = null, orderby = 'title', order = 'ASC' ) {
        if (canBeLoaded) {
    		var data = {
    			'action': 'loadmore',
                'filters': filters,
                'orderby': orderby,
                'order': order,
    			'query': loadmore_params.posts,
    			'page' : loadmore_params.current_page + 1
    		};
    		$.ajax({
    			url : loadmore_params.ajaxurl,
    			data: data,
    			type: 'POST',
    			beforeSend: function( xhr ) {
    				canBeLoaded = false; 
    			},
    			success: function( data ) {
    				if( data ) {
    					$('.cards').append( data );
    					canBeLoaded = true;
    					loadmore_params.current_page++;
    				} else
                        canBeLoaded = false;
    			}
    		});
        }
	}


    $('.taxonomy-list .item').click(function() {
        $(this).parent().find('.selected').removeClass('selected');
        $(this).parent().parent().find('.select-styled').text( $(this).text() );
        $(this).addClass('selected');
        change_state( $(this).parent() );

        let filters_select = [];
        let filters = [];

        $(".taxonomy-list .selected").each(function() {
            if ( $(this).attr('rel') != $(this).parent().find('.item:nth-of-type(1)').attr('rel') ) {
                filters.push({
                    'taxonomy': $(this).parent().find('.item:nth-of-type(1)').attr('rel'),
                    'terms': [ $(this).attr('rel') ]
                });
            }
        });

        loadmore_params.current_page = 0;
        $('.cards > *').remove();
        canBeLoaded = true;

        ajax_load(filters);
    });



    // open / close filters
    $('.filter-icon > a').click(function(e) {
        e.preventDefault();

        sidebar_filters_opened = !sidebar_filters_opened;
        if (sidebar_filters_opened) {
            $('.filters').addClass('opened');
        } else {
            $('.filters').removeClass('opened');
        }
    });

    // selector on click
    $('.select-styled').click(function() {
        change_state( $(this).parent().find('.select-options') );
    });

    // set visible / invisible select block
    function change_state( elem ) {
        if ( elem.is(":visible") )
            elem.removeClass('select-active');
        else
            elem.addClass('select-active');
    }

    // close select when click anywhere (not on select)
    $(document).mouseup(function (e) {
        var container = $('.select-active');
        if (container.has(e.target).length === 0) {
            change_state(container);
        }
    });

    // $('select').each(function() {
    //     var $this = $(this), numberOfOptions = $(this).children('option').length;
      
    //     $this.addClass('select-hidden'); 
    //     $this.wrap('<div class="custom-select"></div>');
    //     $this.after('<div class="select-styled"></div>');

    //     var $styledSelect = $this.next('div.select-styled');
    //     $styledSelect.text($this.children('option').eq(0).text());
      
    //     var $list = $('<div/>', {
    //         'class': 'select-options'
    //     }).insertAfter($styledSelect);
      
    //     for (var i = 0; i < numberOfOptions; i++) {
    //         $('<div>', {
    //             text: $this.children('option').eq(i).text(),
    //             rel: $this.children('option').eq(i).val(),
    //             class: 'item'
    //         }).appendTo($list);
    //     }
      
    //     var $listItems = $list.children('div.item');
      
    //     $styledSelect.click(function(e) {
    //         e.stopPropagation();
    //         $('div.select-styled.active').not(this).each(function(){
    //             $(this).removeClass('active').next('div.select-options').hide();
    //         });
    //         $(this).toggleClass('active').next('div.select-options').toggle();
    //     });
      
    //     $listItems.click(function(e) {
    //         e.stopPropagation();
    //         $styledSelect.text($(this).text()).removeClass('active');
    //         $this.val($(this).attr('rel'));
    //         $list.hide();
    //         //console.log($this.val());
    //     });
      
    //     $(document).click(function() {
    //         $styledSelect.removeClass('active');
    //         $list.hide();
    //     });

    // });

});