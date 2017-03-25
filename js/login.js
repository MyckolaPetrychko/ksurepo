$(function(){
  $('#login').click(function(){



    //$("#loginColumn").load("/views/login.html");
    $("#loginColumn").show();
    $("#repoContent").html("");
    $("#statistics").hide();
    $("#filter").html("");

    $('#loginSubmit').click(function(){
    
    });

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
