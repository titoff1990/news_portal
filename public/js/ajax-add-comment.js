$(document).ready(function() {
    $('.js-add-comment').click(function(e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        let key = $('#key').val();
        let url = $('#url').attr('value');
        let content = $('#content').val();
        let formData = {
            key: key,
            content: content,
        };
        let type = "POST";
        e.preventDefault();

        $.ajax({
            type: type,
            url: url,
            data: formData,
            success: function(response) {
                $('#comment-content').html(response);
                document.getElementById('content').value = "";
            },
            error: function (response) {
                console.log(response);
            }
        });
    });
});
