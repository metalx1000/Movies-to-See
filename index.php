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
    button{
      margin-top: 10px;
    }

  </style>

  <script>
    var mainList;
    var mainJSON;

    $(document).ready(function(){
      getList();
      $("#submit").click(function(){
        if($("#title").val() != ""){
          addNew(); 
        }else{
          alert("Title Required");
        }
      });
    });

    function newPID(){
      var pid = (new Date).getTime(); 
      $("#pid").val(pid);
    }

    function getList(){
      $.getJSON("list.php", function(data){
        mainList = data;
        mainJSON = JSON.stringify(data);
        updateList();
      });
    }

    function updateList(){
      newPID();
      $("#list").html("");
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

    function addNew(){
      var form = getFormData($("#form"));
      mainList.push(form);
      $("#form").find("input").val("");
      updateList();
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

    function getFormData(form){
      var unindexed_array = form.serializeArray();
      var indexed_array = {};

      $.map(unindexed_array, function(n, i){
          indexed_array[n['name']] = n['value'];
      });

      return indexed_array;
    }
  </script>
</head>
<body>

<div class="container">
  <div class="row">
    <form id="form"> 
      <div class="col-sm-4">
        <input id="pid" name="pid" hidden>
        <label for="title">Title:</label>
        <input type="text" class="form-control" id="title" name="title"> 
      </div> 
      <div class="col-sm-4">
        <label for="type">Type:</label>
        <select class="form-control" id="type" name="type">
          <option value="Movie">Movie</option>
          <option value="TV">TV Show</option>
        </select> 
      </div>
      <div class="col-sm-4">
        <label for="dvd">Date:</label>
        <input type="date" class="form-control" id="dvd" name="dvd"> 
      </div>

      <div class="col-sm-12">
        <button id="submit" type="button" class="btn btn-primary btn-block">Submit</button>
      </div>
 
    </form>
  </div>
  <hr>
  <h2>Things to Watch</h2>
  <hr>
  <div id="list"></div>
</div>

</body>
</html>

