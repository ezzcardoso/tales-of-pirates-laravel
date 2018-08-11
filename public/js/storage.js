function Assign(button) {

    var bnt = $(button);
    var url = "";
    var method = "POST";
    var storage_id = $('.storage:checked').val();
    var char_id = $('#character').val();
    var assign = false;
    if (storage_id == '' || storage_id == undefined || storage_id == false) {

        bootbox.alert("Select a item to assign!");

    } else {


        if (char_id == '' || char_id == undefined || char_id == false) {

            bootbox.alert("Select a character to assign!");

        } else {

            assign = true;
        }

    }


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    if (assign) {
        $('#loading').show();
        $.ajax({
            url: url,
            type: method,
            data: {storage_id: storage_id, char_id: char_id},
            beforeSend: function () {
                bnt.prop('disabled', true);
                bnt.html("Aguarde");
                $('#alert').html('');
                $('#alert').hide();

            },
            success: function (data) {
                $('#loading').hide();
                bnt.prop('disabled', false);
                bnt.html("Confirm");

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

