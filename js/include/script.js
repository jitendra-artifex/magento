// Set pixelRatio to 1 if the browser doesn't offer it up.
var pixelRatio = !!window.devicePixelRatio ? window.devicePixelRatio : 1;
jQuery(window).on("load", function() {
    if (pixelRatio > 1) {
        var elements = {
            sort: jQuery('.sorter .sort-order a img'),
            page_next: jQuery('.pager .pages li a.next img'),
            page_prev: jQuery('.pager .pages li a.previous img'),
            zoom_out: jQuery('#zoom_out'),
            zoom_in: jQuery('#zoom_in')
        };
        for (var key in elements) {
            if (elements[key].length) {
                elements[key]
                    .width(elements[key].width())
                    .height(elements[key].height())
                    .attr('src', elements[key].attr('src').replace(".gif","@2x.png"));
            }
        }
        //product images
        jQuery('img[data-srcX2]').each(function(){
            jQuery(this).attr('src',jQuery(this).attr('data-srcX2'));
        });
        //custom block images.
        jQuery('img.retina').each(function(){
            var file_ext = jQuery(this).attr('src').split('.').pop();
            jQuery(this)
                .width(jQuery(this).width())
                .height(jQuery(this).height())
                .attr('src',jQuery(this).attr('src').replace("."+file_ext,"_2x."+file_ext));
        });
    }
    //ipad and iphone fix
    if((navigator.userAgent.match(/iPhone/i)) || (navigator.userAgent.match(/iPod/i)) || (navigator.userAgent.match(/iPad/i))) {
        jQuery("#queldoreiNav li a").on({
            click: function () {
                if ( !jQuery(this).hasClass('touched') && jQuery(this).siblings('div') ) {
                    jQuery('#queldoreiNav a').removeClass('touched');
                    jQuery(this).parents('li').children('a').addClass('touched');
                    jQuery(this).addClass('touched');
                    return false;
                }
            }
        });
        jQuery("#nav li a").on({
            click: function () {
                if ( !jQuery(this).hasClass('touched') && jQuery(this).siblings('ul') ) {
                    jQuery('#nav a').removeClass('touched');
                    jQuery(this).parents('li').children('a').addClass('touched');
                    jQuery(this).addClass('touched');
                    return false;
                }
            }
        });
        jQuery('.header-switch, .toolbar-switch').on({
            click: function (e) {
                jQuery(this).addClass('over');
                return false;
            }
        });

    }

    jQuery(window).resize().scroll();
});

jQuery.fn.extend({
    scrollToMe: function () {
        var x = jQuery(this).offset().top - 100;
        jQuery('html,body').animate({scrollTop: x}, 500);
    }});

//actual width
;(function(a){a.fn.extend({actual:function(b,k){var c,d,h,g,f,j,e,i;if(!this[b]){throw'$.actual => The jQuery method "'+b+'" you called does not exist';}h=a.extend({absolute:false,clone:false,includeMargin:undefined},k);d=this;if(h.clone===true){e=function(){d=d.filter(":first").clone().css({position:"absolute",top:-1000}).appendTo("body");};i=function(){d.remove();};}else{e=function(){c=d.parents().andSelf().filter(":hidden");g=h.absolute===true?{position:"absolute",visibility:"hidden",display:"block"}:{visibility:"hidden",display:"block"};f=[];c.each(function(){var m={},l;for(l in g){m[l]=this.style[l];this.style[l]=g[l];}f.push(m);});};i=function(){c.each(function(m){var n=f[m],l;for(l in g){this.style[l]=n[l];}});};}e();j=/(outer)/g.test(b)?d[b](h.includeMargin):d[b]();i();return j;}});})(jQuery);

var sw, sh, scroll_critical,
    breakpoint = 959,
    mobile = false,
    resizeLimits = [0,479,767,959,1199,9999],
    _resizeLimit = {};

isResize = function(limitName){
    var current, w = jQuery(window).width();
    for( i=0; i<resizeLimits.length; i++ ){
        if (w > resizeLimits[i]) {
            current = i;
        } else {
            break;
        }
    }
    if ( _resizeLimit[limitName] === undefined || current != _resizeLimit[limitName] ) {
        _resizeLimit[limitName] = current;
        return true;
    }
    return false;
}

jQuery(function($){
   

    


	    var config = {
        over: function(){
            if (mobile) return;
            if ($(this).hasClass('.toolbar-dropdown')){
                $(this).parent().addClass('over');
                $('.toolbar-dropdown').css({width: $(this).parent().width()+50});
            } else {
                $(this).addClass('over');
                $('.toolbar-dropdown', this).css({width: $(this).width()+50});
            }

            $('.toolbar-dropdown', this).animate({opacity:1, height:'toggle'}, 100);
        },
        timeout: 0, // number = milliseconds delay before onMouseOut
        out: function(){
            if (mobile) return;
            var that = this;
            $('.toolbar-dropdown', this).animate({opacity:0, height:'toggle'}, 100, function(){
                if ($(this).hasClass('.toolbar-dropdown')){
                    $(that).parent().removeClass('over');
                } else {
                    $(that).removeClass('over');
                }
            });
        }
    };
    $('.toolbar-switch, .toolbar-switch .toolbar-dropdown').hoverIntent( config );

   

    //add review link on product page open review tab
    
 });


