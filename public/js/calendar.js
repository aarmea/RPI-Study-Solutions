$('#calendar').datepicker({
    inline: true,
    firstDay: 1,
    showOtherMonths: true,
    dayNamesMin: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']
});
$(function() {
  $("#datepicker").datepicker();
  $(".ui-state-default").live("mouseover", function() {
    $("#hoverDay").text($(this).text());
   });
  $(".ui-state-default").live("mouseout", function() {
    $("#hoverDay").text('Hover over a day to see appointments.');
   });
});