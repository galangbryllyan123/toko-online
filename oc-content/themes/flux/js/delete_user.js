$(document).ready(function(){
    $(".opt_delete_account a").click(function(){
        $("#dialog-delete-account").dialog('open');
    });

    $("#dialog-delete-account").dialog({
        autoOpen: false,
        modal: true,
        buttons: [
            {
                text: flux.langs.delete,
                click: function() {
                    window.location = flux.base_url + '?page=user&action=delete&id=' + flux.user.id  + '&secret=' + flux.user.secret;
                }
            },
            {
                text: flux.langs.cancel,
                click: function() {
                    $(this).dialog("close");
                }
            }
        ]
    });
});