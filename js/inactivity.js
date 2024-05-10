// Initialize inactivityTimeout variable
inactivityTimeout = false

// Call resetTimeout function initially to start the inactivity timer
resetTimeout()

// Function triggered when user becomes inactive
function onUserInactivity() {
      // Redirect user to logout.php page
   window.location.href = "../outils/logout.php"
}

// Function to reset the inactivity timer
function resetTimeout() {
      // Clear any existing inactivity timeout
   clearTimeout(inactivityTimeout)
      // Set a new inactivity timeout for 5 minutes (300 seconds)
   inactivityTimeout = setTimeout(onUserInactivity, 1000 * 300)
}

// Attach an event handler to the window's onmousemove event
// This resets the inactivity timer every time the mouse is moved
window.onmousemove = resetTimeout
