<div class="container-fluid" style="height: 90vh;overflow-y: auto;">
    <div class="info-data p-1 mb-3 d-flex">
        <div class="dokumen-diupload p-3 bg-white box-radius-10">
            <div class="d-flex">
                <div class="icon bg-primary rounded d-flex">
                    <i class="bi bi-file-earmark-arrow-up-fill m-auto"></i>
                </div>
                <p class="m-0 ms-2">Dokumen <br>Diupload</p>
            </div>
            <h1 class="m-0">{{ $activity['diupload'] }}</h1>
        </div>
        <div class="dokumen-disahkan p-3 bg-white box-radius-10 ms-3">
            <div class="d-flex">
                <div class="icon bg-success rounded d-flex">
                    <i class="bi bi-file-earmark-check-fill m-auto"></i>
                </div>
                <p class="m-0 ms-2">Dokumen <br>Selesai</p>
            </div>
            <h1 class="m-0">{{ $activity['disahkan'] }}</h1>
        </div>
        <div class="dalam-proses p-3 bg-white box-radius-10 ms-3">
            <div class="d-flex">
                <div class="icon bg-warning rounded d-flex">
                    <i class="bi bi-file-earmark-arrow-up-fill m-auto"></i>
                </div>
                <p class="m-0 ms-2">Dalam <br>Proses</p>
            </div>
            <h1 class="m-0">{{ $activity['proses'] }}</h1>
        </div>
    </div>
    <div class="pds-terbaru bg-white box-radius-20 pb-3">
        <div class="d-flex p-3 pb-1 justify-content-between">
            <h1 class="title">Need Follow Up</h1>
            <form action="">
                <input class="form-control" wire:model='q_tinjau' type="search" placeholder="Search Document"
                    aria-label="default input example">
            </form>
        </div>
        <div class="table">
            <div class="header-table px-4 text-white">
                <div class="row ps-3">
                    <div class="col-1">No</div>
                    <div class="col-2">Nomor Dokumen</div>
                    <div class="col-3">Judul Dokumen</div>
                    <div class="col-2">Pemohon</div>
                    <div class="col-2">Tgl Upload</div>
                    <div class="col-2">Aksi</div>
                </div>
            </div>
            <div class="data-table px-4">
                @if ($data->isEmpty())
                    <tr>
                        <td colspan="7">Tidak ada dokumen</td>
                    </tr>
                @else
                    @foreach ($data as $item)
                        <div class="row ps-3 align-items-center border-bottom">
                            <div class="col-1">1.</div>
                            <div class="col-2">{{ $item['nomor'] }}</div>
                            <div class="col-3 nama-dokumen">{{ $item['judul'] }}</div>
                            <div class="col-2 d-flex align-items-center">
                                <div class="prof-circle"
                                    @if ($item['photo'] == null) style="background-image: url({{ asset('assets/default.jpg') }})"
                        {{-- @else --}} @endif>
                                </div>
                                <span class="nama ms-2 m-0">{{ $item['pemohon'] }}</span>
                            </div>
                            <div class="col-2">{{ date('d/m/Y', strtotime($item['tgl'])) }}</div>
                            <div class="col-2">
                                <button
                                    wire:click='openTinjau("tinjau", {{ $item['id'] }}, "{{ $item['pengendali'] }}", "{{ $item['manager'] }}", "{{ $item['manajemen'] }}", "{{ $item['location'] }}")'
                                    onclick="wireClick('spiner{{ $item['id'] }}', 'eye{{ $item['id'] }}')"
                                    type="button" class="btn btn-primary">
                                    <div class="d-flex">
                                        <div id="spiner{{ $item['id'] }}" class="d-none">
                                            <span class="spinner-border spinner-border-sm  me-2" role="status"
                                                aria-hidden="true"></span>
                                        </div>
                                        <div id="eye{{ $item['id'] }}">
                                            <i class="bi bi-eye-fill me-2"></i>
                                        </div> <span>Tinjau</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="status-pds bg-white box-radius-20 mt-3 mb-3">
        <div class="d-flex p-3 align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <h1 class="title m-0 me-3">Tracker Document</h1>
                <form action="" class="me-3">
                    <input class="form-control" wire:model='q_tracking' type="search" placeholder="Search Document"
                        aria-label="default input example">
                </form>
                @if (session()->has('action'))
                    <div class="alert alert-success alert-dismissible fade show m-0 me-auto" role="alert"
                        style="width: 450px;padding:10px 10px !important;">
                        <div class="d-flex align-items-center justify-content-between">
                            <span>{{ session('action') }}</span>
                            <button type="button" class="btn-close p-0" data-bs-dismiss="alert" aria-label="Close"
                                style="position: unset !important"></button>
                        </div>
                    </div>
                @endif
            </div>
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
        <div class="row p-3 pt-1">
            <div class="col-5">
                <div class="data-pds px-1" style="max-height: 300px;overflow-y:auto;">
                    <div class="d-flex bg-white header fw-semibold text-color sticky-top" style="padding: 0px 10px;">
                        <div class="nama px-2">
                            Nama Dokumen
                        </div>
                        <div class="status px-2">
                            Status
                        </div>
                    </div>
                    @if ($tracking->isEmpty())
                    @else
                        @foreach ($tracking as $item)
                            <div wire:click="showInMonitor({{ $item['id'] }})"
                                class="d-flex data @if ($monitor['id'] == $item['id']) active @endif align-items-center box-radius-20 mt-2"
                                style="cursor: pointer">
                                <div class="nama px-2">
                                    {{ $item['judul'] }}
                                </div>

                                @if ($item['status'] == 1)
                                    <div class="status">
                                        <div class="bg-primary-status text-center p-2 rounded-pill">
                                            Ditinjau
                                        </div>
                                    </div>
                                @elseif($item['status'] == 2)
                                    <div class="status">
                                        <div class="bg-danger-status text-center p-2 rounded-pill">
                                            Dikembalikan
                                        </div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="col-7">
                <div class="box-radius-20 p-3 monitor" id="monitor">
                    <!-- monitor 1 -->
                    <div id="LoremIpsumissimply">
                        @if ($monitor != null)
                            <div class="d-flex align-items-center">
                                <h1>Pantau dokumen</h1>
                                <h2 class="bg-secondary p-2 rounded ms-2"><i class="bi bi-chevron-right"></i>
                                    {{ $monitor['judul'] }}</h2>
                            </div>
                            <div class="box-monitor d-flex mt-2 flex-column align-items-end">
                                <div class="d-flex justify-content-between" style="width: 100%;">
                                    <div class="point start active p-3 px-4 rounded-pill">
                                        Start
                                    </div>
                                    @php
                                        $rellToPicRed = 'off';
                                        $rellToPicBlue = 'active';
                                        $pic = 'active on';
                                    @endphp
                                    @if ($monitor['pic_status'] == true)
                                        @php
                                            $pic = 'active';
                                        @endphp
                                    @endif
                                    @if ($monitor['pengembali_dokumen'] == 'PIC')
                                        @php
                                            $rellToPicRed = 'active';
                                            $rellToPicBlue = 'off';
                                            $pic = 'bg-danger text-white';
                                        @endphp
                                    @endif
                                    <div class="rell-start-to-pic d-flex flex-column justify-content-evenly">
                                        <div class="red d-flex justify-content-between align-items-center ">
                                            <div class="circle rounded-circle {{ $rellToPicRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPicRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPicRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPicRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPicRed }}"></div>
                                            <div class="circle rounded-circle {{ $rellToPicRed }}"></div>
                                        </div>
                                        <div class="blue d-flex justify-content-between align-items-center ">
                                            <div class="circle rounded-circle {{ $rellToPicBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPicBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPicBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPicBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPicBlue }}"></div>
                                            <div class="circle rounded-circle {{ $rellToPicBlue }}"></div>
                                        </div>
                                    </div>
                                    <div class="point pic {{ $pic }} p-3 px-5 rounded-pill">
                                        PIC
                                    </div>
                                    @php
                                        $pihakterkait = 'off';
                                        $rellToPihakTerkaitRed = 'off';
                                        $rellToPihakTerkaitBlue = 'off';
                                    @endphp
                                    @if ($monitor['pic_status'] == true)
                                        @php
                                            $rellToPihakTerkaitRed = 'off';
                                            $rellToPihakTerkaitBlue = 'active';
                                            $pihakterkait = 'active';
                                        @endphp
                                    @endif
                                    @if ($monitor['pic_status'] == false &&
                                        $monitor['pengembali_dokumen'] != 'PIC' &&
                                        $monitor['pengembali_dokumen'] != null)
                                        @php
                                            $rellToPihakTerkaitRed = 'off';
                                            $rellToPihakTerkaitBlue = 'active';
                                            $pihakterkait = 'active on';
                                        @endphp
                                    @endif
                                    @if ($monitor['pengembali_dokumen'] == 'Pihak Terkait')
                                        @php
                                            $rellToPihakTerkaitRed = 'active';
                                            $rellToPihakTerkaitBlue = 'off';
                                            $pihakterkait = 'bg-danger text-white';
                                        @endphp
                                    @endif
                                    <div class="rell-pic-to-pihakterkait d-flex flex-column justify-content-evenly">
                                        <div class="red d-flex justify-content-between align-items-center ">
                                            <div class="circle rounded-circle {{ $rellToPihakTerkaitRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPihakTerkaitRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPihakTerkaitRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPihakTerkaitRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPihakTerkaitRed }}"></div>
                                            <div class="circle rounded-circle {{ $rellToPihakTerkaitRed }}"></div>
                                        </div>
                                        <div class="blue d-flex justify-content-between align-items-center ">
                                            <div class="circle rounded-circle {{ $rellToPihakTerkaitBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPihakTerkaitBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPihakTerkaitBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPihakTerkaitBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPihakTerkaitBlue }}"></div>
                                            <div class="circle rounded-circle {{ $rellToPihakTerkaitBlue }}"></div>
                                        </div>
                                    </div>
                                    <div class="point pihakterkait {{ $pihakterkait }} p-3 px-4 rounded-pill">
                                        Pihak Terkait
                                    </div>
                                </div>
                                @php
                                    $manajemen = 'off';
                                    $rellToManagemenRed = 'off';
                                    $rellToManagemenBlue = 'off';
                                @endphp
                                @if ($monitor['pihakterkait_status'] == true)
                                    @php
                                        $rellToManagemenRed = 'off';
                                        $rellToManagemenBlue = 'active';
                                        $manajemen = 'active';
                                    @endphp
                                @endif
                                @if ($monitor['pihakterkait_status'] == false &&
                                    $monitor['pengembali_dokumen'] != 'PIC' &&
                                    $monitor['pengembali_dokumen'] != 'Pihak Terkait' &&
                                    $monitor['pengembali_dokumen'] != null)
                                    @php
                                        $rellToManagemenRed = 'off';
                                        $rellToManagemenBlue = 'active';
                                        $manajemen = 'active on';
                                    @endphp
                                @endif
                                @if ($monitor['pengembali_dokumen'] == 'Manajemen')
                                    @php
                                        $rellToManagemenRed = 'active';
                                        $rellToManagemenBlue = 'off';
                                        $manajemen = 'bg-danger text-white';
                                    @endphp
                                @endif
                                <div class="rell-pihakterkait-to-manajemen d-flex justify-content-evenly mt-1 mb-1">
                                    <div class="blue d-flex flex-column justify-content-between align-items-center ">
                                        <div class="circle rounded-circle {{ $rellToManagemenBlue }}"></div>
                                        <div class="square rounded-pill {{ $rellToManagemenBlue }}"></div>
                                        <div class="circle rounded-circle {{ $rellToManagemenBlue }}"></div>
                                    </div>
                                    <div class="red d-flex flex-column justify-content-between align-items-center ">
                                        <div class="circle rounded-circle {{ $rellToManagemenRed }}"></div>
                                        <div class="square rounded-pill {{ $rellToManagemenRed }}"></div>
                                        <div class="circle rounded-circle {{ $rellToManagemenRed }}"></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between" style="width: 100%;">
                                    @php
                                        $finish = 'off';
                                        $rellToFinishRed = 'off';
                                        $rellToFinishBlue = 'off';
                                    @endphp
                                    @if ($monitor['status'] == 3)
                                        @php
                                            $finish = 'active';
                                            $rellToFinishRed = 'off';
                                            $rellToFinishBlue = 'active';
                                        @endphp
                                    @endif
                                    <div class="point finish {{ $finish }} p-3 px-4 rounded-pill">
                                        Finish
                                    </div>
                                    <div
                                        class="rell-pengendalidokumen-to-finish d-flex flex-column justify-content-evenly mt-1">
                                        <div class="red d-flex justify-content-between align-items-center ">
                                            <div class="circle rounded-circle {{ $rellToFinishRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToFinishRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToFinishRed }}"></div>
                                            <div class="circle rounded-circle {{ $rellToFinishRed }}"></div>
                                        </div>
                                        <div class="blue d-flex justify-content-between align-items-center ">
                                            <div class="circle rounded-circle {{ $rellToFinishBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToFinishBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToFinishBlue }}"></div>
                                            <div class="circle rounded-circle {{ $rellToFinishBlue }}"></div>
                                        </div>
                                    </div>
                                    @php
                                        $pengendali = 'off';
                                        $rellToPengendaliRed = 'off';
                                        $rellToPengendaliBlue = 'off';
                                    @endphp
                                    @if ($monitor['management_status'] == true)
                                        @php
                                            $rellToPengendaliRed = 'off';
                                            $rellToPengendaliBlue = 'active';
                                            $pengendali = 'active';
                                        @endphp
                                    @endif
                                    @if ($monitor['management_status'] == false &&
                                        $monitor['pengembali_dokumen'] != 'PIC' &&
                                        $monitor['pengembali_dokumen'] != 'Pihak Terkait' &&
                                        $monitor['pengembali_dokumen'] != 'Manajemen' &&
                                        $monitor['pengembali_dokumen'] != null)
                                        @php
                                            $rellToPengendaliRed = 'off';
                                            $rellToPengendaliBlue = 'active';
                                            $pengendali = 'active on';
                                        @endphp
                                    @endif
                                    @if ($monitor['pengembali_dokumen'] == 'Pengendali')
                                        @php
                                            $rellToPengendaliRed = 'active';
                                            $rellToPengendaliBlue = 'off';
                                            $pengendali = 'bg-danger text-white';
                                        @endphp
                                    @endif
                                    <div class="point pengendalidokumen {{ $pengendali }} p-3 px-4 rounded-pill">
                                        Pengendali Dokumen
                                    </div>
                                    <div
                                        class="rell-manajemen-to-pengendalidokumen d-flex flex-column justify-content-evenly mt-1">
                                        <div class="red d-flex justify-content-between align-items-center ">
                                            <div class="circle rounded-circle {{ $rellToPengendaliRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPengendaliRed }}"></div>
                                            <div class="square rounded-pill {{ $rellToPengendaliRed }}"></div>
                                            <div class="circle rounded-circle {{ $rellToPengendaliRed }}"></div>
                                        </div>
                                        <div class="blue d-flex justify-content-between align-items-center ">
                                            <div class="circle rounded-circle {{ $rellToPengendaliBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPengendaliBlue }}"></div>
                                            <div class="square rounded-pill {{ $rellToPengendaliBlue }}"></div>
                                            <div class="circle rounded-circle {{ $rellToPengendaliBlue }}"></div>
                                        </div>
                                    </div>
                                    <div class="point manajemen {{ $manajemen }} p-3 px-4 rounded-pill">
                                        Manajemen
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @if ($modal) --}}
    @if ($modal['for'] == 'upload')
        <livewire:logic.upload-pds :modalUpload="$modal['message']"></livewire:logic.upload-pds>
    @endif
    @if ($tinjau['for'] == 'tinjau')
        <livewire:logic.tinjau :attrTinjau="$tinjau"></livewire:logic.tinjau>
    @endif
    @if ($kembalikan['for'] == 'kembalikan')
        <livewire:logic.kembalikan-pds :attrKembalikan="$kembalikan"></livewire:logic.kembalikan-pds>
    @endif
    {{-- @endif --}}

    <!-- modal-custom-tinjau -->
    {{-- @if ($data)
        <div class="position-absolute modal-custom modal-custom-tinjau {{ $data['tinjau'] }} d-flex"
            id="modal-tinjau-targeted" style="z-index: 100000;">
            <div class="close-modal position-absolute " onclick="modalTarget('close','modal-tinjau-targeted')">
            </div>
            <div class="modal-content">
                <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
                    <h1>Tinjau Dokumen : {{ $data['name'] }}</h1>
                    <i class="bi bi-x-lg" style="cursor: pointer;"
                        onclick="modalTarget('close', 'modal-tinjau-targeted')"></i>
                </div>
                <div class="box-modal-content overflow-auto" style="max-height: 85vh;">
                    <div class="modal-pengaju border-bottom">
                        <div class="d-flex align-items-center">
                            <div class="modal-prof-circle"></div>
                            <div class="text-modal-prof ms-2">
                                <h1>Thomeas</h1>
                                <p>Engginer</p>
                            </div>
                        </div>
                        <button style="width: 80%;"
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
                            <i class="bi bi-download"></i>
                        </button>
                        <div class="deskripsi-kebutuhan mt-2 mb-3 ">
                            <h1>Deskripsi Kebutuhan :</h1>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ac feugiat
                                accumsan, aenean mattis varius nisi, lorem. Fringilla</p>
                        </div>
                    </div>
                    <form action="" class="mt-3" id="form-setujui">
                        <div class="mb-3">
                            <label for="pihakterkait" class="form-label">Pihak Terkait</label>
                            <div class="d-flex flex-wrap">
                                <input type="checkbox" name="pengendali-dokumen-tinjau"
                                    class="d-none btn-check-custom" id="pengendali-dokumen-tinjau">
                                <label for="pengendali-dokumen-tinjau" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i> Pengendali
                                    Dokumen</label>
                                <input type="checkbox" name="manager-iqa-tinjau" class="d-none btn-check-custom"
                                    id="manager-iqa-tinjau">
                                <label for="manager-iqa-tinjau" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i>
                                    Manager IQA</label>
                                <input type="checkbox" name="manager-urel-tinjau" class="d-none btn-check-custom"
                                    id="manager-urel-tinjau">
                                <label for="manager-urel-tinjau" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i>
                                    Manager UREL</label>
                                <input type="checkbox" name="manager-deqa-tinjau" class="d-none btn-check-custom"
                                    id="manager-deqa-tinjau">
                                <label for="manager-deqa-tinjau" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i>
                                    Manager DEQA</label>
                                <input type="checkbox" name="osm-tth-tinjau" class="d-none btn-check-custom"
                                    id="osm-tth-tinjau">
                                <label for="osm-tth-tinjau" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i>
                                    OSM TTH</label>
                            </div>
                        </div>

                        <label for="fileTinjau" class="form-label">Lampirkan Dokumen</label>
                        <div class="input-group position-relative mb-3">
                            <button class="btn btn-secondary box-radius-10 px-4" type="button"
                                id="button-addon1">Browse</button>
                            <input id="nameFileTinjau" type="text" class="form-control rounded-end roundTinjau"
                                placeholder="Pilih file">

                            <input type="file" class="form-control fileTinjau position-absolute" id="fileTinjau"
                                aria-describedby="inputGroupFileAddon04" aria-label="Upload"
                                onchange="getNameFile()">
                        </div>
                        <div class="mb-3">
                            <label for="komentar" class="form-label">Komentar</label>
                            <textarea class="form-control" id="komentar" rows="3"></textarea>
                        </div>
                        <div class="d-flex mt-3">
                            <button class="btn btn-primary my-btn-primary box-radius-10">Submit</button>
                            <button type="button" class="btn btn-danger my-btn-danger box-radius-10 ms-3"
                                onclick="SetujuiKembalikan('kembalikan', 'form-setujui', 'form-kembalikan')">Kembalikan</button>
                        </div>
                    </form>
                    <form action="" class="mt-3 d-none" id="form-kembalikan">
                        <div class="mb-3">
                            <label for="catatanperbaikan" class="form-label">Catatan Perbaikan</label>
                            <textarea class="form-control" id="catatanperbaikan" rows="3"></textarea>
                        </div>
                        <div class="d-flex mt-3">
                            <button class="btn btn-danger my-btn-danger box-radius-10">Kembalikan</button>
                            <button type="button" class="btn ms-2 text-primary box-radius-10"
                                onclick="SetujuiKembalikan('batal', 'form-setujui', 'form-kembalikan')">Batal</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif --}}
    <!-- end modal-custom-tinjau -->
    <!-- modal-custom-tinjau -->
    {{-- <div class="position-absolute modal-custom modal-custom-upload off d-flex" id="modal-upload-targeted"
        style="z-index: 10000;">
        <div class="close-modal position-absolute " onclick="modalTarget('close','modal-upload-targeted')">
        </div>
        <div class="modal-content">
            <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
                <h1>Upload PDS</h1>
                <i class="bi bi-x-lg" style="cursor: pointer;"
                    onclick="modalTarget('close', 'modal-upload-targeted')"></i>
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
                                    <label for="manager-iqa" class="btn-checkbox"><i
                                            class="bi bi-check-circle-fill"></i>
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
                                    <label for="osm-tth" class="btn-checkbox"><i
                                            class="bi bi-check-circle-fill"></i>
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
                                <div class="lampiran position-relative">
                                    <div class="upload-container box-radius-10 position-absolute" style="opacity:0;">
                                        <input type="file" id="fileUpload"
                                            onchange="getNameFile('fileUpload', 'nameUpload', 'hiddenUpload')" />
                                    </div>
                                    <div class="border p-3 box-radius-10 dragdrop d-flex " style="height: 302px;">
                                        <div class="d-flex flex-column align-items-center m-auto" id="hiddenUpload">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M22 15.3335V19.7779C22 20.3673 21.7659 20.9325 21.3491 21.3493C20.9324 21.766 20.3671 22.0002 19.7778 22.0002H4.22222C3.63285 22.0002 3.06762 21.766 2.65087 21.3493C2.23413 20.9325 2 20.3673 2 19.7779V15.3335"
                                                    stroke="#4E5764" stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M17.5554 7.55556L11.9999 2L6.44434 7.55556" stroke="#4E5764"
                                                    stroke-width="2.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
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
                                        <p id="nameUpload" class="text-color m-auto d-none text-center"> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary rounded-pill"
                        style="width: 100%; padding:14px 0px;">Submit</button>
                </form>
            </div>
        </div>
    </div> --}}
    <!-- end modal-custom-tinjau -->
</div>
