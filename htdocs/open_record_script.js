$(document).ready(function(){
  $("html").on('click', "#addactor", function(event){
    event.preventDefault();
    var label, id, first, last;
    label = $("#actors option:selected").text();
    first = label.substr(0, label.indexOf(" "));
    last = label.substr(label.indexOf(" ")+1);
    id = $("#actors").val();

  $("#actorform").append('<tr><td>' + first +'</td>'+
     '<td>' + last + '</td>'+
    '<td><input name="actor[]" class="delete"  type="hidden" value="'+ id +'">' +
     '<button type="button" class="remove">Remove</button></td></tr>');
  });
  $("#actorform").on("click", ".remove", function(){

    $(this).closest("tr").remove();
  });
  $("form").on("click", "#addnewact", function(){
    var full, id, first, last;
    full = prompt("Enter Actor's Name");
    first = full.substr(0, full.indexOf(" "));
    last = full.substr(full.indexOf(" ")+1);
    $.ajax({
      method: "POST",
      url: "add_new_actor.php",
      data: {first: first,
        last: last},
        success: function(response){
        $("#actorform").append('<tr><td>' + first +'</td>'+
          '<td>' + last + '</td>'+
          '<td><input name="actor[]" class="delete"  type="hidden" value="'+ response +'">' +
          '<button type="button" class="remove">Remove</button></td></tr>');
      }
    });
  });
});
