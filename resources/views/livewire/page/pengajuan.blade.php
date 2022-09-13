<div class="container-fluid" style="height: 90vh;overflow-y: auto;">
    {{-- <livewire:logic.search></livewire:logic.search> --}}
    <form wire:submit.prevent='search' class="filter bg-white p-3 box-radius-10">
        @csrf
        <input type="hidden" wire:model='search'>
        <div class="row">
            <div class="col-4">
                <label for="namanomor" onmouseup="formInput('o', 'inpnamanomor')">Judul Dokumen</label>
                <div id="inpnamanomor" class="input-group namanomor box-radius-10 border mt-2">
                    <span class="input-group-text" id="basic-addon1"><i class="bi bi-search"></i></span>
                    <input type="text" id="namanomor" wire:model.defer="judul" class="form-control ps-0"
                        placeholder="Nama / Nomor Dokumen">
                </div>
            </div>
            <div class="col-3">
                <label for="statusdokumen">Status Dokumen</label>
                <select id="statusdokumen" class="form-select mt-2 box-radius-10" aria-label="Default select example"
                    style="padding: 10px;" wire:model.defer='status'>
                    <option value="" selected>Semua</option>
                    <option value="Ditinjau">Ditinjau</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Dikembalikan">Dikembalikan</option>
                </select>
            </div>
            <div class="col-3">
                <label for="datepicker">Tanggal</label>
                <div class="input-group mt-2 box-radius-10">
                    <a wire:click='clear' class="btn btn-outline-secondary" type="button" id="button-addon1"
                        style="padding: 10px;margin: auto;">Clear
                    </a>
                    <input id="dateinput" wire:model.defer='tanggal' type="date"
                        class="inputTanggal form-control border" placeholder="Semua"
                        aria-label="Example text with button addon" aria-describedby="button-addon1">
                </div>
            </div>
            <div class="col-2">
                <div class="d-flex flex-column justify-content-between" style="height: 100%;">
                    <div class="bg-white p-1"></div>
                    <button type="submit" class="btn btn-primary" style="padding: 10px;">Terapkan</button>
                </div>
            </div>
        </div>
    </form>
    <div class="bg-white box-radius-10 mt-3 semua-dokumen">
        <div class="d-flex p-3 align-items-center justify-content-between pb-1">
            <h1 class="title m-0 me-4">Semua Dokumen</h1>
            @if (session()->has('action'))
                <div class="alert alert-success alert-dismissible fade show m-0 me-auto" role="alert"
                    style="width: 400px;">
                    {{ session('action') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <button wire:click='openModal("upload", "active")' onclick="wireClick('spinerUpload', 'eyeUpload')"
                type="button" class="btn btn-primary box-radius-10 mybutton">
                <div class="d-flex">
                    <div id="spinerUpload" class="d-none">
                        <span class="spinner-border spinner-border-sm  me-2" role="status" aria-hidden="true"></span>
                    </div>
                    <div id="eyeUpload">
                        <i class="bi bi-file-earmark-arrow-up-fill me-1"></i>
                    </div>
                    Upload PDS
                </div>
            </button>
        </div>
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
                @if ($dokumen->isEmpty())
                    <tr>
                        <td colspan="6">Tidak ada dokumen</td>
                    </tr>
                @else
                    @foreach ($dokumen as $item)
                        <tr class="pengajuan" style="line-height: 2;">
                            <td class="py-2 px-3 pe-0">{{ $loop->iteration }}</td>
                            <td class="py-2">{{ $item->nomor }}</td>
                            <td class="py-2">{{ $item->judul }}</td>
                            <td class="py-2">
                                @if ($item->status == 1)
                                    <div id="{{ $item->id . 'ditinjau' }}"
                                        class="bg-primary-status text-center p-2 rounded-pill">
                                        Ditinjau
                                    </div>
                                @endif
                                @if ($item->status == 2)
                                    <div id="{{ $item->id . 'dikembalikan' }}"
                                        class="bg-danger-status text-center p-2 rounded-pill">
                                        Dikembalikan
                                    </div>
                                @endif
                                @if ($item->status == 3)
                                    <div id="{{ $item->id . 'selesai' }}"
                                        class="bg-success-status text-center p-2 rounded-pill">
                                        Selesai
                                    </div>
                                @endif
                            </td>
                            <td class="py-2">{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                            <td class="py-2 px-3 ps-0">
                                @if ($item->status == 1)
                                    <div class="d-flex">
                                        <div id="{{ $item->id . 'detail' }}"
                                            class="box-icon rounded-circle bg-primary"
                                            wire:click='openModal("detail", {{ $item->id }})'
                                            onclick="wireClick('spinerDetail{{ $item->id }}', 'folderDetail{{ $item->id }}')">
                                            <span id="spinerDetail{{ $item->id }}"
                                                class="spinner-border spinner-border-sm m-auto d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i id="folderDetail{{ $item->id }}" class="bi bi-folder-fill"></i>
                                            <div class="my-tooltip d-none">
                                                <div class="segitiga"></div>
                                                <span>Detail & History</span>
                                            </div>
                                        </div>
                                        <div id="{{ $item->id . 'edit' }}"
                                            class="box-icon rounded-circle bg-warning ms-1"
                                            wire:click='openModal("edit", {{ $item->id }})'
                                            onclick="wireClick('spinerEdit{{ $item->id }}', 'penEdit{{ $item->id }}')">
                                            <span id="spinerEdit{{ $item->id }}"
                                                class="spinner-border spinner-border-sm m-auto d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i id="penEdit{{ $item->id }}" class="bi bi-pen-fill"></i>
                                            <div class="my-tooltip d-none">
                                                <div class="segitiga"></div>
                                                <span>Edit</span>
                                            </div>
                                        </div>
                                        <div id="{{ $item->id . 'hapus' }}"
                                            class="box-icon rounded-circle bg-danger ms-1"
                                            wire:click='openModal("delete", {{ $item->id }})'
                                            onclick="wireClick('spinerDelete{{ $item->id }}', 'penDelete{{ $item->id }}')">
                                            <span id="spinerDelete{{ $item->id }}"
                                                class="spinner-border spinner-border-sm m-auto d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i id="penDelete{{ $item->id }}" class="bi bi-trash-fill"></i>
                                            <div class="my-tooltip d-none">
                                                <div class="segitiga"></div>
                                                <span>Delete</span>
                                            </div>
                                        </div>
                                        <div id="{{ $item->id . 'perbaiki' }}"
                                            class="d-none bg-danger w-100 p-2 py-0 text-center fw-medium text-white rounded-pill"
                                            style="cursor: pointer;"
                                            onclick="modalTarget('open', 'modal-perbaiki-targeted')">
                                            Perbaiki
                                        </div>
                                    </div>
                                @endif
                                @if ($item->status == 2)
                                    <div id="{{ $item->id . 'perbaiki' }}" class="d-flex">
                                        <div class="bg-danger w-100 p-2 py-0 text-center fw-medium text-white rounded-pill"
                                            style="cursor: pointer;"
                                            onclick="modalTarget('open', 'modal-perbaiki-targeted')">
                                            Perbaiki
                                        </div>
                                    </div>
                                @endif
                                @if ($item->status == 3)
                                    <div class="d-flex">
                                        <div id="{{ $item->id . 'detail' }}"
                                            class="box-icon rounded-circle bg-primary"
                                            wire:click='openModal("detail", {{ $item->id }})'
                                            onclick="wireClick('spinerDetail{{ $item->id }}', 'folderDetail{{ $item->id }}')">
                                            <span id="spinerDetail{{ $item->id }}"
                                                class="spinner-border spinner-border-sm m-auto d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i id="folderDetail{{ $item->id }}" class="bi bi-folder-fill"></i>
                                            <div class="my-tooltip d-none">
                                                <div class="segitiga"></div>
                                                <span>Detail & History</span>
                                            </div>
                                        </div>
                                        <div id="{{ $item->id . 'edit' }}"
                                            class="box-icon disable rounded-circle bg-warning ms-1">
                                            <span id="spinerEdit{{ $item->id }}"
                                                class="spinner-border spinner-border-sm m-auto d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i id="penEdit{{ $item->id }}" class="bi bi-pen-fill"></i>
                                            <div class="my-tooltip d-none">
                                                <div class="segitiga"></div>
                                                <span>Edit</span>
                                            </div>
                                        </div>
                                        <div id="{{ $item->id . 'delete' }}"
                                            class="box-icon disable rounded-circle bg-danger ms-1">
                                            <span id="spinerDelete{{ $item->id }}"
                                                class="spinner-border spinner-border-sm m-auto d-none" role="status"
                                                aria-hidden="true"></span>
                                            <i id="penDelete{{ $item->id }}" class="bi bi-trash-fill"></i>
                                            <div class="my-tooltip d-none">
                                                <div class="segitiga"></div>
                                                <span>Delete</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach

                @endif
                {{-- <tr class="pengajuan">
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
                </tr> --}}
            </tbody>
        </table>
    </div>
    @if ($modal['for'] == 'upload')
        <livewire:logic.upload-pds :modalUpload="$modal['message']"></livewire:logic.upload-pds>
    @endif
    @if ($modal['for'] == 'detail')
        <livewire:logic.detail-history :idDokumen="$modal['message']"></livewire:logic.detail-history>
    @endif
    @if ($modal['for'] == 'edit')
        <livewire:logic.edit-pds :idDokumen="$modal['message']"></livewire:logic.edit-pds>
    @endif
    @if ($modal['for'] == 'delete')
        <div class="position-absolute modal-custom modal-custom-perbaiki {{ $modal['delete'] }} d-flex"
            id="modal-delete-targeted" style="z-index: 100000;">
            <div class="close-modal position-absolute" wire:click='closeDelete'>
            </div>
            <div class="modal-content">
                <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
                    <h1>Hapus Dokumen : {{ $deleteName }}</h1>
                    <i class="bi bi-x-lg" style="cursor: pointer;" wire:click='closeDelete'></i>
                </div>
                <div class="box-modal-content p-3 py-4 border-bottom" style="max-height: 85vh;overflow-y:auto">
                    <p class="fs-6">Konfirmasi Penghapusan PDS : <strong>{{ $deleteName }}</strong></p>
                </div>
                <div class="ms-auto p-3">
                    <div class="d-flex">
                        <button wire:loading wire:target='closeDelete' disabled
                            class="btn bg-primary-status p-2 px-4 rounded-pill">
                            <div class="d-flex m-auto align-items-center">
                                <div class="loader d-flex">
                                    <div class="point-loader rounded-circle point-loader1 bg-primary"></div>
                                    <div class="point-loader rounded-circle point-loader2 bg-primary"></div>
                                    <div class="point-loader rounded-circle point-loader3 bg-primary"></div>
                                </div>
                            </div>
                        </button>
                        <button class="btn bg-primary-status p-2 px-4 rounded-pill" wire:loading.remove
                            wire:click='closeDelete'>Batal</button>

                        <button wire:loading wire:target='deletePds' disabled
                            class="btn btn-danger p-3 px-4 rounded-pill ms-2">
                            <div class="d-flex m-auto align-items-center">
                                <div class="loader d-flex">
                                    <div class="point-loader rounded-circle point-loader1 bg-white"></div>
                                    <div class="point-loader rounded-circle point-loader2 bg-white"></div>
                                    <div class="point-loader rounded-circle point-loader3 bg-white"></div>
                                </div>
                            </div>
                        </button>
                        <button class="btn btn-danger p-2 px-4 rounded-pill ms-2" wire:loading.remove
                            wire:click='deletePds({{ $modal['message'] }}, {{ $deleteNomor }})'>Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($modal['for'] == 'perbaiki')
        {
        <div class="position-absolute modal-custom modal-custom-perbaiki active d-flex" id="modal-perbaiki-targeted"
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
                        <button type="submit" class="btn btn-primary rounded-pill"
                            style="width: 100%; padding:14px 0px;">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        }
    @endif
</div>
