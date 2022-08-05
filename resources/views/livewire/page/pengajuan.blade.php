<div class="container-fluid" style="height: 90vh;overflow-y: auto;">
    <form class="filter bg-white p-3 box-radius-10">
        <div class="row">
            <div class="col-5">
                <label for="namanomor" onmouseup="formInput('o', 'inpnamanomor')">Nama atau Nomor
                    Dokumen</label>
                <div id="inpnamanomor" class="input-group namanomor box-radius-10 border mt-2">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" id="namanomor" class="form-control ps-0" placeholder="Nama / Nomor Dokumen">
                </div>
            </div>
            <div class="col-3">
                <label for="statusdokumen">Status Dokumen</label>
                <select id="statusdokumen" class="form-select mt-2" aria-label="Default select example"
                    style="padding: 10px;">
                    <option selected>Semua</option>
                    <option value="1">Ditinjau</option>
                    <option value="2">Selesai</option>
                    <option value="3">Dikembalikan</option>
                </select>
            </div>
            <div class="col-2">
                <label for="datepicker">Tanggal</label>
                <div class="input-group date border box-radius-10 mt-2">
                    <input id="datepicker" type="text" class="form-control" placeholder="Semua">
                    <label for="datepicker" class="input-group-text" id="basic-addon2"><i
                            class="bi bi-calendar-week-fill"></i></label>
                </div>
            </div>
            <div class="col-2">
                <div class="d-flex flex-column justify-content-between" style="height: 100%;">
                    <div class="bg-white p-1"></div>
                    <button type="button" class="btn btn-primary" style="padding: 10px;">Terapkan</button>
                </div>
            </div>
        </div>
    </form>
    <div class="bg-white box-radius-10 mt-3">
        <h1 class="title p-3 pb-1 m-0">Semua Dokumen</h1>
        <table class="table">
            <thead class="my-bg-dark text-white">
                <tr class="pengajuan">
                    <th scope="col" class="py-2 px-3 pe-0">No</th>
                    <th scope="col" class="py-2">Nomor Dokumen</th>
                    <th scope="col" class="py-2">Nama Dokumen</th>
                    <th scope="col" class="py-2">Status</th>
                    <th scope="col" class="py-2">Tgl Upload</th>
                    <th scope="col" class="py-2 px-3 ps-0">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="pengajuan">
                    <td class="py-2 px-3 pe-0">1</td>
                    <td class="py-2">123457ADB</td>
                    <td class="py-2">Lorem ipsum dolor sit amet</td>
                    <td class="py-2">
                        <div class="bg-primary-status text-center p-2 rounded-pill">
                            Ditinjau
                        </div>
                    </td>
                    <td class="py-2">17/01/2022</td>
                    <td class="py-2 px-3 ps-0">
                        <div class="d-flex">
                            <div class="box-icon rounded-circle bg-primary"
                                onclick="modalTarget('open','modal-detail-targeted')">
                                <i class="bi bi-folder-fill"></i>
                                <div class="my-tooltip d-none">
                                    <div class="segitiga"></div>
                                    <span>Detail & History</span>
                                </div>
                            </div>
                            <div class="box-icon rounded-circle bg-warning ms-1"
                                onclick="modalTarget('open', 'modal-edit-targeted')"><i class="bi bi-pen-fill"></i>
                                <div class="my-tooltip d-none">
                                    <div class="segitiga"></div>
                                    <span>Edit</span>
                                </div>
                            </div>
                            <div class="box-icon rounded-circle bg-danger ms-1"
                                onclick="modalTarget('open', 'modal-delete-targeted')"><i class="bi bi-trash-fill"></i>
                                <div class="my-tooltip d-none">
                                    <div class="segitiga"></div>
                                    <span>Delete</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="pengajuan">
                    <td class="py-2 px-3 pe-0">2</td>
                    <td class="py-2">123457ADB</td>
                    <td class="py-2">Lorem ipsum dolor sit amet</td>
                    <td class="py-2">
                        <div class="bg-danger-status text-center p-2 rounded-pill">
                            Dikembalikan
                        </div>
                    </td>
                    <td class="py-2">17/01/2022</td>
                    <td class="py-2 px-3 ps-0">
                        <div class="d-flex">
                            <div class="bg-danger w-100 p-2 text-center fw-medium text-white rounded-pill"
                                style="cursor: pointer;" onclick="modalTarget('open', 'modal-perbaiki-targeted')">
                                Perbaiki
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="pengajuan">
                    <td class="py-2 px-3 pe-0">3</td>
                    <td class="py-2">123457ADB</td>
                    <td class="py-2">Lorem ipsum dolor sit amet</td>
                    <td class="py-2">
                        <div class="bg-success-status text-center p-2 rounded-pill">
                            Selesai
                        </div>
                    </td>
                    <td class="py-2">17/01/2022</td>
                    <td class="py-2 px-3 ps-0">
                        <div class="d-flex">
                            <div class="box-icon rounded-circle bg-primary"><i class="bi bi-folder-fill"></i>
                                <div class="my-tooltip d-none">
                                    <div class="segitiga"></div>
                                    <span>Detail & History</span>
                                </div>
                            </div>
                            <div class="box-icon disable rounded-circle bg-warning ms-1"><i
                                    class="bi bi-pen-fill"></i>
                                <div class="my-tooltip d-none">
                                    <div class="segitiga"></div>
                                    <span>Edit</span>
                                </div>
                            </div>
                            <div class="box-icon rounded-circle bg-danger ms-1"><i class="bi bi-trash-fill"></i>
                                <div class="my-tooltip d-none">
                                    <div class="segitiga"></div>
                                    <span>Delete</span>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="position-absolute modal-custom modal-custom-perbaiki off d-flex" id="modal-delete-targeted"
    style="z-index: 100000;">
    <div class="close-modal position-absolute" onclick="modalTarget('close','modal-delete-targeted')">
    </div>
    <div class="modal-content">
        <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
            <h1>Hapus Dokumen : nama</h1>
            <i class="bi bi-x-lg" style="cursor: pointer;"
                onclick="modalTarget('close', 'modal-delete-targeted')"></i>
        </div>
        <div class="box-modal-content p-3 py-4 border-bottom" style="max-height: 85vh;overflow-y:auto">
            <p class="fs-6">Konfirmasi Penghapusan PDS : <strong>Nama</strong></p>
        </div>
        <div class="ms-auto p-3">
            <div class="d-flex">
                <button class="btn bg-primary-status p-2 px-4 rounded-pill"
                    onclick="modalTarget('close', 'modal-delete-targeted')">Batal</button>
                <button class="btn btn-danger p-2 px-4 rounded-pill ms-2">Hapus</button>
            </div>
        </div>
    </div>
</div>
<div class="position-absolute modal-custom modal-custom-detail off d-flex" id="modal-detail-targeted"
    style="z-index: 100000;">
    <div class="close-modal position-absolute" onclick="modalTarget('close','modal-detail-targeted')">
    </div>
    <div class="modal-content">
        <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
            <h1>Detail Dokumen : nama</h1>
            <i class="bi bi-x-lg" style="cursor: pointer;"
                onclick="modalTarget('close', 'modal-detail-targeted')"></i>
        </div>
        <div class="box-modal-content p-3" style="max-height: 85vh;overflow-y:auto">
            <form action="">
                <div class="mb-3">
                    <label for="nomordokumen" class="form-label">Nomor Dokumen</label>
                    <input type="text" class="form-control p-2 box-radius-10" id="nomordokumen"
                        placeholder="Pihak terkait" value="123RJOD" disabled>
                </div>
                <div class="mb-3">
                    <label for="namadokumen" class="form-label">Nama Dokumen</label>
                    <input type="text" class="form-control p-2 box-radius-10" id="namadokumen"
                        placeholder="Pihak terkait" value="PDS 1234" disabled>
                </div>
                <div class="mb-3">
                    <label for="downloadfile" class="form-label">Nama Dokumen</label>
                    <div class="download-file d-flex justify-content-between rounded p-2"
                        style="background: #F3F5FA;cursor:pointer;">
                        <div class="d-flex align-items-center">
                            <svg width="19" height="18" viewBox="0 0 19 18" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.40983 0H10.6327C10.6327 0.545986 10.6327 1.08993 10.6327 1.63591C12.8207 1.64818 15.0067 1.61342 17.1927 1.64818C17.6589 1.60115 18.0249 1.9631 17.982 2.42933C18.0168 6.45777 17.9738 10.4882 18.0024 14.5167C17.982 14.9297 18.0433 15.3878 17.8041 15.7538C17.5055 15.9665 17.119 15.9399 16.7714 15.9563C14.7245 15.9461 12.6796 15.9501 10.6327 15.9501C10.6327 16.4961 10.6327 17.0401 10.6327 17.5861H9.35462C6.2423 17.0176 3.1218 16.4961 0.00335024 15.9501C0.00130536 11.1794 0.00335024 6.40869 0.00335024 1.64C3.13816 1.09197 6.27502 0.558255 9.40983 0Z"
                                    fill="#2A5699" />
                                <path
                                    d="M10.6328 2.24945C12.8822 2.24945 15.1316 2.24945 17.3809 2.24945C17.3809 6.6112 17.3809 10.975 17.3809 15.3367C15.1316 15.3367 12.8822 15.3367 10.6328 15.3367C10.6328 14.7908 10.6328 14.2468 10.6328 13.7008C12.4057 13.7008 14.1766 13.7008 15.9495 13.7008C15.9495 13.4289 15.9495 13.1548 15.9495 12.8829C14.1766 12.8829 12.4057 12.8829 10.6328 12.8829C10.6328 12.5414 10.6328 12.2019 10.6328 11.8604C12.4057 11.8604 14.1766 11.8604 15.9495 11.8604C15.9495 11.5885 15.9495 11.3144 15.9495 11.0425C14.1766 11.0425 12.4057 11.0425 10.6328 11.0425C10.6328 10.701 10.6328 10.3615 10.6328 10.02C12.4057 10.02 14.1766 10.02 15.9495 10.02C15.9495 9.74806 15.9495 9.47404 15.9495 9.20207C14.1766 9.20207 12.4057 9.20207 10.6328 9.20207C10.6328 8.86058 10.6328 8.52113 10.6328 8.17963C12.4057 8.17963 14.1766 8.17963 15.9495 8.17963C15.9495 7.90766 15.9495 7.63364 15.9495 7.36167C14.1766 7.36167 12.4057 7.36167 10.6328 7.36167C10.6328 7.02018 10.6328 6.68073 10.6328 6.33923C12.4057 6.33923 14.1766 6.33923 15.9495 6.33923C15.9495 6.06726 15.9495 5.79324 15.9495 5.52127C14.1766 5.52127 12.4057 5.52127 10.6328 5.52127C10.6328 5.17978 10.6328 4.84033 10.6328 4.49883C12.4057 4.49883 14.1766 4.49883 15.9495 4.49883C15.9495 4.22686 15.9495 3.95284 15.9495 3.68087C14.1766 3.68087 12.4057 3.68087 10.6328 3.68087C10.6328 3.20441 10.6328 2.72591 10.6328 2.24945Z"
                                    fill="white" />
                                <path
                                    d="M4.23082 5.8626C4.61935 5.84011 5.00788 5.82375 5.39641 5.8033C5.66838 7.1836 5.94648 8.56186 6.24095 9.93603C6.47202 8.51687 6.72763 7.10181 6.97506 5.6847C7.38404 5.67038 7.79302 5.64789 8.19995 5.62335C7.73781 7.60485 7.33292 9.60271 6.82783 11.5719C6.48634 11.7498 5.97511 11.5638 5.57023 11.5924C5.29826 10.2387 4.9813 8.89313 4.73796 7.53328C4.4987 8.85428 4.18788 10.163 3.91387 11.4758C3.52125 11.4554 3.12658 11.4308 2.73192 11.4043C2.39247 9.60475 1.99372 7.81752 1.67676 6.01393C2.02643 5.99757 2.37815 5.98325 2.72783 5.97098C2.93845 7.27358 3.17771 8.57004 3.36175 9.87468C3.65008 8.53732 3.94454 7.19996 4.23082 5.8626Z"
                                    fill="white" />
                            </svg>
                            <p class="ms-2">PDS</p>
                        </div>
                        <i class="bi bi-download"></i>
                    </div>
                </div>
            </form>
            <div class="history overflow-hidden mt-4">
                <h3 class="fs-6 fw-semibold p-2 bg-primary text-white rounded-top m-0">History</h3>
                <div class="border border-top-0 p-2 rounded-bottom text-color">
                    <div class="box-history border rounded p-2 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fs-6 fw-semibold m-0">Mengajukan Perbaikan</h3>
                            <p class="m-0" style="font-size: 14px;">12/01/2022, 11:20</p>
                        </div>
                        <div class="d-flex mt-2">
                            <div class="profile"></div>
                            <div class="text ms-2">
                                <h3 class="fs-6 fw-medium m-0">Elon Musk</h3>
                                <p class="m-0">Mengajukan perbaikan dokumen </p>
                            </div>
                        </div>
                    </div>
                    <div class="box-history border rounded p-2 mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fs-6 fw-semibold m-0">PDS Di Upload</h3>
                            <p class="m-0" style="font-size: 14px;">11/01/2022, 11:20</p>
                        </div>
                        <div class="d-flex mt-2">
                            <div class="profile"></div>
                            <div class="text ms-2">
                                <h3 class="fs-6 fw-medium m-0">Thomeas</h3>
                                <p class="m-0">Mengajukan perbaikan dokumen </p>
                            </div>
                        </div>
                    </div>
                    <div class="box-history border rounded p-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <h3 class="fs-6 fw-semibold m-0">PDS Di Upload</h3>
                            <p class="m-0" style="font-size: 14px;">11/01/2022, 11:20</p>
                        </div>
                        <div class="d-flex mt-2">
                            <div class="profile"></div>
                            <div class="text ms-2">
                                <h3 class="fs-6 fw-medium m-0">Thomeas</h3>
                                <p class="m-0">Mengajukan perbaikan dokumen </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="position-absolute modal-custom modal-custom-perbaiki off d-flex" id="modal-perbaiki-targeted"
    style="z-index: 10000;">
    <div class="close-modal position-absolute " onclick="modalTarget('close','modal-perbaiki-targeted')">
    </div>
    <div class="modal-content">
        <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
            <h1>Perbaiki PDS : nama</h1>
            <i class="bi bi-x-lg" style="cursor: pointer;"
                onclick="modalTarget('close', 'modal-perbaiki-targeted')"></i>
        </div>
        <div class="box-modal-content p-3 overflow-auto">
            <div
                class="catatan-perbaikan border border-danger p-3 box-radius-10 position-relative mb-3 border-opacity-50">
                <h1 class="m-0 fs-6 position-absolute fw-medium text-danger px-1"
                    style="top: -12px;background:white;">
                    Catatan Perbaikan
                </h1>
            </div>
            <form action="">
                <div class="mb-3">
                    <label class="form-label">Lampirkan Dokumen</label>
                    <div class="border p-3 box-radius-10 dragdrop d-flex " style="height: 245px;">
                        <div class="d-flex flex-column align-items-center m-auto">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M22 15.3335V19.7779C22 20.3673 21.7659 20.9325 21.3491 21.3493C20.9324 21.766 20.3671 22.0002 19.7778 22.0002H4.22222C3.63285 22.0002 3.06762 21.766 2.65087 21.3493C2.23413 20.9325 2 20.3673 2 19.7779V15.3335"
                                    stroke="#4E5764" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                <path d="M17.5554 7.55556L11.9999 2L6.44434 7.55556" stroke="#4E5764"
                                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M12 2V15.3333" stroke="#4E5764" stroke-width="2.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            <span>Seret File Disini</span>
                            <span>atau</span>
                            <label for="file-upload-browse" class="text-primary" style="cursor:pointer;">Pilih
                                File</label>
                            <input type="file" id="file-upload-browse" class="d-none">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary rounded-pill"
                    style="width: 100%; padding:14px 0px;">Submit</button>
            </form>
        </div>
    </div>
</div>

<div class="position-absolute modal-custom modal-custom-upload off d-flex" id="modal-edit-targeted"
    style="z-index: 10000;">
    <div class="close-modal position-absolute " onclick="modalTarget('close','modal-edit-targeted')">
    </div>
    <div class="modal-content">
        <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
            <h1>Edit PDS : nama</h1>
            <i class="bi bi-x-lg" style="cursor: pointer;" onclick="modalTarget('close', 'modal-edit-targeted')"></i>
        </div>
        <div class="box-modal-content p-3 overflow-auto">
            <form action="">
                <div class="row overflow-auto" style="height: 70vh;">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="namadokumen" class="form-label">Nama Dokumen</label>
                            <input type="text" class="form-control p-2 box-radius-10" id="namadokumen"
                                placeholder="Pihak terkait">
                        </div>
                        <div class="mb-3">
                            <label for="nomordokumen" class="form-label">Nomor Dokumen</label>
                            <input type="text" class="form-control p-2 box-radius-10" id="nomordokumen"
                                placeholder="Pihak terkait">
                        </div>
                        <div class="mb-3">
                            <label for="jenisdokumen" class="form-label">Jenis Dokumen</label>
                            <select class="form-select p-2 box-radius-10" id="jenisdokumen"
                                aria-label="Default select example">
                                <option selected>Pilih Jenis Dokumen</option>
                                <option value="1">Panduan Mutu</option>
                                <option value="2">Prosedur</option>
                                <option value="3">Instruksi Kerja</option>
                                <option value="3">Test Procedure</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenispermohonan" class="form-label">Jenis Permohonan</label>
                            <select class="form-select p-2 box-radius-10" id="jenispermohonan"
                                aria-label="Default select example">
                                <option selected>Pilih Jenis Permohonan</option>
                                <option value="1">Penerbitan Dokumen Baru</option>
                                <option value="2">Perubahan Dokumen</option>
                                <option value="3">Penghapusan Dokumen</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="penanggungjawab" class="form-label">Penanggung Jawab</label>
                            <div class="d-flex flex-wrap">
                                <input type="checkbox" name="pengendali-dokumen" class="d-none btn-check-custom"
                                    id="pengendali-dokumen">
                                <label for="pengendali-dokumen" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i> Pengendali
                                    Dokumen</label>
                                <input type="checkbox" name="manager-iqa" class="d-none btn-check-custom"
                                    id="manager-iqa">
                                <label for="manager-iqa" class="btn-checkbox"><i class="bi bi-check-circle-fill"></i>
                                    Manager IQA</label>
                                <input type="checkbox" name="manager-urel" class="d-none btn-check-custom"
                                    id="manager-urel">
                                <label for="manager-urel" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i> Manager UREL</label>
                                <input type="checkbox" name="manager-deqa" class="d-none btn-check-custom"
                                    id="manager-deqa">
                                <label for="manager-deqa" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i> Manager DEQA</label>
                                <input type="checkbox" name="osm-tth" class="d-none btn-check-custom"
                                    id="osm-tth">
                                <label for="osm-tth" class="btn-checkbox"><i class="bi bi-check-circle-fill"></i>
                                    OSM TTH</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="deskripsikebutuhan" class="form-label">Deskripsi Kebutuhan</label>
                            <textarea class="form-control" id="deskripsikebutuhan" rows="5"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lampirkan Dokumen</label>
                            <div class="border p-3 box-radius-10 dragdrop d-flex " style="height: 245px;">
                                <div class="d-flex flex-column align-items-center m-auto">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M22 15.3335V19.7779C22 20.3673 21.7659 20.9325 21.3491 21.3493C20.9324 21.766 20.3671 22.0002 19.7778 22.0002H4.22222C3.63285 22.0002 3.06762 21.766 2.65087 21.3493C2.23413 20.9325 2 20.3673 2 19.7779V15.3335"
                                            stroke="#4E5764" stroke-width="2.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M17.5554 7.55556L11.9999 2L6.44434 7.55556" stroke="#4E5764"
                                            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M12 2V15.3333" stroke="#4E5764" stroke-width="2.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>Seret File Disini</span>
                                    <span>atau</span>
                                    <label for="file-upload-browse" class="text-primary"
                                        style="cursor:pointer;">Pilih
                                        File</label>
                                    <input type="file" id="file-upload-browse" class="d-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="btn btn-primary rounded-pill" style="width: 100%; padding:14px 0px;">Submit</button>
            </form>
        </div>
    </div>
</div>
