<?php
function SendMessage($userID, $personID){
echo '<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
  $(document).ready(function(){
    // Data to be sent
    var dataToSend = {
      id: '.$userID.',
      receiver: '.$personID.'
    };

    // AJAX request
    $.ajax({'."
      type: 'POST',
      url: 'http://localhost:3000/receiveData',
      data: JSON.stringify(dataToSend),
      contentType: 'application/json',
      success: function(response){
        console.log('Response from server:', response);
      },
      error: function(error){
        console.error('Error:', error);
      }
    });
  });
</script>";
}
?>
