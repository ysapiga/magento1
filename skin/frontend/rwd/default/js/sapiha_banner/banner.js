jQuery(document).ready(function () {
    var gridHeight = jQuery('ul li.item.first').height();
    var height = 0;
    var i = 0;
    var isAjaxDone;
    jQuery("ol.products-list li.item").each(function(){
        if( !this.id != 'bannerImg') {
            height += this.height;
            i = i + 1;
        }
    });
    jQuery("ol img.bannerImg").height(Math.round(height/i));
    jQuery("ul img.bannerImg").height(gridHeight);
    var button  = jQuery('.ajaxRequest');
    jQuery(".close").on('click', function(){
        isAjaxDone = false;
        jQuery(".modalDialog").hide();
    });
    jQuery('.ajaxRequest').on('click', function () {
        if (isAjaxDone == false) {
            jQuery.post(
                "banner/index/updateClick",
                {
                    id:jQuery(event.target).attr('data-id'),
                },
            );
            isAjaxDone = true;
            jQuery(this).css('background-color', ' silver');
        } else {
            event.preventDefault();
        }
    }) ;
    jQuery(".mySpan").on('click', function(){
        this.next().style.display = 'block';
        button.css('background-color', ' #f15d5e');
        isAjaxDone = false;
    });
});
