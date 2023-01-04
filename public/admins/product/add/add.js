$(function(){
    $(".select2_init").select2({
        placeholder: "Chọn danh mục",
        allowClear: true
    });
    $(".tags_select_choose").select2({
        tags: true,
        tokenSeparators: [',']
    })

    var options = {
        filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
        filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
    };

    CKEDITOR.replace('ck_editor_init', options);

});
