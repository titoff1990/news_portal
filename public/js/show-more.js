$(function(){
    $('#showMore').click(function () {

        let count = $('#count-of-news').attr('value');
        let url = $('#show-more-url').attr('value');
        let type = "GET";
        let formData = {
            count: count,
        };
        let showButton = $('#showMore');

        $.ajax({
            url: url,
            type: type,
            data: formData,
            beforeSend: function() {
                showButton.fadeTo('normal', 0);
            }.bind(this),
            success: function(response) {
                if (JSON.parse(response).html.length === 0) {
                    showButton.addClass('d-none');
                    $('#hidden-message').removeClass('d-none');
                }
                $('#count-of-news').val(JSON.parse(response).count);
                $('#news-content').append(JSON.parse(response).html);
                showButton.fadeTo('slow',1);
            },
            error: function (e) {
                console.log(e);
            }
        });
    });
});
