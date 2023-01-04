$(function (){
    $('.btn_update_qty').click(function (){
        var product_id = $(this).data('product_id');
        var dataUrl = $(this).data('url');
        var _token = $("input[name='_token']").val();
        var order_id = $("input[name='order_id']").val();
       var order_quantity = $('.order_quantity_'+product_id).val();
       var order_qty_storage = $('.order_qty_storage_'+product_id).val();
       $.ajax({
           url: dataUrl,
           method: 'POST',
           data: {product_id:product_id,_token: _token,order_id:order_id,order_quantity: order_quantity, order_qty_storage:order_qty_storage},
           success: function (data){
               alert('Cập nhật dòng thành công!!!');
               location.reload();
           }
       })

    });

    $('.confirm_order_detail').change(function (){
        var order_status = $(this).val();
        var order_id = $(this).children(':selected').attr('id');
        var _token = $('input[name="_token"]').val();
        var dataUrl = $(this).data('data_url');

        //lay ra so luong
        order_quanity = [];
        $('input[name="product_sales_quantity"]').each(function (){
            order_quanity.push($(this).val())
        })
        //lay ra product_id tuong ung
        order_product_id = [];
        check_quantity_error = 0;
        $('input[name="order_product_id"]').each(function (){
            order_product_id.push($(this).val())
        })
        //check so luong ton kho va so luong khach dat moi san pham
        for(i=0;i<order_product_id.length;i++)
        {
            var order_quantity = $('.order_quantity_'+order_product_id[i]).val();
            var order_qty_storage = $('.order_qty_storage_'+order_product_id[i]).val();
            if(parseInt(order_quantity) > parseInt(order_qty_storage))
            {
                check_quantity_error = check_quantity_error + 1;
                $('.color_qty_'+order_product_id[i]).css('background','#db2525');
                if(check_quantity_error == 1){
                    alert('Số lượng mua lớn hơn số lượng tồn kho');
                }
            }
        }
        /*
        Khong co san pham nao loi thi submit form
         */
        if (check_quantity_error == 0)
        {
            $.ajax({
                url: dataUrl,
                method: 'POST',
                data: {_token:_token, order_status:order_status,order_id:order_id,order_quantity:order_quanity,
                    order_product_id:order_product_id},
                success: function (data){
                    alert('Cập nhật tình trạng đơn hàng thành công!');
                    location.reload();
                }
            })
        }

    })
});
