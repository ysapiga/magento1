jQuery(document).ready(function () {
    var loader = jQuery("#loading-mask");
    var uploadGridFileFieldSelector = jQuery("input[name~='parameters[image]'");
    var uploadGridBtn = jQuery("#upload");
    var cropGridListBtn = jQuery("#gridBtnCrop");
    var crooperListImg = jQuery("#listcroopedImage");
    var crooperGridImg = jQuery("#gridcroopedImage");
    var listRatio = convertRatio(jQuery("#listratio").val());
    var gridRatio = convertRatio(jQuery("#gridratio").val());
    var instanceId = jQuery('#instance_id').val();
    uploadGridBtn.attr('disabled', 'disabled');
    function setGridCoords(c)
    {
        jQuery('#gridx').val(c.x);
        jQuery('#gridy').val(c.y);
        jQuery('#gridwidth').val(c.w);
        jQuery('#gridheight').val(c.h);
    };
    function setListCoords(c)
    {
        jQuery('#listx').val(c.x);
        jQuery('#listy').val(c.y);
        jQuery('#listwidth').val(c.w);
        jQuery('#listheight').val(c.h);
    };
    function convertRatio(ratio){
        var arr = ratio.split('/');
        return arr[0]/arr[1];
    }
    uploadGridFileFieldSelector.change(function () {
        uploadGridBtn.prop("disabled", false);
    });

    uploadGridBtn.on('click', function (e) {
        e.preventDefault();
        var form_data = new FormData();
        var file_data = jQuery(uploadGridFileFieldSelector).prop('files')[0];
        form_data.append('image', file_data);
        form_data.append('instance_id',instanceId);
        loader.show();
        jQuery.ajax({
            url: '/sapiha_banner_admin/adminhtml_banner/upload/form_key/' + FORM_KEY,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,
            type: 'POST',
             success: function (serverResponse) {
                 loader.hide();
                 if (serverResponse.error)
                 {
                     alert(serverResponse.error);
                 } else {
                     crooperGridImg.attr('src', serverResponse.image);
                     crooperListImg.attr('src', serverResponse.image);
                     jQuery(function () {
                         crooperGridImg.Jcrop({
                             bgColor: 'white',
                             onChange: setGridCoords,
                             onSelect: setGridCoords,
                             aspectRatio: gridRatio,
                             setSelect: [100, 100, 50, 50],
                         });
                     });
                     jQuery(function () {
                         crooperListImg.Jcrop({
                             bgColor: 'white',
                             onChange: setListCoords,
                             onSelect: setListCoords,
                             aspectRatio: listRatio,
                             setSelect: [100, 100, 50, 50],
                         });

                     });
                 }
             }
        });
    });
    cropGridListBtn.on('click', function (ev) {
        ev.preventDefault();
    })
});