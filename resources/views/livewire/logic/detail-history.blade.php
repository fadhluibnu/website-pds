<div class="position-absolute modal-custom modal-custom-detail {{ $active }} d-flex" id="modal-detail-targeted"
    style="z-index: 100000;">
    <div class="close-modal position-absolute" wire:click='closeX()'>
    </div>
    @foreach ($data as $item)
        <div class="modal-content">
            <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
                <h1>Detail Dokumen : {{ $item['judul'] }}</h1>
                <i class="bi bi-x-lg" style="cursor: pointer;" wire:click='closeX()'></i>
            </div>
            <div class="box-modal-content p-3" style="max-height: 85vh;overflow-y:auto">
                <form action="">
                    <div class="mb-3">
                        <label for="nomordokumen" class="form-label">Nomor Dokumen</label>
                        <input type="text" class="form-control p-2 box-radius-10" id="nomordokumen"
                            placeholder="Pihak terkait" value="{{ $item['nomor'] }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="namadokumen" class="form-label">Nama Dokumen</label>
                        <input type="text" class="form-control p-2 box-radius-10" id="namadokumen"
                            placeholder="Pihak terkait" value="{{ $item['judul'] }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="namadokumen" class="form-label">Jenis Dokumen</label>
                        <input type="text" class="form-control p-2 box-radius-10" id="namadokumen"
                            placeholder="Pihak terkait" value="{{ $item['jenisdokumen'] }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="namadokumen" class="form-label">Jenis Permohonan</label>
                        <input type="text" class="form-control p-2 box-radius-10" id="namadokumen"
                            placeholder="Pihak terkait" value="{{ $item['jenispermohonan'] }}" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="downloadfile" class="form-label">Download Dokumen</label>
                        <div onclick="wireClick('spinerEx', 'eyeEx')" wire:click='export("{{ $item['file'] }}")'
                            class="download-file d-flex justify-content-between rounded p-2"
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
                            <div onclick="wireClick('spinerEx', 'eyeEx')">
                                <div id="spinerEx" class="d-none">
                                    <span class="spinner-border spinner-border-sm  me-2" role="status"
                                        aria-hidden="true"></span>
                                </div>
                                <div id="eyeEx">
                                    <i class="bi bi-download"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="namadokumen" class="form-label">Penanggung Jawab</label>
                        <div class="d-flex">
                            @foreach ($pics as $pic)
                                @if ($pic == 'Lab Manager DEQA')
                                    <div class="btn-checkbox-detail rounded text-center"><i
                                            class="bi bi-check-circle-fill"></i>
                                        Manager DEQA</div>
                                @endif
                                @if ($pic == 'Lab Manager IQA')
                                    <div class="btn-checkbox-detail rounded text-center"><i
                                            class="bi bi-check-circle-fill"></i>
                                        Manager IQA</div>
                                @endif
                                @if ($pic == 'Lab Manager UREL')
                                    <div class="btn-checkbox-detail rounded text-center"><i
                                            class="bi bi-check-circle-fill"></i>
                                        Manager UREL</div>
                                @endif
                                @if ($pic == 'SM IAS')
                                    <div class="btn-checkbox-detail rounded text-center"><i
                                            class="bi bi-check-circle-fill"></i>
                                        OSM TTH</div>
                                @endif
                                @if ($pic == 'Document Controller 1')
                                    <div class="btn-checkbox-detail rounded text-center"><i
                                            class="bi bi-check-circle-fill"></i>
                                        Pengendali Dokumen</div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </form>
                <div class="history overflow-hidden mt-4">
                    <h3 class="fs-6 fw-semibold p-2 bg-primary text-white rounded-top m-0">History</h3>
                    <div class="border border-top-0 p-2 rounded-bottom text-color">
                        @foreach ($history as $item)
                            <div
                                class="box-history border @if ($item['type'] == 'catatan' || $item['type'] == 'catatan_now') border-danger @endif rounded p-2 mb-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="fw-semibold m-0" style="font-size: 14px;">
                                        {{ $item['judul'] }}</h3>
                                    <p class="m-0" style="font-size: 14px;">
                                        {{ $item['created_at']->diffForHumans() }}</p>
                                </div>
                                <div class="d-flex mt-2 justify-content-between">
                                    <div class="profile detail{{ $item['user_id'] }}"
                                        style="background-image: url({{ asset('assets/default.jpg') }})"></div>
                                    {{-- <style>
                                        .content .modal-custom .profile.detail{{ $item['user_id'] }} {
                                            background-image: url({{ env('URL_WEB_API') . 'storage/' . $item['photo'] }})
                                        }
                                    </style> --}}
                                    <div class="text ms-2" style="width: 510px;">
                                        <h3 class="fw-medium m-0" style="font-size: 14px;">
                                            {{ $item['user_name'] }}</h3>
                                        <p class="m-0" style="font-size: 14px;">
                                            {!! $item['pesan'] !!}</p>
                                    </div>
                                    <div class="px-4 ms-1">
                                        @if ($item['file'] != null)
                                            <div wire:click='exportHistory("{{ $item['file'] }}", "{{ $item['user_name'] }}")'
                                                class="btn btn-secondary d-flex" style="width: 42px;height: 38px;"
                                                onclick="wireClick('spinerEx{{ $item['id'] }}', 'eyeEx{{ $item['id'] }}')">
                                                <div id="spinerEx{{ $item['id'] }}" class="d-none m-auto">
                                                    <span class="spinner-border spinner-border-sm" role="status"
                                                        aria-hidden="true"></span>
                                                </div>
                                                <i id="eyeEx{{ $item['id'] }}"
                                                    class="bi bi-file-earmark-word-fill fs-6 m-auto"></i>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
