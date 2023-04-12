<?php
require "../../../Components/Classes/Config.php";
$config = Config::getInstance();
session_start();
$hash = '';
$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
$charactersLength = strlen($characters);
$counter = 0;
while ($counter < 15) {
   $rand = floor(random_int(0, $charactersLength));
   $hash .= substr($characters, $rand, 1);
   $counter += 1;
}
$mess = wordwrap("Váš link na resetování: https://aeternias.cz/Components/Profile/Page/password_reset.php?pass=" . $hash);
$email = $_POST["email"];
mail($email, "Feedback", $mess, "Ahoj");
$config["db"]->begin_transaction();
$sql = "insert into password_resets(hash,email) values(?,?)";
$statement = $config["db"]->prepare($sql);
$statement->bind_param("ss", $hash, $email);
$statement->execute();
$config["db"]->commit();
require $config["root_path_require_once"] . "Components/Templates/Body_parts/head.php";
?>

<script>
   window.onload = function() {
      showSuccessMessAndRedirect("Úspěšně zasláno!", "<?php echo $config["root_path_url"] ?>index.php");
   }
</script>