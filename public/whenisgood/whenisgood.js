
function date_available(year,month,day,hour) {
  for(var i=0;i<available_times.length;i++) {

    //console.log(available_times[i][0] + "," + available_times[i][1] + "," + available_times[i][2] + "," + available_times[i][3]);
    //console.log(year + "," + month + "," + day + "," + hour);
    //console.log('');

    if(available_times[i][0] == year && available_times[i][1] == month &&
      available_times[i][2] == day && available_times[i][3] == hour) {
        return true;
    }
  }
  return false;
}

function removeSeconds(s) {
  return s.substring(0, s.length - 6) + ' ' +  s.substring(s.length - 2, s.length);
}

(function($) {

  //Store an array of selected dates OR indices
  //Store an array of selected datetimes OR indices

  $.fn.load_table = function() {

    time = new Date(year,month,day);

    var oneWeekAgo = new Date();
    oneWeekAgo.setDate(time.getDate() - 7);
    
    var oneWeekLater = new Date();
    oneWeekLater.setDate(time.getDate() + 7);

    //Get the start date and end date range
    var start_date = oneWeekAgo;
    var end_date = oneWeekLater;

    //Get the start time and end time
    var start_time = 6;
    var end_time = 24;

    //Get the number of rows and columns
    var num_rows = end_time - start_time;
    var num_cols = 14;
    
    //Create an HTML table with the given number of rows and columns:
    //  -Use a double for loop
    //  -Bind event handlers to each table entry:
    //    -onDayClick(Date day): This will set the current selection to what was selected
    //    -onHourClick(Date day, Time time): This will set the current selection to what was selected

    $('<table id="mytable" border="1"></table>').appendTo("#timegrid");
    $('<tr id="table_header"></tr>').appendTo("#mytable");

    for(var j=0;j<num_cols;j++) {
        
        var tomorrow = new Date();
        tomorrow.setDate(oneWeekAgo.getDate()+j);

        //console.log(tomorrow.toDateString());
        $("<td>" + tomorrow.toDateString() + "</td>").appendTo("#table_header");
    }

    var curRowDate = new Date(time.getFullYear(), time.getMonth(), time.getDay(), start_time);

    for(var i=0;i<num_rows;i++) {

        var jqueryObj = $("<tr></tr>").appendTo("#mytable");

        for(var j=0;j<num_cols;j++) {

          var tomorrow = new Date();
          tomorrow.setDate(oneWeekAgo.getDate()+j);

          var classes = '';

          if(!date_available(tomorrow.getFullYear(),tomorrow.getMonth(),tomorrow.getDate(),curRowDate.getHours()))
            classes = "' class='cell'>";
          else
            classes = "' class='cell green-cell'>";

          var block = $("<td data-year='" + tomorrow.getFullYear() + "' data-month='" + tomorrow.getMonth() + "' data-day='" + tomorrow.getDate() +
           "' data-hour='" + curRowDate.getHours() + classes + removeSeconds(curRowDate.toLocaleTimeString()) +"</td>").appendTo(jqueryObj);

          $(block).bind('click', function() {
              //alert('User clicked on ' + $(this).text());
              $(this).toggleClass("green-cell");
            }
          );
        }
        curRowDate.setHours(curRowDate.getHours()+1);
    }
    
  }

})(jQuery);

//POST results to whenisgood.php
function onSubmit() {

  //This is an array of arrays of timeslots
  //where each timeslot's index-value pairs are:
  // 0 = year, 1 = month, 2 = day, 3 = hour
  var allTimesArr = [];

  var selected = document.getElementsByClassName("green-cell");
  for(var i=0;i<selected.length;i++) {

    var year = selected[i].getAttribute("data-year");
    var month = selected[i].getAttribute("data-month");
    var day = selected[i].getAttribute("data-day");
    var hour = selected[i].getAttribute("data-hour");

    var timeArr = [year,month,day,hour];

    allTimesArr.push(timeArr);
  }

  for(var i=0;i<allTimesArr.length;i++) {
    for(var j=0;j<allTimesArr[i].length;j++) {
      console.log(allTimesArr[i][j]);
    }
    console.log('');
  }

  console.log("ABOUT TO POST");

  $.post('settings.php', {'times': '0'} );

}

$(document).ready(function () {
      $("#timegrid").load_table();
      $("#submit").bind('click', onSubmit);
});
