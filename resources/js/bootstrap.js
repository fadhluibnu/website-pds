window._ = require("lodash");

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require("axios");

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

import Echo from "laravel-echo";

window.Pusher = require("pusher-js");

window.Echo = new Echo({
    broadcaster: "pusher",
    key: "pds_key",
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});
window.Echo.channel("for_pic").listen("EventForPic", (event) => {
    let role = document.getElementById("role_refresh").value;
    let btn = document.getElementById("refresh_btn");
    let dokumen = document.getElementById("new_dokumen");
    let jumlah = document.getElementById("jumlah");
    let id = document.getElementById("id_new_dokumen");
    let plus = parseInt(jumlah.value);
    let for_role = event.pic;
    for (let i = 0; i <= for_role.length - 1; i++) {
        if (role == for_role[i]) {
            console.log(for_role[i] + " : " + i);
            id.value += "|" + event.badge;
            btn.setAttribute("wire:click", `refresh('${id.value}')`);
            jumlah.value = plus + 1;
            // // if (plus >= 0) {
            // //     plus.value += 1;
            btn.classList.remove("d-none");
            // // }
            dokumen.innerHTML = jumlah.value;
        }
    }
});
window.Echo.channel("delete_pds").listen("EventDeleteDokumen", (event) => {
    console.log(event.id);
    let dihapus = document.getElementById(event.id + "hapus");
    let baru = document.getElementById(event.id + "baru");
    let status = document.getElementById(event.id + "status");
    let disable = document.querySelectorAll(`.aksi${event.id}`);
    disable[0].classList.add("disable");
    disable[0].removeAttribute("wire:click");
    disable[0].removeAttribute("onclick");
    disable[1].classList.add("disable");
    disable[1].removeAttribute("wire:click");
    disable[1].removeAttribute("onclick");
    dihapus.classList.remove("d-none");
    baru.classList.add("d-none");
    status.classList.add("bg-danger-status");
    status.classList.remove("bg-primary-status");
});
