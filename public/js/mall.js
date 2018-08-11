function create_item(form, button) {

    var form = $(form);
    var url = form.attr('action');
    var method = form.attr('method');
    var bnt = $(button);
    var data = form.serializeArray();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $('#loading').show();
    $.ajax({
        url: url,
        type: method,
        data: data,
        beforeSend: function () {
            bnt.prop('disabled', true);
            bnt.html("Aguarde");
            $('#alert').html('');
            $('#alert').hide();

        },
        success: function (data) {
            $('#loading').hide();
            bnt.prop('disabled', false);
            bnt.html("Confirm fgdgsg hgfd");

            if (data.success) {
                bootbox.alert(data.success);
            }

            $.each(data.errors, function (key, value) {
                $('.alert-danger').show();
                $('.alert-danger').append('<p>' + value + '</p>');
            });
        },
        error: function (data) {

        },
        statusCode: {
            404: function () {
                bootbox.alert("Error url");
            }
        },
        complete: function () {

        }
    });
}


function buy(mall_id, button) {

    var url = "mall/buy";
    var method = "POST";
    var bnt = $(button);
    var data = mall_id;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    bootbox.confirm({
        message: "This is a confirm to buy this item , Do you like it?",
        buttons: {
            confirm: {
                label: 'Yes',
                className: 'btn-success'
            },
            cancel: {
                label: 'No',
                className: 'btn-danger'
            }
        },
        callback: function (result) {

            if (result==true) {
                $('#loading').show();
                $.ajax({
                    url: url,
                    type: method,
                    data: {MallID: data},
                    beforeSend: function () {
                        bnt.prop('disabled', true);
                        bnt.html("Aguarde");
                        $('#alert').html('');
                        $('#alert').hide();

                    },
                    success: function (data) {
                        $('#loading').hide();
                        bnt.prop('disabled', false);
                        bnt.html("buy");
                        if (data.success) {
                            bootbox.alert(data.success);
                        }
                        $.each(data.errors, function (key, value) {
                            $('.alert-danger').show();
                            $('.alert-danger').append('<p>' + value + '</p>');
                        });
                    },
                    error: function (data) {

                    },
                    statusCode: {
                        404: function () {
                            bootbox.alert("Error url");
                        }
                    },
                    complete: function () {

                    }
                });
            }
        }
    });

}