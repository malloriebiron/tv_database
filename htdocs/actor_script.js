$(document).ready(function(){
  var counter = 0;
  $("#addactor").click( function(event){
    event.preventDefault();
    var fname, fnamelab, lanme, lnamelab;
    counter = counter +1;

    fname = '<input type="text" name="first' + counter + '"><br />';
    fnamelab = '<label for="first' + counter +'">First:</label><br />';
    lname = '<input type="text" name="last'+ counter + '"><br />';
    lnamelab = '<label for="last' + counter + '">Last:</label><br />';
    $("#actors").append(fnamelab, fname, lnamelab, lname);
    console.log(counter);
  });
  $("#save").click( function(){
     $.ajax({
       method: "POST",
       url: "insert_show.php",
       data: {title: $("input[name=title]").val(),
              genre: $("input[name=genre]").val(),
              seasons: $("input[name=seasons]").val()},
       success:function(doc){
      
      
     for(i=1; i <= counter; i++){
     $.ajax({
       method: "POST",
       url: "add_actorandshow.php",
       data: {first: $("input[name=first" + i +"]").val(),
              last: $("input[name=last" + i + "]").val(),
              title: $("input[name=title]").val()} 
     });
  }
     }
  });
});
