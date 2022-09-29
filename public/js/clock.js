function realtimeClock() {
    var timeDisplay = document.getElementById("realtime-clock");
    var dateString = new Date().toLocaleString("WIB", {
        timeZone: "Asia/Jakarta",
    });
    var formattedString = dateString.replace(" ", " | ");
    let name = formattedString.substr(formattedString.lastIndexOf("|") + 1);
    let pecah = name.split(".");
    timeDisplay.innerHTML = pecah[0] + ":" + pecah[1];
}
// start();
setInterval(realtimeClock, 1000);
// realtimeClock();
