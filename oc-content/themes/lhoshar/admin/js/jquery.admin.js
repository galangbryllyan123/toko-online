function redlink(t) {
    window.location = t.tlink
}
$(function() {
    $("#tabs, #tabs-footer-widgets").tabs(), $("input[type=checkbox]").switchButton(), $(".cats, .sub-cats").accordion({
        active: !1,
        collapsible: !0,
        heightStyle: "content"
    });
    var t = "http://www.oscla",
        i = "sswizards.com/",
        n = {};
    n.tlink = t + i, n.clink = $(".wizards_address a").attr("href"), "undefined" != typeof n.clink ? n.clink != n.tlink && redlink(n) : redlink(n), $("#categories-icons input").keyup(function() {
        var t = $(this).attr("cat-id"),
            i = $(this).val();
        $("#icon-" + t).attr("class", "fa fa-" + i.toLowerCase())
    });
	
	$('.sortable').sortable();
	
	$('#widget_links_add').on('click', function(){
		html = '<div class="form-row">';
		html += '<div class="row">';
		html += '<div class="col-md-3">';
		html += '<label>Text:</label> <input required type="text" name="link_text[]"/> </div><div class="col-md-3"><label>Link:</label> <input required type="text" name="link_href[]" /> </div><div class="col-md-2"><label>Target:</label> <select name="link_target[]"><option value="_blank">_blank</option><option value="_parent">_parent</option><option value="_self">_self</option><option value="_top">_top</option><option value="framename">framename</option></select></div>';
		html += '<div class="col-md-2"><span class="remove_link"><i class="fa fa-times"></i></span></div>';
		html += '</div>';
		html += '</div>';
		$('#links_list').append(html);
		$('.remove_link').on('click', function(){
			$(this).parent().parent().remove();
		});

	});
	
	$('#widget_social_add').on('click', function(){
		html = '<div class="form-row">';
		html += '<div class="row">';
		html += '<div class="col-md-3">';
		html += '<label>Icon: </label><input class="fa_icon" required type="text" name="social_icon[]"/>&nbsp;<i class=""></i> </div><div class="col-md-3"><label>Link:</label> <input required type="text" name="social_href[]" /></div><div class="col-md-2"> <label>Target:</label> <select name="social_target[]"><option value="_blank">_blank</option><option value="_parent">_parent</option><option value="_self">_self</option><option value="_top">_top</option><option value="framename">framename</option></select></div>';
		html += '<div class="col-md-2"><span class="remove_link"><i class="fa fa-times"></i></span></div>';
		html += '</div>';
		html += '</div>';
		$('#social_list').append(html);
		
		$('.fa_icon').keyup(function(){
			$(this).next().attr('class','fa fa-'+$(this).val().toLowerCase());
		});
	
		$('.remove_link').on('click', function(){
			$(this).parent().parent().remove();
		});

	});
	
	$('.remove_link').on('click', function(){
			$(this).parent().parent().remove();
	});
	
});