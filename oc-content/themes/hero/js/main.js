 $(document).ready(function() {
  $("#sCountry").on("change", function() {
      var e = $("#sRegionSelect").text(),
         i = $("#sCitySelect").text();
      $("#sRegion").next().children(".select-box-label").text(e), $("#sCity").next().children(".select-box-label").text(i);
      var t = $(this).val(),
         s = hero.base_url + "?page=ajax&action=regions&countryId=" + t,
         n = '<option value="" id="sRegionSelect">' + e + "</option>";
      "" != t && $.ajax({
         type: "POST",
         url: s,
         dataType: "json",
         success: function(e) {
            var i = e.length;
            if (i > 0) {
               for (key in e) n += '<option value="' + e[key].pk_i_id + '">' + e[key].s_name + "</option>";
               $("#sRegion").html(n)
            }
         }
      })
   }), $("#sRegion").on("change", function() {
      var e = $("#sCitySelect").text();
      $("#sCity").next().children(".select-box-label").text(e);
      var i = $(this).val(),
         t = hero.base_url + "?page=ajax&action=cities&regionId=" + i,
         s = '<option value="" id="sCitySelect">' + e + "</option>";
      "" != i && $.ajax({
         type: "POST",
         url: t,
         dataType: "json",
         success: function(e) {
            var i = e.length;
            if (i > 0) {
               for (key in e) s += '<option value="' + e[key].s_name + '">' + e[key].s_name + "</option>";
               $("#sCity").empty().html(s)
            }
         }
      })
   })
});