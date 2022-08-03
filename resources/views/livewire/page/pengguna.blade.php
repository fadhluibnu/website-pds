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
                <label for="role">Role</label>
                <select id="role" class="form-select mt-2" aria-label="Default select example"
                    style="padding: 10px;">
                    <option selected>Semua</option>
                    <option value="1">OSM TTH</option>
                    <option value="2">Manager IQA</option>
                    <option value="3">Manager DEQA</option>
                    <option value="3">Manager UREL</option>
                </select>
            </div>
            <div class="col-2">
                <label for="role">Urutkan</label>
                <select id="role" class="form-select mt-2" aria-label="Default select example"
                    style="padding: 10px;">
                    <option selected>Semua</option>
                    <option value="1">Ditinjau</option>
                    <option value="2">Selesai</option>
                    <option value="3">Dikembalikan</option>
                </select>
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
                <tr class="pengguna">
                    <th scope="col" class="py-2 px-3 pe-0">No</th>
                    <th scope="col" class="py-2">NIK</th>
                    <th scope="col" class="py-2">Nama</th>
                    <th scope="col" class="py-2">Email</th>
                    <th scope="col" class="py-2">Role</th>
                    <th scope="col" class="py-2 px-3 ps-0">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr class="pengguna">
                    <td class="py-2 px-3 pe-0">1</td>
                    <td class="py-2">123457ADB</td>
                    <td class="py-2">Username</td>
                    <td class="py-2">Username@gmail.com</td>
                    <td class="py-2">Manager</td>
                    <td class="py-2 px-4 ps-0">
                        <div onclick="modalTarget('link', {{ route('detail-pengguna') }})"  class=" box-icon rounded-circle bg-primary" data-bs-toggle="tooltip"
                            data-bs-placement="bottom" data-bs-title="Profil">
                            <i class="bi bi-eye-fill m-auto"></i>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
