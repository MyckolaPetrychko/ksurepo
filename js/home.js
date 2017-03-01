$(function(){
  $("#mainContent").html('<canvas id="pieRepo" width="300" height="300"></canvas>');
  $("#repoContent").html('<div class="well"><div id = "repoList" class="list-group"></div><div id = "pagination" class = "col-md-12"></div></div>');

  $('#home').click(function(){
    $("#mainContent").html('<canvas id="pieRepo" width="300" height="300"></canvas>');
    $("#repoContent").html('<div class="well"><div id = "repoList" class="list-group"></div><div id = "pagination" class = "col-md-12"></div></div>');
    $("#filter").html("");
    setPie();
    setFilter();
    setTable("");
  });

  setPie();
  setFilter();
  setTable("", "", "");

  function setPie(){
    var request = $.ajax({
      url: "/controllers/home.php",
      type: "get",
      data: {
        "type":"getPieData"
      }
    });
    request.done(function(response, textStatus, jqXHR){
      //console.log(response);return;
        var pieData = JSON.parse(response, function(k, v) { return v; });

        var ctx = $("#pieRepo");

        var data = {
            labels: Object.keys(pieData['labels']),
            datasets: [
                {
                    data: Object.values(pieData.datasets.data),
                    backgroundColor: pieData.datasets.backgroundColor,
                    hoverBackgroundColor: pieData.datasets.hoverBackgroundColor
                }]
          };

          var myPieChart = new Chart(ctx,{
            type: 'pie',
            data: data,
            options: {
              responsive: true,
              maintainAspectRatio: false,
              animation:{
                  animateScale:true
              }
            }
          });
    });
  }

  function setTable(repo, column, query){

    var paginationCount = 20;

    var reqAmountOf = $.ajax({
      url: "/controllers/home.php",
      type: "get",
      data: {
        "type":"getAmountOfRepo",
        "repo":repo,
        "column":column,
        "query":query
      }
    });

    reqAmountOf.done(function(response, textStatus, jqXHR){
      // init first page

      totalCount = response / paginationCount;
      if (response == 0){
        totalCount = 0;
      }
      console.log(totalCount);
      getConcretePage(paginationCount, 1, repo, column, query);

      $('#pagination').bootpag({
        total: totalCount,
        page: 1,
        maxVisible: 5,
        leaps: false,
        firstLastUse: true,
        first: '←',
        last: '→',
        wrapClass: 'pagination',
        activeClass: 'active',
        disabledClass: 'disabled',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first'
      }).on("page", function(event, num){
          getConcretePage(paginationCount, num, repo, column, query);
      });
    });
  }

  function getConcretePage(paginationCount, num, repo, column, query){
    var concretePage = $.ajax({
        url: "/controllers/home.php",
        type: "get",
        data:  {
          "type": "getConcretePage",
          "amountOnOnePage": paginationCount,
          "number": num,
          "repo": repo,
          "column": column,
          "query": query
        }
    });
    concretePage.done(function(response, textStatus, jqXHR){
       //console.log(response);
      $('#repoContent > .well #repoList').html(response);
      //console.log(response);
        //console.log(JSON.parse(response, function(k, v) { return v; }));
    });
  }

  function setFilter(){
    var request = $.ajax({
      url: "/controllers/home.php",
      type: "get",
      data: {
        "type":"getPieData"
      }
    });

    request.done(function(response, textStatus, jqXHR){
        var data = JSON.parse(response, function(k, v) { return v; });
        //console.log(Object.keys(data['labels']));

        var labels = Object.keys(data['labels']);
        var res = "";
        labels.forEach(function (item, i){
            res += '<option>' + item + '</option>';
        });
        $("#filter").append('<div class="form-group"><label for="selectFilter1">Виберіть категорію:</label><select class="form-control" id="selectFilter1"><option>Усі</option>' + res + '</select></div>');
        $("#filter").append('<div class="form-group"><label for="selectFilter2">Виберіть тип пошуку:</label><select class="form-control" id="selectFilter2"><option>Ключові слова</option><option>Автор(тільки прізвище)</option><option>Назва</option><option>Рік видання</option></select></div>');
        $("#filter").append('<div class="form-group"><input type = "text" class = "form-control" id = "query"></input><small class = "form-text text-muted">Введіть запит для пошуку</small></div>')

        $("#filter").append('<div id = "filterBlockSubmit" class = "col-md-12"><button class = "btn btn-default" id = "filterSubmit">Пошук</button></div>');

        $('#query').keydown(function(event){
            if (event.which == 13){
              sendQuery();
            }
        });

        $('#filterSubmit').click(function(){
            sendQuery();
        });


        function sendQuery(){
          var selectedItem = $('#selectFilter1 option:selected').text();
          var selectedType = $('#selectFilter2 option:selected').text();

          if (selectedItem == "Усі"){
            selectedItem = "";
          }

          var content = $('#query').val();

          var query = '';
          if (selectedType == "Ключові слова"){
              query = "info";
          }else if (selectedType == "Рік видання"){
                query = "year";
          }else if(selectedType == "Назва"){
              query = "title";
          }else if (selectedType == "Автор(тільки прізвище)"){
              query = "author";
          }

          setTable(selectedItem, query, content);
          // console.log(content);
        }
    });
  }

});
