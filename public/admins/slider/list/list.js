function actionDelete(event)
{
    event.preventDefault();
    let dataURL = $(this).attr('data-url');
    let that = $(this);
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
               'method': 'GET',
               'url': dataURL,
               success: function (data){
                    if (data.code == 200){
                        that.parent().parent().remove();
                    }
               },
               fail: function (){

               }
            });
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
        }
    })
}

$(function (){
   $(this).on('click','.action_delete', actionDelete)
});
