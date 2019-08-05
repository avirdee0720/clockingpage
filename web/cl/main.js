// ------------------------- TOGGLE FEATURE ------------------------------ //

$(function()
{  
      $('[name="toggle"]').change(function(){
        var has_dot;  
        if ($(this).is(':checked')) {
            has_dot = 1;
        }
        else {
            has_dot = 0;
        }

        var request = new XMLHttpRequest();
        request.open("GET", "./shop_staff_dot.php?emp_no=" + $(this).val() + "&has_dot=" + has_dot, true);
        request.send();
      });

});

// -------------------------- DROPDOWN FEATURE ------------------------ //

$(function()
{
        $("select").change(function(){
            var loc = ($(this).val());
            var id = $(this).attr('id');

            var request = new XMLHttpRequest();
            request.open("GET", "./shop_staff_loc.php?emp_no=" + id + "&loc=" + loc);
            request.send();
        });  
});