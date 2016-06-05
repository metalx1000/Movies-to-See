<!DOCTYPE html>
<html lang="en">
<head>
  <title>Movies to See</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <style>
    .well,h3,.dvd{
      margin:10px;
      padding:0;
      padding-left:20px;
    }
    .Movie{
      background-color:red;
      color:white;
    }
  </style>

  <script>
    var mainList;
    var mainJSON;

    $(document).ready(function(){
      getList(); 
    });

    function getList(){
      $.getJSON("list.php", function(data){
        mainList = data;
        mainJSON = JSON.stringify(data);
        updateList();
      });
    }

    function updateList(){
      mainList.forEach(function(i){
        $("#list").append('<div class="well '+i.type+'" id='+i.pid+'></div>');
        $("#"+i.pid).append('<h3>'+i.title+'</h3>');

        if(i.dvd !== ""){ 
          var dvd = parseInt(i.dvd);
          dvd = formatDate(dvd);
          $("#"+i.pid).append('<div class="dvd">Date Available: '+dvd+'</div>');
        }
      });
    }

    function formatDate(inputDate) {
      var date = new Date(inputDate);
           // Months and Days use 0 index.
      var day = date.getDate() + 1;
      return date.getMonth() + 1 + '/' + day +  '/' + date.getFullYear();
    }

    Array.prototype.removeValue = function(name, value){
     var array = $.map(this, function(v,i){
        return v[name] === value ? null : v;
     });
     this.length = 0; //clear original array
     this.push.apply(this, array); //push all elements except the one we want to delete
    }
  </script>
</head>
<body>

<div class="container" id="form">
  
</div>
<div class="container" id="list"></div>

</body>
</html>
