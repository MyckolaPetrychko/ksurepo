$(function(){
  $('#stat').click(function(){

      $("#filter").html("");
      $("#loginColumn").hide();
      $("#repoContent").html("");
      $("#statistics").show();

      setPie();

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

            var ctx2 = $("#barYearRepo");

            var sum = Object.values(pieData.datasets.data).reduce(add, 0);
            $("#repoInfo #common").html(sum);

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

            var yearDist = pieData.datasets.yearDistribution.dist;
            var result = {};
            var values = {};
            for (var i = 0; i < yearDist.length; i++){
              result[Object.keys(yearDist[i])] = (Object.values(yearDist[i]));
              values[i] = Object.values(yearDist[i]).join("");
            }

            var dataForYearBar = {
              labels: Object.keys(result),
              datasets: [
                  {
                      label: "Розподіл дисертацій по роках",
                      backgroundColor: pieData.datasets.yearDistribution.backgroundColor,
                      borderColor: pieData.datasets.yearDistribution.hoverBackgroundColor,
                      borderWidth: 1,
                      data: Object.values(values)
                  }
              ]
            }

            var yearBarChart = new Chart(ctx2, {
              type: 'bar',
              data: dataForYearBar,
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

      function add(a, b) {
          return parseInt(a) + parseInt(b);
      }

      function convertToObject(arr){
        var result = {};
        for (var i = 0; i < arr.length; i++){
          result[arr[i].key] = arr[i].value;
        }
        return result;
      }

  });
});
