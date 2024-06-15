// Initialize inactivityTimeout variable
inactivityTimeout = false

// Call resetTimeout function initially to start the inactivity timer
resetTimeout()

// Function triggered when user becomes inactive
function onUserInactivity() {
   window.location.href = "../outils/logout.php"
}

// Function to reset the inactivity timer
function resetTimeout() {
   clearTimeout(inactivityTimeout)
   inactivityTimeout = setTimeout(onUserInactivity, 1000 * 300)
}

// Attach an event handler to the window's onmousemove event
// This resets the inactivity timer every time the mouse is moved
window.onmousemove = resetTimeout
