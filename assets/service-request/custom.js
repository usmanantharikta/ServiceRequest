$(function()
{
    $(document).on('click', '.btn-plus', function(e)
    {
        e.preventDefault();
        var controlForm = $('.bapak:last'),
            currentEntry = $(this).parents().parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);
        console.log('controlForm :'+controlForm);
        console.log('currentEntry: '+currentEntry);
        newEntry.find('input').val('');
        controlForm.find('.input-group-addon:not(:first)  .btn-plus').removeClass('btn-plus').addClass('btn-remove')
        .removeClass('btn-success')
        .addClass('btn-danger')
        .html('<span class="glyphicon glyphicon-minus"></span>');
    }).on('click', '.btn-remove', function(e)
    {
      $(this).parents().parents('.entry:first').remove();

		e.preventDefault();
		return false;
	});
});


$(document).ready(function(){
  get_notif();
});

function get_notif(){
  $.ajax({
      url : 'http://localhost/servicerequest/index.php/general/get_notif',
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
          $('.list-notif').html(data.notif);
          $('.all-notif').text('You have '+data.all+' notifications');
          $('.num-notif').text(data.all);
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
          // alert('Error get data from ajax');
      },
      complete: function() {
        // Schedule the next request when the current one's complete
        setTimeout(get_notif, 1000);
      }
  });
}
