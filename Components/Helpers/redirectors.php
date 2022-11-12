<?php
if (isset($_SESSION["request_redirect"])) {
   $func = "load_" . $_SESSION["request_redirect"] . "();";
?>
   <script type='text/javascript'>
      <?php echo $func ?>
   </script>

<?php unset($_SESSION["request_redirect"]);
} ?>