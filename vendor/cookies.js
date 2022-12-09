function setCookie(key, value, expiry, path) {
  var expires = new Date();
  expires.setTime(expires.getTime() + expiry * 24 * 60 * 60 * 1000);
  document.cookie =
    key + "=" + value + ";expires=" + expires.toUTCString() + ";path=" + path;
}

function getCookie(key) {
  var keyValue = document.cookie.match("(^|;) ?" + key + "=([^;]*)(;|$)");
  return keyValue ? keyValue[2] : null;
}

function eraseCookie(key) {
  var keyValue = getCookie(key);
  setCookie(key, keyValue, "-1");
}