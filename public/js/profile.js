var submitted = false;

function onSubmit() {

  event.preventDefault();

  if(submitted == true) { return false; }
  submitted = true;

  var form = $(".notes").serialize();

  $.ajax({    

        url:'post_notes.php',
        type: 'post',
        data: form,
        success: function(data) 
        {
          $("#theNotes").html(data);
          submitted = false;
        }
    });

  return false;

}

$(document).ready(function () {
  $("#submitNotes").bind('click', onSubmit);
});
