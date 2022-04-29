$(document).ready(function () {

    // classic editor
    ClassicEditor.create(document.querySelector('#editor')).catch(error => {
        console.error(error);
    });

    // check all checkboxes in admin area
    $('#selectAllBoxes').click(function (event) {
        if (this.checked) {
            $('.checkBoxes').each(function () {
                this.checked = true;
            });
        } else {
            $('.checkBoxes').each(function () {
                this.checked = false;
            });
        }
    });

    // prepend loader
    var div_box = "<div id='load-screen'><div id='loading'></div></div>";
    $("body").prepend(div_box);
    $('#load-screen').delay(700).fadeOut(600, function () {
        $(this).remove();
    });

});

// send ajaX request to get online users.
function loadUsersOnline() {

    $.get("./includes/functions.php?onlineusers=result", function (data) {
        $(".usersonline").text(data);
        //alert( "Load was performed." );
    });
}

// execute the function every 500 milly seconds
setInterval(function () {
    loadUsersOnline();
}, 500);



