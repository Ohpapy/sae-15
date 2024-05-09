
inactivityTimeout = false
resetTimeout()
function onUserInactivity() {
   window.location.href = "../outils/logout.php"
}
function resetTimeout() {
   clearTimeout(inactivityTimeout)
   inactivityTimeout = setTimeout(onUserInactivity, 1000 * 300)
}
window.onmousemove = resetTimeout
