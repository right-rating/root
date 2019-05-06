$(document).ready(function() {
  
  function submit_page()
  {
            $.ajax({
                type: "post",
                url: "/api/submit_new_entry.php",
                dataType: "json",
                data: {
                  type:"website",
                  item_name:$("[name=item_name]").val(),
                  description:$("[name=Description]").val(),
                  item_image:$("[name=item_image]").val(),

                },
                success: function(data,status){

                },
                complete: function(data, status){

                }
            })

  };
  $("#submit_webpage").click(submit_page);

});
