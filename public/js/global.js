// Set timeout variables.
var timoutWarning = 840000; // Display warning in 14 Mins.
var timoutNow = 6000; // Warning has been shown, give the user 1 minute to interact
var logoutUrl = 'logout.php'; // URL to logout page.

var warningTimer;
var timeoutTimer;
// document.onkeypress=alert("keyporess");
// document.onmousemove=alert("Mouse Move");

// Start warning timer.
function StartWarningTimer() {
    warningTimer = setTimeout("IdleWarning()", timoutWarning);
}

// Reset timers.
function ResetTimeOutTimer() {
    clearTimeout(timeoutTimer);
    StartWarningTimer();
    $("#timeout").dialog('close');
}

// Show idle timeout warning dialog.
function IdleWarning() {
    clearTimeout(warningTimer);
    timeoutTimer = setTimeout("IdleTimeout()", timoutNow);
    alert("You will be automatically timed out in one minute.")
}

// Logout the user.
function IdleTimeout() {
    window.location = logoutUrl;
}