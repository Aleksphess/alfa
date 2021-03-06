/*
AutoComplite Plugin
*/
// jQuery autoComplete v1.0.7
// https://github.com/Pixabay/jQuery-autoComplete
!function(e){e.fn.autoComplete=function(t){var o=e.extend({},e.fn.autoComplete.defaults,t);return"string"==typeof t?(this.each(function(){var o=e(this);"destroy"==t&&(e(window).off("resize.autocomplete",o.updateSC),o.off("blur.autocomplete focus.autocomplete keydown.autocomplete keyup.autocomplete"),o.data("autocomplete")?o.attr("autocomplete",o.data("autocomplete")):o.removeAttr("autocomplete"),e(o.data("sc")).remove(),o.removeData("sc").removeData("autocomplete"))}),this):this.each(function(){function t(e){var t=s.val();if(s.cache[t]=e,e.length&&t.length>=o.minChars){for(var a="",c=0;c<e.length;c++)a+=o.renderItem(e[c],t);s.sc.html(a),s.updateSC(0)}else s.sc.hide()}var s=e(this);s.sc=e('<div class="autocomplete-suggestions '+o.menuClass+'"></div>'),s.data("sc",s.sc).data("autocomplete",s.attr("autocomplete")),s.attr("autocomplete","off"),s.cache={},s.last_val="",s.updateSC=function(t,o){if(s.sc.css({top:s.offset().top+s.outerHeight(),left:s.offset().left,width:s.outerWidth()}),!t&&(s.sc.show(),s.sc.maxHeight||(s.sc.maxHeight=parseInt(s.sc.css("max-height"))),s.sc.suggestionHeight||(s.sc.suggestionHeight=e(".autocomplete-suggestion",s.sc).first().outerHeight()),s.sc.suggestionHeight))if(o){var a=s.sc.scrollTop(),c=o.offset().top-s.sc.offset().top;c+s.sc.suggestionHeight-s.sc.maxHeight>0?s.sc.scrollTop(c+s.sc.suggestionHeight+a-s.sc.maxHeight):0>c&&s.sc.scrollTop(c+a)}else s.sc.scrollTop(0)},e(window).on("resize.autocomplete",s.updateSC),s.sc.appendTo("body"),s.sc.on("mouseleave",".autocomplete-suggestion",function(){e(".autocomplete-suggestion.selected").removeClass("selected")}),s.sc.on("mouseenter",".autocomplete-suggestion",function(){e(".autocomplete-suggestion.selected").removeClass("selected"),e(this).addClass("selected")}),s.sc.on("mousedown",".autocomplete-suggestion",function(t){var a=e(this),c=a.data("val");return(c||a.hasClass("autocomplete-suggestion"))&&(s.val(c),o.onSelect(t,c,a),s.sc.hide()),!1}),s.on("blur.autocomplete",function(){try{over_sb=e(".autocomplete-suggestions:hover").length}catch(t){over_sb=0}over_sb?s.is(":focus")||setTimeout(function(){s.focus()},20):(s.last_val=s.val(),s.sc.hide(),setTimeout(function(){s.sc.hide()},350))}),o.minChars||s.on("focus.autocomplete",function(){s.last_val="\n",s.trigger("keyup.autocomplete")}),s.on("keydown.autocomplete",function(t){if((40==t.which||38==t.which)&&s.sc.html()){var a,c=e(".autocomplete-suggestion.selected",s.sc);return c.length?(a=40==t.which?c.next(".autocomplete-suggestion"):c.prev(".autocomplete-suggestion"),a.length?(c.removeClass("selected"),s.val(a.addClass("selected").data("val"))):(c.removeClass("selected"),s.val(s.last_val),a=0)):(a=40==t.which?e(".autocomplete-suggestion",s.sc).first():e(".autocomplete-suggestion",s.sc).last(),s.val(a.addClass("selected").data("val"))),s.updateSC(0,a),!1}if(27==t.which)s.val(s.last_val).sc.hide();else if(13==t.which||9==t.which){var c=e(".autocomplete-suggestion.selected",s.sc);c.length&&s.sc.is(":visible")&&(o.onSelect(t,c.data("val"),c),setTimeout(function(){s.sc.hide()},20))}}),s.on("keyup.autocomplete",function(a){if(!~e.inArray(a.which,[13,27,35,36,37,38,39,40])){var c=s.val();if(c.length>=o.minChars){if(c!=s.last_val){if(s.last_val=c,clearTimeout(s.timer),o.cache){if(c in s.cache)return void t(s.cache[c]);for(var l=1;l<c.length-o.minChars;l++){var i=c.slice(0,c.length-l);if(i in s.cache&&!s.cache[i].length)return void t([])}}s.timer=setTimeout(function(){o.source(c,t)},o.delay)}}else s.last_val=c,s.sc.hide()}})})},e.fn.autoComplete.defaults={source:0,minChars:3,delay:150,cache:1,menuClass:"",renderItem:function(e,t){t=t.replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&");var o=new RegExp("("+t.split(" ").join("|")+")","gi");return'<div class="autocomplete-suggestion" data-val="'+e+'">'+e.replace(o,"<b>$1</b>")+"</div>"},onSelect:function(e,t,o){}}}(jQuery);

/*
 * Blog, get categories
 */
$('a[href^="http"], a[href^="ftp"]').not('a[href^="http://alfaspa.ukraine.com.ua/"]').click(function(){
    window.open(this.href, "");
    return false;
});
(function ($) {
  $.searchForm = function (form) {
    this.$form = $(form);
    this.init();
  };

  $.searchForm.prototype = {
    init: function () {
      this.$autoCompleteElement = $(this.$form.find("input.b-search__input")[0]);
      this.autoCompleteHandler();
    },
    autoCompleteHandler: function () {
        
        var url = this.$autoCompleteElement.data('url');
        
        var self = this;
        self.$autoCompleteElement.autoComplete({
            minChars: 1,
            renderItem : function (item,search){
              search = search.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&');
              var re = new RegExp("(" + search.split(' ').join('|') + ")", "gi");
              return '<div class="autocomplete-suggestion" data-val="' + item.name + '" >' + item.name.replace(re, "<b>$1</b>") + '</div>';
            },
            source: function(term, response){
              $.ajax({
                type: 'GET',
                dataType: 'json',
                url: url,
                data: 'q='+term,
                success: function (data) {
                    if (data.answer) {
                       response(data.data); 
                    } 
                },
                complete: function (jqXHR, textStatus) {
                }
              });
            }
          });
        }
    };

  $(function () {
    var search_form = new $.searchForm(".b-search__form");
  });

})(jQuery);


/*
 * Form, make request
 */
(function ($) {
    $.Form = function (form) {
        this.$form = $(form);
        this.init();
    };

    $.Form.prototype = {
        init: function () {
            this.action = this.$form.attr('action');
            this.method = this.$form.attr('method');
            this.$modal_success = $('#'+this.$form.data('modal-success'));
            this.$modal_err = $('#'+this.$form.data('modal-err'));
            this.submitHandler();
        },
        submitHandler: function () {
            var self = this;
            this.$form.on( "submit", function( event ) {
                event.preventDefault();
                self.senderFunc();
            });
        },
        senderFunc: function () {
            var self = this;
            var data = new FormData(this.$form[0]);
            $.ajax({
                type: self.method,
                processData: false,
                contentType: false,
                enctype: 'multipart/form-data',
                dataType: 'json',
                url: self.action,
                data: data,
                success: function (data) {
                    $.arcticmodal('close');
                    if (data.answer) {
                        self.$modal_success.arcticmodal();
                    } else {
                        self.$modal_err.arcticmodal();
                    }
                },
                complete: function (jqXHR, textStatus) {
                }
            });
        }
    };

    $(function () {
        $.each($(".xhr-form"),function( index, value ) {
            new $.Form(value);
        });
    });

})(jQuery);