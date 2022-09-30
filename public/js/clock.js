function realtimeClock() {
    var timeDisplay = document.getElementById("realtime-clock");
    var dateString = new Date();
    var hour = dateString.getHours();
    var menit = dateString.getMinutes();
    timeDisplay.textContent =
        ("0" + hour).substr(-2) + ":" + ("0" + menit).substr(-2);
}
// start();
setInterval(realtimeClock, 1000);
// realtimeClock();
