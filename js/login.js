$(function(){
  $('#login').click(function(){

      $("#mainContent").load("/views/login.html");
      $("#repoContent").html("");
      $("#filter").html("");

  /*  var request = $.ajax({
      url: "/controllers/login.php",
      type: "get",
      data: "test"
    });

    request.done(function(response, textStatus, jqXHR){
      $("#mainContent").html(response);
    });*/

  });
});
