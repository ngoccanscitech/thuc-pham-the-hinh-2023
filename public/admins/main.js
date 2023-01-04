function  actionDelete(event) {
    event.preventDefault();
    let urlRequest = $(this).data('url');
    let that = $(this);
    Swal.fire({
        title: 'Bạn có chắc là muốn xóa?',
        text: "Bạn không thể khôi phục lại!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Đồng ý, xóa đi!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: 'GET',
                url: urlRequest,
                success: function (data){
                    console.log(data)
                    if(data.code == 200)
                    {
                        that.parent().parent().remove();
                    }
                },
                error: function (){

                }
            })
            Swal.fire(
                'Đã xóa!',
                'Mã giảm giá đã xóa thành công.',
                'success'
            )
        }
    })
}

$(function (){
    $(document).on('click','.action_delete', actionDelete);
});
