var submitted = false;

function loadCalendar(year,month,day) {

  event.preventDefault();

  if(submitted == true) { return false; }
  submitted = true;

  $('#hyear').val(year);
  $('#hmonth').val(month);
  $('#hday').val(day);

  var form = $("#mainForm").serialize();

  $.ajax({    

        url:'get_meetings_on_day.php',
        type: 'post',
        data: form,
        success: function(data) 
        {
          $("#hoverDay").html(data);
          submitted = false;
        }
    });

  return false;
}

function month_to_num(month)
{
  switch(month)
  {
    case "January" : return 1;
    case "February" : return 2;
    case "March" : return 3;
    case "April" : return 4;
    case "May" : return 5;
    case "June" : return 6;
    case "July" : return 7;
    case "August" : return 8;
    case "September" : return 9;
    case "October" : return 10;
    case "November" : return 11;
    case "December" : return 12;
  }
}

$('#calendar').datepicker({
    inline: true,
    firstDay: 1,
    showOtherMonths: true,
    dayNamesMin: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
    onSelect: function(dateText, inst) 
    {
       var date = $("#datepicker").datepicker('getDate');
    }
});
$(function() {
  $("#datepicker").datepicker();
  $(".ui-state-default").on("mouseover", function() {

     var month = month_to_num($(this).closest('.ui-datepicker').find('.ui-datepicker-month').text());
     var year  = $(this).closest('.ui-datepicker').find('.ui-datepicker-year').text();
     var day = $(this).text();
     loadCalendar(year,month,day);

   });
  $(".ui-state-default").on("mouseout", function() {
    $("#hoverDay").text('Hover over a day to see appointments.');
   });
});

