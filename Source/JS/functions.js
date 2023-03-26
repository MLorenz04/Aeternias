function showErrorMess(msg) {
  Swal.fire({
    icon: "error",
    title: msg,
  });
}

function showSuccessMess(msg) {
  Swal.fire({
    icon: "success",
    title: msg,
  });
}

function showInfoMess(msg) {
  Swal.fire({
    icon: "info",
    title: msg,
  });
}
function showSuccessMessAndReload(msg) {
  Swal.fire({
    icon: "success",
    title: msg,
  }).then(function () {
    window.location.reload();
  });
}
function isEmpty(value) {
  return value === null || value === undefined || value === "" || value === 0;
}
