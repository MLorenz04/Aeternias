<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Feedback </h5>
            <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form onsubmit="event.preventDefault(); send_feedback();" method="POST">
               <div class="mb-3">
                  <label for="username_feed" class="form-label">Vaše přezdívka</label>
                  <input type="text" class="form-control" id="username_feed" name="username_feed">
               </div>
               <div class="mb-3">
                  <label for="email_feed" class="form-label">Váš e-mail</label>
                  <input type="email" class="form-control" id="email_feed" name="email_feed">
               </div>
               <label for="textarea-mess" class="form-label">Zpráva</label>
               <textarea class="form-control" id="textarea-mess" rows="3"></textarea>
               <?php
               if (isset($_SESSION["error_mess_feedback"])) { ?>
                  <div class="error_message pb-3 alert alert-danger" id="error_mess_feedback">
                     <?php
                     echo $_SESSION["error_mess_feedback"];
                     unset($_SESSION["error_mess_feedback"]);
                     ?>
                  </div>
               <?php
               }
               ?>
            </form>
         </div>
         <div class="modal-footer">
            <button type="button" onclick="send_feedback()" class="btn btn-primary" data-dismiss="modal">Odeslat</button>
         </div>
      </div>
   </div>
</div>