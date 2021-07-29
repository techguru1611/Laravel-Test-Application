
$(document).ready(function () {
    $("#append").click( function(e) {
        e.preventDefault();
        var total_text = document.getElementsByClassName("input_text");
        total_text = total_text.length+1;
      $("#field_div").append('<div class="row" style="margin-top: 5px">\
            <input class="form-control col-sm-8 input_text" type="text" name="mobile_numbers[]">\
            <a href="#"  style="margin-left: 50px" class="remove_this btn btn-danger">Remove</a>\
        </div>');
      return false;
      });

    $(document).on('click', '.remove_this', function() {
        $(this).parent().remove();
        return false;
    });

    // select date
    $('.date').datepicker({
        format: 'yyyy/mm/dd',
        endDate: 'today',
        autoclose: true
    });
});
