function start_event_upload(getjson) {
    let rawFile = new XMLHttpRequest();
    rawFile.overrideMimeType("application/json");
    rawFile.open("GET", getjson, true);
    rawFile.onreadystatechange = function () {
        if (rawFile.readyState === 4 && rawFile.status == "200") {
            let hapus = new XMLHttpRequest();
            hapus.overrideMimeType("application/json");
            let respon = JSON.parse(rawFile.response);
            for (let index = 0; index <= respon.length - 1; index++) {
                hapus.open(
                    "GET",
                    "http://127.0.0.1:8000/delete_upload/" +
                        respon[index]["id"],
                    true
                );
                hapus.send(null);
                let role = respon[index]["role"];
                let role_user = document.getElementById("role_refresh").value;
                for (let r_i = 0; r_i <= role.length - 1; r_i++) {
                    if (role[r_i] == role_user) {
                        event_upload(respon[index]["identitas"]);
                    }
                }
            }
        }
    };
    rawFile.send(null);
}

// start();

function start() {
    setTimeout(operation, 5000);
}

function operation() {
    start_event_upload("http://127.0.0.1:8000/get_upload");
    start();
}

function event_upload(identitas) {
    let btn = document.getElementById("refresh_btn");
    let dokumen = document.getElementById("new_dokumen");
    let jumlah = document.getElementById("jumlah");
    let id = document.getElementById("id_new_dokumen");
    let plus = parseInt(jumlah.value);

    // let for_role = event.pic;
    // for (let i = 0; i <= for_role.length - 1; i++) {
    //     if (role == for_role[i]) {
    id.value += "|" + identitas;
    btn.setAttribute("wire:click", `refresh('${id.value}')`);
    jumlah.value = plus + 1;
    btn.classList.remove("d-none");
    dokumen.innerHTML = jumlah.value;
    //     }
    // }
}
// alert(location.hostname + "get_upload");
