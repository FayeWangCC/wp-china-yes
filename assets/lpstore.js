var $ = jQuery.noConflict();
$(".f-sort a").each(function () {
  var url = Url.queryString("orderby");
  var rel = $(this).attr('rel');
  if (url === rel) {
    $(this).addClass("curr").siblings('a').removeClass('curr');
  } else if (url === undefined) {
    $(".f-sort a:first").addClass("curr");
  }
  $(this).on('click', function () {
    $(this).addClass("curr").siblings('a').removeClass('curr');
  })
});