$(document).ready(function() {
    $('.js-add-tag').click(function(e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let url = $('#url').attr('value');
        let title = $('#tag-title').attr('value');
        let formData = {
            title: title,
        };
        let type = "POST";
        e.preventDefault();

        $.ajax({
            type: type,
            url: url,
            data: formData,
            success: function(response) {
                $('#tag-content').html(response);
                document.getElementById('tag-title').value = "";
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
});
