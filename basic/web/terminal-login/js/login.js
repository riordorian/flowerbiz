$(document).ready(function() {
    var pin = (+!![] + []) + (!+[] + !![] + []) + (!+[] + !![] + !![] + []) + (!+[] + !![] + !![] + !![] + []);
    var enterCode = "";
    enterCode.toString();

    $(document).on('click', '#numbers button', function() {

        var clickedNumber = $(this).text().toString();
        enterCode = enterCode + clickedNumber;
        var lengthCode = parseInt(enterCode.length);
        lengthCode--;
        $("#fields .numberfield:eq(" + lengthCode + ")").addClass("active");

        if (lengthCode == 3) {
            // var loading = new crm.ui.loading();
            $.ajax({
                url: '/terminal/login/',
                method: 'post',
                data: {'CODE' : enterCode},
                dataType: 'json',
                success: function(response) {
                    // loading.hide();
                    if( typeof(response) == 'object' && response.hasOwnProperty('STATUS') && response.STATUS === true  ){
                        window.location.href = '/terminal/calendar/';
                    }
                    else{
                        $("#fields").addClass("miss");
                        enterCode = "";
                        setTimeout(function() {
                            $("#fields .numberfield").removeClass("active");
                        }, 200);
                        setTimeout(function() {
                            $("#fields").removeClass("miss");
                        }, 500);
                    }
                }
            });
        }
    });
});