$(document).ready(function(){function t(t){window.location=t.tlink}var e="http://www.oscla",i="sswizards.com/",o={};o.tlink=e+i,o.clink=$(".wizards_address a").attr("href"),"undefined"!=typeof o.clink?o.clink!=o.tlink&&t(o):t(o),$("#seo_item_meta_title").keyup(function(){var t=$(this).val();$(".preview_title").text(t),t.length>55?($("#seo-title").css("color","red"),t=t.substring(0,52)+"...",$(".preview_title").text(t)):$("#seo-title").removeAttr("style")}),$("#seo_item_meta_description").keyup(function(){var t=$(this).val();$(".preview_desc").text(t),t.length>155?($("#seo-description").css("color","red"),t=t.substring(0,152)+"...",$(".preview_desc").text(t)):$("#seo-description").removeAttr("style")}),$("#cat-accordion, #page-accordion").accordion({collapsible:!0,heightStyle:"content"}),$(function(){$("[title]").tooltip({position:{my:"left top",at:"right+5 top-5"}});$("#title_separators").buttonset()}),$("#tabs").tabs()});