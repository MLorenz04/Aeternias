function send_feedback() {
  console.log("test");
  $message = $("#textarea-mess").val();
  $nickname = $("#username_feed").val();
  $email = $("#email_feed").val();
  $.ajax({
    url: "../../Components/Helpers/feedback.php",
    type: "POST",
    data: {
      message: $message,
      email: $email,
      nickname: $nickname,
    },
    success: function (result) {},
  });
}

function show_feed() {
  $("#exampleModal").css("opacity", "1");
}
