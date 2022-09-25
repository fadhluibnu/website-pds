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
                    style="width: 600px;padding:10px 10px !important;">
                    <div class="d-flex align-items-center justify-content-between">
                        <span>{{ session('action') }}</span>
                        <button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close"
                            style="position: unset !important"></button>
                    </div>
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
                                @if ($item->status == 'Ditinjau')
                                    <div id="{{ $item->id . 'ditinjau' }}"
                                        class="bg-primary-status text-center p-2 rounded-pill">
                                        Ditinjau
                                    </div>
                                @endif
                                @if ($item->status == 'Dikembalikan')
                                    <div id="{{ $item->id . 'dikembalikan' }}"
                                        class="bg-danger-status text-center p-2 rounded-pill">
                                        Dikembalikan
                                    </div>
                                @endif
                                @if ($item->status == 'Selesai')
                                    <div id="{{ $item->id . 'selesai' }}"
                                        class="bg-success-status text-center p-2 rounded-pill">
                                        Selesai
                                    </div>
                                @endif
                            </td>
                            <td class="py-2">{{ date('d/m/Y', strtotime($item->created_at)) }}</td>
                            <td class="py-2 px-3 ps-0">
                                @if ($item->status == 'Ditinjau')
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
                                            wire:click='openModal("perbaiki", {{ $item->id }})'>
                                            Perbaiki
                                        </div>
                                    </div>
                                @endif
                                @if ($item->status == 'Dikembalikan')
                                    <div id="{{ $item->id . 'perbaiki' }}" class="d-flex">
                                        <div class="bg-danger w-100 p-2 py-1 text-center fw-medium text-white rounded-pill"
                                            style="cursor: pointer;"
                                            wire:click='openModal("perbaiki", {{ $item->id }})'
                                            onclick="wireClick('spinerPerbaiki{{ $item->id }}', 'folderPerbaiki{{ $item->id }}')">
                                            <span id="spinerPerbaiki{{ $item->id }}"
                                                class="spinner-border spinner-border-sm m-auto d-none" role="status"
                                                aria-hidden="true"></span>
                                            <span id="folderPerbaiki{{ $item->id }}"></span>
                                            Perbaiki
                                        </div>
                                    </div>
                                @endif
                                @if ($item->status == 'Selesai')
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
    @if ($modal['for'] == 'perbaiki')
        <livewire:logic.perbaiki :idDokumen="$modal['message']"></livewire:logic.perbaiki>
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
</div>
