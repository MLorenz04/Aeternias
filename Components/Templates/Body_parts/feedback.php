<div class="modal fade" id="exampleModal" style="opacity:0">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"> Feedback </h5>
            <button type="button" class="close btn btn-secondary" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <form onsubmit="event.preventDefault(); send_feedback();" method="POST">
               <label for="textarea-mess" class="form-label">Zpráva</label>
               <textarea class="form-control" id="textarea-mess" rows="3"></textarea>
               <?php
               if (isset($_SESSION['error_mess_feedback'])) { ?>
                  <div class="error_message pb-3 alert alert-danger" id="error_mess_feedback">
                     <?php
                     echo $_SESSION['error_mess_feedback'];
                     unset($_SESSION['error_mess_feedback']);
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