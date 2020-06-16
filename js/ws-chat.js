$(document).ready(function () {
    // Busca todas as tags
    $.ajax({
        type: 'GET',
        url: 'ws_tags.php',
        dataType: 'json',
        async: true,
        success: function (response) {
            if (response.length > 0) {
                response.forEach((item) => {
                    $('#tag').append('<option value="' + item.id + '">' + item.name + '</option>');
                });
            }
        }
    });

    // Alterar tag
    $('#tag').change(function () {
        var data = {tag_id: $(this).val(), last_id: $('#txtUltimoId').val(), phone: $('#txtTelefoneAtivo').val()};
        if(data.tag_id !== undefined && data.last_id !== undefined && data.phone !== undefined){
            $.ajax({
                type: 'POST',
                url: 'ws_set_tag.php',
                data: data,
                dataType: 'json',
                async: true,
                success: function (response) {
                    if(response){
                        $('#tag option[value="'+data.tag_id+'"]').prop('selected', 'selected');
                    }
                },
                error: function (e) {
                    console.log(e)
                }
            });
        }
    });

    // Ao abrir modal bloco de notas ativa o summernote
    $('#notepadBtn').click(function () {
        $('#summernote').summernote({
            airMode: true,
            codeviewFilter: false,
            codeviewIframeFilter: true,
            callbacks: {
                onEnter: function() {
                    var data = {notepad: $('#summernote').val(), phone: $('#txtTelefoneAtivo').val()};
                    if(data.notepad !== undefined && data.phone !== undefined){
                        $.ajax({
                            type: 'POST',
                            url: 'ws_notepad_save.php',
                            data: data,
                            dataType: 'json',
                            async: true,
                            success: function (response) {
                                if(response){
                                    //console.log(response);
                                }
                            },
                            error: function (e) {
                                console.log(e)
                            }
                        });
                    }
                }
            }
        });

        var data = {phone: $('#txtTelefoneAtivo').val()};
        if(data.phone !== undefined){
            $.ajax({
                type: 'POST',
                url: 'ws_notepad_select.php',
                data: data,
                dataType: 'json',
                async: true,
                success: function (response) {
                    if(response){
                        $('.note-editable').html(response.notepad);
                        //console.log(response);
                    }
                },
                error: function (e) {
                    console.log(e)
                }
            });
        }
    })



});