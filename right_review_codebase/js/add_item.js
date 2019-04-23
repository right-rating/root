$(document).ready(function() {
  console.log("And we have scripts");
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

    /*
    <form class="" action="index.html" method="post">
      <label for="item_name">Website Name</label>
      <input type="text" name="item_name" value=""></input>
      <label for="Description"> Description </label>
      <input type="text" name="Description" value=""></input>
      <label for="item_image">Image URL:</label>
      <input type="text" name="item_image" value=""></input>
      <button type="button" name="submit" id="submit_webpage"></button>
      */


    console.log("submitting")
  };
  $("#submit_webpage").click(submit_page);
  submit_page();
});
