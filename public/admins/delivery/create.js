$(function(){
    fetch_delivery();

    function fetch_delivery()
    {
        var _token = $("input[name='_token']").val();
        var dataUrl = $('.url_route').val();
        $.ajax({
            url: dataUrl,
            method: 'POST',
            data: {_token:_token},
            success: function (data){
                $('#load_delivery').html(data);
            }
        });
    }

    $('.add_delivery').click(function (){
        var city = $('.city').val();
        var province = $('.province').val();
        var wards = $('.wards').val();
        var fee_ship = $('.fee-ship').val();
        var _token = $("input[name='_token']").val();
        var dataUrl = $(this).data('url');
        $.ajax({
            url: dataUrl,
            method: 'POST',
            data: {_token:_token, city:city, province:province,wards:wards,fee_ship:fee_ship },
            success: function (data){
                location.reload();
            }
        });
    })

    $('.choose').change(function (){
        var action = $(this).attr('id');
        var ma_id = $(this).val();
        var _token = $("input[name='_token']").val();
        var result = '';
        var dataUrl = $(this).data('url');
        if(action == 'city')
        {
            result = 'province';
        }else{
            result = 'wards';
        }
        $.ajax({
            url: dataUrl,
            method: 'POST',
            data: {_token:_token, ma_id:ma_id, action:action },
            success: function (data){
                $('#'+result).html(data);
            }
        });
    })
})
