
$(document).ready(function(){$(".opt_delete_account a").click(function(){$("#dialog-delete-account").dialog("open")}),$("#dialog-delete-account").dialog({autoOpen:!1,modal:!0,buttons:[{text:udhauli.langs["delete"],click:function(){window.location=udhauli.base_url+"?page=user&action=delete&id="+udhauli.user.id+"&secret="+udhauli.user.secret}},{text:udhauli.langs.cancel,click:function(){$(this).dialog("close")}}]})});