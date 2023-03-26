<?php
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

?>

<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
</html>

<script>
   window.onload = function() {
      $.ajax({
         url: "v1/World/get_all_worlds.php",
         method: "POST",
         beforeSend: function(request) {
            request.setRequestHeader("Api_token", <?php echo $user->getApiToken() ?>);
            request.setRequestHeader("Api_email", <?php echo $user->getApiEmail() ?>);
         },
         async: false,
         success: function($result) {
            $("html").append($result);
         }
      });
   }
</script>