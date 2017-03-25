$(function(){
  $("#loginColumn").hide();
  $("#repoContent").html('<div class="well"><div id = "repoList" class="list-group"></div><div id = "pagination" class = "col-md-12"></div></div>');
  $("#statistics").hide();

  document.addEventListener('scroll', function (event) {
    var scrollLength = $('body').scrollTop();
    if (scrollLength > 250){
      $("#anchorUp").show();
    } else{
      $("#anchorUp").hide();
    }
  }, true /*Capture event*/);

  $("#anchorUp").click(function(){
    $('body').scrollTop(0);
  });

  $('#home').click(function(){
    $("#repoContent").html('<div class="well"><div id = "repoList" class="list-group"></div><div id = "pagination" class = "col-md-12"></div></div>');
    $("#filter").html("");
    $("#loginColumn").hide();
    $("#statistics").hide();
    $('#pagination').bootpag({
      total: 0,
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
        getConcretePageFromPagin(num);
    });
    setFilter();
    setTable("");
  });

  $('#pagination').bootpag({
    total: 0,
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
      getConcretePageFromPagin(num);
  });

  setFilter();
  setTable("", "", "");

  function setTable(repo, column, query){

    var paginationCount = 20;

    var selectedType =   $("select#selectFilter3").children(":selected").html();
    selectedType = (parseInt(selectedType));

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
      if ($.isNumeric(selectedType)){
        paginationCount = selectedType;
      }
      totalCount = response / paginationCount;

      if (paginationCount >= response){
        totalCount = 1;
      }
      if (response == 0){
        $("#pagination").bootpag({maxVisible: 0});
      }else{
        $("#pagination").bootpag({
          total: Math.ceil(totalCount),
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
        });
      }
      getConcretePage(paginationCount, 1, repo, column, query);
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

  function getConcretePageFromPagin(num){
    var selectedItem = $('#selectFilter1 option:selected').text();
    var selectedType = $('#selectFilter2 option:selected').text();

    if (selectedItem == "Усі спеціальності"){
      selectedItem = "";
    }

    var content = $('#query').val();

    var column = '';
    if (selectedType == "Ключові слова"){
        column = "info";
    }else if (selectedType == "Рік видання"){
          column = "year";
    }else if(selectedType == "Назва"){
        column = "title";
    }else if (selectedType == "Автор(тільки прізвище)"){
        column = "author";
    }

    var paginationCount = 20;
    var selectedType =   $("select#selectFilter3").children(":selected").html();
    selectedType = (parseInt(selectedType));
    if ($.isNumeric(selectedType)){
        paginationCount = selectedType;
    }

    var concretePage = $.ajax({
        url: "/controllers/home.php",
        type: "get",
        data:  {
          "type": "getConcretePage",
          "amountOnOnePage": parseInt(paginationCount),
          "number": Math.ceil(num),
          "repo": selectedItem,
          "column": column,
          "query": content
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
        var res = "", sum = 0;
        labels.forEach(function (item, i){
            res += '<option>' + item +  '</option>';
            sum += parseInt(Object.values(data.datasets.data)[i]);
        });
        $("#filter").append('<div class = "row"><div class="col-md-3"><select class="form-control" id="selectFilter1"><option>Усі спеціальності</option>' + res + '</select></div><div class="col-md-2"><select class="form-control" id="selectFilter3"><option>К-сть дисертацій</option><option>1</option><option>5</option><option>10</option><option>20</option></select></div><div class = "col-md-3"><select class="form-control" id="selectFilter2"><option>Ключові слова</option><option>Автор(тільки прізвище)</option><option>Назва</option><option>Рік видання</option></select></div><div class = "col-md-2"><input type = "text" class = "form-control" id = "query" placeholder = "Введіть запит"></input></div><div id = "filterBlockSubmit" class = "col-md-2"><button class = "btn btn-success btn-block" id = "filterSubmit">Пошук</button></div></div>');

        $('#query').keydown(function(event){
            if (event.which == 13){
              sendQuery();
            }
        });

        $('#filterSubmit').click(function(){
            sendQuery();
        });

        $("select#selectFilter1").change(function(){
            var selectedItem = $(this).children(":selected").html();
            var selectedType =   $("select#selectFilter2").children(":selected").html();

            if (selectedItem == "Усі спеціальності"){
              selectedItem = "";
            }

            var column = '';
            if (selectedType == "Ключові слова"){
                column = "info";
            }else if (selectedType == "Рік видання"){
                  column = "year";
            }else if(selectedType == "Назва"){
                column = "title";
            }else if (selectedType == "Автор(тільки прізвище)"){
                column = "author";
            }

            var content = $('#query').val();

            setTable(selectedItem, column, content);
        });
    });
  }

  function sendQuery(){
    var selectedItem = $("select#selectFilter1").children(":selected").html();
    var selectedType =   $("select#selectFilter2").children(":selected").html();

    if (selectedItem == "Усі спеціальності"){
      selectedItem = "";
    }

    var content = ($('#query').val());

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
