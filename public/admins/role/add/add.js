$(function(){
    $('.checked_wrapper').on('click', function (){
        $(this).parents('.card') .find('.checked_childrent').prop('checked', $(this).prop('checked'));
    });
    $('.check_all').on('click', function (){
       $(this).parents().find('.checked_childrent').prop('checked', $(this).prop('checked'));
       $(this).parents().find('.checked_wrapper').prop('checked', $(this).prop('checked'));
    });
});
