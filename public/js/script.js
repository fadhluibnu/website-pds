function modalTarget(param, id) {
  if (param == "open") {
    document.getElementById(id).classList.remove("off");
    document.getElementById(id).classList.add("active");
  }
  if (param == "close") {
    document.getElementById(id).classList.add("off");
    document.getElementById(id).classList.remove("active");
  }
}
function getNameFile() {
  const nameFile = document.getElementById("fileTinjau").value;
  document.getElementById("nameFileTinjau").value = nameFile.substr(
    nameFile.lastIndexOf("\\") + 1
  );
}
document
  .getElementById("komenter-monitor")
  .addEventListener("mouseover", function () {
    document
      .getElementById("fullscreen-komen-monitor")
      .classList.remove("d-none");
  });
document
  .getElementById("komenter-monitor")
  .addEventListener("mouseleave", function () {
    document.getElementById("fullscreen-komen-monitor").classList.add("d-none");
  });
function fullscreenKomentar(param) {
  const monitor = document.getElementById("monitor");
  const icon = document.getElementById("icon-fullscreen");
  const button = document.getElementById("fullscreen-komen-monitor");
  const komenter = document.getElementById("komenter-monitor");
  const boxKomenter = document.getElementById("box-komentar-monitor");

  if (param == "maximize") {
    button.setAttribute("onclick", "fullscreenKomentar('minimize')");
    monitor.classList.add("position-relative");
    komenter.classList.add("position-absolute");
    komenter.classList.add("active");
    boxKomenter.classList.add("full");
    icon.classList.add("bi-fullscreen-exit");
    komenter.classList.remove("position-relative");
    icon.classList.remove("bi-fullscreen");
  }
  if (param == "minimize") {
    button.setAttribute("onclick", "fullscreenKomentar('maximize')");
    monitor.classList.remove("position-relative");
    komenter.classList.remove("position-absolute");
    komenter.classList.remove("active");
    boxKomenter.classList.remove("full");
    icon.classList.remove("bi-fullscreen-exit");
    komenter.classList.add("position-relative");
    icon.classList.add("bi-fullscreen");
  }
}
function SetujuiKembalikan(aksi, setujui, kembalikan) {
  const formSetuju = document.getElementById(setujui);
  const formKembalikan = document.getElementById(kembalikan);
  if (aksi == "kembalikan") {
    formSetuju.classList.add("d-none");
    formKembalikan.classList.remove("d-none");
  }
  if (aksi == "batal") {
    formSetuju.classList.remove("d-none");
    formKembalikan.classList.add("d-none");
  }
}
function formSearchHeader(aksi, formid, headerid, resultid) {
  const form = document.getElementById(formid);
  const header = document.getElementById(headerid);
  const result = document.getElementById(resultid);

  if (aksi == "o") {
    header.classList.add("position-relative");
    form.classList.add("position-absolute");
    result.classList.remove("d-none");
  }
  if (aksi == "c") {
    header.classList.remove("position-relative");
    form.classList.remove("position-absolute");
    result.classList.add("d-none");
  }
}
function formInput(aksi, id) {
  const elemen = document.getElementById(id);
  if (aksi == "o") {
    elemen.setAttribute(
      "style",
      "box-shadow:0 0 0 0.25rem rgb(13 110 253 / 25%);border-color:#86b7fe !important;"
    );
  }
}
