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
            <thead class="my-bg-dark text-white" style="position: sticky;top: -12px;z-index: 10;">
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
                @foreach ($users as $item)
                    <tr class="pengguna">
                        <td class="py-2 px-3 pe-0">{{ $loop->iteration }}</td>
                        <td class="py-2">{{ $item['nik'] }}</td>
                        <td class="py-2">{{ $item['name'] }}</td>
                        <td class="py-2">{{ $item['email'] }}</td>
                        <td class="py-2">{{ $item['role'] }}</td>
                        <td class="py-2 px-4 ps-0">
                            <a href="{{ route('detail-pengguna', $item['nik']) }}"
                                class="btn box-icon rounded-circle btn-primary p-2">
                                <i class="bi bi-eye-fill m-auto"></i>
                                <div class="my-tooltip d-none">
                                    <div class="segitiga"></div>
                                    <span>Detail</span>
                                </div>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
