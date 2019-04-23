$("document").ready(function() {
  var page = $("input[name=active_page]").val();
  console.log("Page = ", page);
  $(`.nav_to_${page}`).each(function() {
    $(this).addClass("active")
  }

  )
})
