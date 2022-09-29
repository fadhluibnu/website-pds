<div class="position-absolute modal-custom modal-custom-tinjau {{ $active }} d-flex" id="modal-tinjau-targeted"
    style="z-index: 100000;">
    <div class="close-modal position-absolute " wire:click='closeX()'>
    </div>
    <div class="modal-content">
        @if ($ketersedian_dokumen != true)
            <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
                <h1>Tinjau Dokumen : {{ $data['judul'] }}</h1>
                <i class="bi bi-x-lg" style="cursor: pointer;" wire:click='closeX("null")'></i>
            </div>
            <div id="scroll-custom" class="box-modal-content overflow-auto" style="max-height: 85vh;">
                <div class="modal-pengaju border-bottom">
                    <div class="d-flex align-items-center">
                        <div class="modal-prof-circle"
                            style="background-image: url({{ env('URL_WEB_API') . 'storage/' . $api[0]['photo'] }})">
                        </div>
                        <div class="text-modal-prof ms-2">
                            <h1>{{ $api[0]['name'] }}</h1>
                            <p>{{ $api[0]['role'] }}</p>
                        </div>
                    </div>
                    <button style="width: 80%;" wire:click='export("{{ $data['file'] }}", "{{ $data['judul'] }}")'
                        class="btn d-flex border p-3 mt-3 box-radius-10 dokumen align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <svg width="27" height="26" viewBox="0 0 27 26" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13.6041 0H15.3725C15.3725 0.789556 15.3725 1.57616 15.3725 2.36571C18.5366 2.38345 21.6978 2.33318 24.859 2.38345C25.5332 2.31544 26.0625 2.83885 26.0004 3.51308C26.0507 9.33865 25.9886 15.1672 26.03 20.9927C26.0004 21.5901 26.0891 22.2525 25.7432 22.7818C25.3114 23.0893 24.7525 23.0509 24.2498 23.0746C21.2897 23.0598 18.3326 23.0657 15.3725 23.0657C15.3725 23.8552 15.3725 24.6418 15.3725 25.4314H13.5243C9.02353 24.6093 4.51094 23.8552 0.00131428 23.0657C-0.00164285 16.1667 0.00131428 9.26767 0.00131428 2.37163C4.5346 1.57911 9.07084 0.807299 13.6041 0Z"
                                    fill="#2A5699" />
                                <path
                                    d="M15.3726 3.25293C18.6254 3.25293 21.8783 3.25293 25.1311 3.25293C25.1311 9.5605 25.1311 15.871 25.1311 22.1786C21.8783 22.1786 18.6254 22.1786 15.3726 22.1786C15.3726 21.389 15.3726 20.6025 15.3726 19.8129C17.9364 19.8129 20.4973 19.8129 23.0611 19.8129C23.0611 19.4196 23.0611 19.0233 23.0611 18.63C20.4973 18.63 17.9364 18.63 15.3726 18.63C15.3726 18.1362 15.3726 17.6453 15.3726 17.1515C17.9364 17.1515 20.4973 17.1515 23.0611 17.1515C23.0611 16.7582 23.0611 16.3619 23.0611 15.9686C20.4973 15.9686 17.9364 15.9686 15.3726 15.9686C15.3726 15.4748 15.3726 14.9839 15.3726 14.4901C17.9364 14.4901 20.4973 14.4901 23.0611 14.4901C23.0611 14.0968 23.0611 13.7005 23.0611 13.3072C20.4973 13.3072 17.9364 13.3072 15.3726 13.3072C15.3726 12.8134 15.3726 12.3225 15.3726 11.8286C17.9364 11.8286 20.4973 11.8286 23.0611 11.8286C23.0611 11.4353 23.0611 11.0391 23.0611 10.6458C20.4973 10.6458 17.9364 10.6458 15.3726 10.6458C15.3726 10.1519 15.3726 9.66105 15.3726 9.1672C17.9364 9.1672 20.4973 9.1672 23.0611 9.1672C23.0611 8.7739 23.0611 8.37765 23.0611 7.98435C20.4973 7.98435 17.9364 7.98435 15.3726 7.98435C15.3726 7.49051 15.3726 6.99962 15.3726 6.50578C17.9364 6.50578 20.4973 6.50578 23.0611 6.50578C23.0611 6.11248 23.0611 5.71622 23.0611 5.32293C20.4973 5.32293 17.9364 5.32293 15.3726 5.32293C15.3726 4.63391 15.3726 3.94194 15.3726 3.25293Z"
                                    fill="white" />
                                <path
                                    d="M6.11485 8.47794C6.67671 8.44541 7.23856 8.42176 7.80042 8.39219C8.19372 10.3883 8.59589 12.3814 9.02171 14.3686C9.35587 12.3163 9.72551 10.27 10.0833 8.22067C10.6748 8.19997 11.2662 8.16744 11.8547 8.13196C11.1863 10.9974 10.6008 13.8866 9.87041 16.7343C9.37657 16.9915 8.63729 16.7224 8.05177 16.7638C7.65847 14.8062 7.20012 12.8604 6.84822 10.8939C6.50223 12.8042 6.05275 14.6968 5.65649 16.5953C5.08872 16.5657 4.518 16.5302 3.94727 16.4918C3.45638 13.8895 2.87974 11.305 2.42139 8.69677C2.92706 8.67311 3.43568 8.65241 3.94135 8.63467C4.24594 10.5184 4.59192 12.3932 4.85807 14.2799C5.27502 12.3459 5.70085 10.4119 6.11485 8.47794Z"
                                    fill="white" />
                            </svg>
                            <p class="m-0 ms-2">PDS</p>
                        </div>
                        <div wire:loading wire:target='export'>
                            <span id="spinerDetail" class="text-color spinner-border spinner-border-sm m-auto"
                                role="status" aria-hidden="true"></span>
                        </div>
                        <div wire:loading.remove wire:target='export'>
                            <i class="bi bi-download"></i>
                        </div>
                    </button>
                    <div class="deskripsi-kebutuhan mt-2 mb-3 ">
                        <h1>Deskripsi Kebutuhan :</h1>
                        <p>{{ $data['deskripsi'] }}</p>
                    </div>
                </div>
                <form wire:submit.prevent='tinjau_pds' class="mt-3" id="form-setujui" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" wire:model='idDock'>
                    <input type="hidden" wire:model='judul'>
                    <input type="hidden" wire:model='as_view'>
                    <input type="hidden" wire:model='role'>
                    <input type="hidden" wire:model='location'>
                    <input type="hidden" wire:model='id_peninjau'>
                    <input type="hidden" wire:model='old_file'>
                    @if ($location == 'PIC')
                        <div class="mb-3">
                            <label for="pihakterkait" class="form-label">Pihak Terkait</label>
                            <div class="d-flex flex-wrap">
                                <div class="row">
                                    <div class="col-6 pe-1">
                                        <input type="checkbox" wire:model.defer="manageriqa"
                                            class="d-none btn-check-custom" id="manager-iqa" value="Lab Manager IQA">
                                        <label for="manager-iqa" class="btn-checkbox text-center"><i
                                                class="bi bi-check-circle-fill"></i>
                                            Manager IQA</label>
                                    </div>
                                    <div class="col-6 ps-1">
                                        <input type="checkbox" wire:model.defer="managerurel"
                                            class="d-none btn-check-custom" id="manager-urel" value="Lab Manager UREL">
                                        <label for="manager-urel" class="btn-checkbox text-center"><i
                                                class="bi bi-check-circle-fill"></i>
                                            Manager UREL</label>
                                    </div>
                                    <div class="col-6 pe-1">
                                        <input type="checkbox" wire:model.defer="managerdeqa"
                                            class="d-none btn-check-custom" id="manager-deqa" value="Lab Manager DEQA">
                                        <label for="manager-deqa" class="btn-checkbox text-center"><i
                                                class="bi bi-check-circle-fill"></i>
                                            Manager DEQA</label>
                                    </div>
                                    <div class="col-6 ps-1">
                                        <input type="checkbox" wire:model.defer="smias" class="d-none btn-check-custom"
                                            id="osm-tth" value="SM IAS">
                                        <label for="osm-tth" class="btn-checkbox text-center"><i
                                                class="bi bi-check-circle-fill"></i>
                                            OSM TTH</label>
                                    </div>
                                    <div class="col-12">
                                        <input type="checkbox"
                                            wire:model.defer="pengendalidokumen"class="d-none btn-check-custom"
                                            id="pengendali-dokumen" value="Document Controller 1">
                                        <label for="pengendali-dokumen" class="btn-checkbox text-center"><i
                                                class="bi bi-check-circle-fill"></i>
                                            Pengendali Dokumen</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <label for="fileTinjau" class="form-label">Lampirkan Dokumen</label>
                    <div class="input-group position-relative mb-3">
                        <label for="fileTinjau" class="rounded-start px-4 bg-secondary d-flex text-white"
                            style="z-index: 8;" type="button"><span class="m-auto">Browse</span></label>
                        <input id="nameFileTinjau" type="text" class="form-control rounded-end roundTinjau"
                            placeholder="Pilih file">

                        <input type="file" class="ms-3 form-control fileTinjau position-absolute" id="fileTinjau"
                            aria-describedby="inputGroupFileAddon04" wire:model='file' aria-label="Upload">
                    </div>
                    <div class="mb-3">
                        <label for="komentar" class="form-label">Komentar</label>
                        <textarea class="form-control" id="komentar" rows="3" wire:model='komentar' required></textarea>
                    </div>
                    <div class="d-flex mt-3">

                        <button wire:loading wire:target='komentar,file,tinjau_pds' disabled
                            class="btn btn-primary my-btn-primary box-radius-10">
                            <div class="d-flex m-auto align-items-center px-1 py-1">
                                <div class="loader d-flex">
                                    <div class="point-loader rounded-circle point-loader1 bg-white"></div>
                                    <div class="point-loader rounded-circle point-loader2 bg-white"></div>
                                    <div class="point-loader rounded-circle point-loader3 bg-white"></div>
                                </div>
                            </div>
                        </button>

                        <button wire:loading.remove wire:target='komentar,file,tinjau_pds'
                            class="btn btn-primary my-btn-primary box-radius-10" type="submit">Submit</button>
                        @if ($data['jenispermohonan'] != 'Penghapusan Dokumen')
                            <div wire:loading wire:target='kembalikan' disabled
                                class="btn btn-primary my-btn-danger box-radius-10 ms-3 text-danger">
                                <div class="d-flex m-auto align-items-center px-1 py-1">
                                    <div class="loader d-flex">
                                        <div class="point-loader rounded-circle point-loader1 bg-danger"></div>
                                        <div class="point-loader rounded-circle point-loader2 bg-danger"></div>
                                        <div class="point-loader rounded-circle point-loader3 bg-danger"></div>
                                    </div>
                                </div>
                            </div>
                            <div type="button" class="btn btn-danger my-btn-danger box-radius-10 ms-3"
                                wire:loading.remove wire:target='kembalikan'
                                wire:click='kembalikan({{ $idDock }})'>
                                Kembalikan</div>
                        @endif
                        {{-- @endif --}}
                    </div>
                    {!! $alertPic !!}
                </form>
                <form wire:submit.prevent="kembalikan({{ $idDock }})" class="mt-3 d-none" id="form-kembalikan">
                    <div class="mb-3">
                        <label for="catatanperbaikan" class="form-label">Catatan Perbaikan</label>
                        <textarea class="form-control" id="catatanperbaikan" rows="3" wire:model='komentar' required></textarea>
                    </div>
                    <div class="d-flex mt-3">
                        <button class="btn btn-danger my-btn-danger box-radius-10" type="submit">Kembalikan</button>
                        <button type="button" class="btn ms-2 text-primary box-radius-10"
                            onclick="SetujuiKembalikan('batal', 'form-setujui', 'form-kembalikan')">Batal</button>
                    </div>
                </form>
            </div>
        @endif
        @if ($ketersedian_dokumen == true)
            <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
                <h1>Alert</h1>
                <i class="bi bi-x-lg" style="cursor: pointer;" wire:click='closeDelete'></i>
            </div>
            <div class="box-modal-content p-3 py-4 border-bottom" style="max-height: 85vh;overflow-y:auto">
                <p class="fs-6">Dokumen telah mengalami perubahan</strong></p>
            </div>
            <div class="ms-auto p-3">
                <div class="d-flex">
                    <button wire:loading disabled class="btn bg-primary border-0 rounded-pill"
                        style="height: 46px;width: 106px;">
                        <div class="d-flex align-items-center">
                            <div class="loader m-auto d-flex">
                                <div class="point-loader rounded-circle point-loader1 bg-white"></div>
                                <div class="point-loader rounded-circle point-loader2 bg-white"></div>
                                <div class="point-loader rounded-circle point-loader3 bg-white"></div>
                            </div>
                        </div>
                    </button>
                    <button wire:loading.remove class="btn bg-primary text-white border-0 rounded-pill"
                        wire:click='closeX("null")' style="height: 46px;width: 106px;">Refresh</button>
                </div>
            </div>
        @endif
    </div>
</div>
