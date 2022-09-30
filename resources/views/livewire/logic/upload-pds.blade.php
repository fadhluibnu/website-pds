<div class="position-absolute modal-custom modal-custom-upload {{ $modalUpload }} d-flex" id="modal-upload-targeted"
    style="z-index: 10000;">
    <div class="close-modal position-absolute " wire:click='closeX()'>
    </div>
    <div class="modal-content">
        <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
            <h1>Upload PDS</h1>
            <i class="bi bi-x-lg" style="cursor: pointer;" wire:click='closeX()'></i>
        </div>
        <div class="box-modal-content p-3 overflow-auto">
            <form id="formupload" method="POST" wire:submit.prevent="storepds" enctype="multipart/form-data">
                @csrf
                <input type="hidden" wire:model='pemohon'>
                <input type="hidden" wire:model='status'>
                <input type="hidden" wire:model='location'>
                <div class="row overflow-auto border-bottom" style="height: 70vh;">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="namadokumen" class="form-label">Nama Dokumen</label>
                            <input type="text"
                                class="form-control p-2 box-radius-10 @error('judul') is-invalid @enderror"
                                id="namadokumen" placeholder="Nama Dokumen" wire:model='judul' required>
                            @error('judul')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="nomordokumen" class="form-label">Nomor Dokumen</label>
                            <input type="text"
                                class="form-control p-2 box-radius-10 @error('nomor') is-invalid @enderror"
                                id="nomordokumen" placeholder="Nomor Dokumen" wire:model='nomor' required>
                            @error('nomor')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenisdokumen" class="form-label">Jenis Dokumen</label>
                            <select class="form-select p-2 box-radius-10 @error('jenisdokumen') is-invalid @enderror"
                                id="jenisdokumen" aria-label="Default select example" wire:model='jenisdokumen'
                                required>
                                <option selected>Pilih Jenis Dokumen</option>
                                <option value="Panduan Mutu">Panduan Mutu</option>
                                <option value="Prosedur">Prosedur</option>
                                <option value="Instruksi Kerja">Instruksi Kerja</option>
                                <option value="Test Procedure">Test Procedure</option>
                            </select>
                            @error('jenisdokumen')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="jenispermohonan" class="form-label">Jenis Permohonan</label>
                            <select class="form-select p-2 box-radius-10 @error('jenispermohonan') is-invalid @enderror"
                                id="jenispermohonan" aria-label="Default select example" wire:model='jenispermohonan'
                                required>
                                <option selected>Pilih Jenis Permohonan</option>
                                <option value="Penerbitan Dokumen Baru">Penerbitan Dokumen Baru</option>
                                <option value="Perubahan Dokumen">Perubahan Dokumen</option>
                                <option value="Penghapusan Dokumen">Penghapusan Dokumen</option>
                            </select>
                            @error('jenispermohonan')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="penanggungjawab" class="form-label">Penanggung Jawab</label>
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
                                        <input type="checkbox" wire:model.defer="smias"
                                            class="d-none btn-check-custom" id="osm-tth" value="SM IAS">
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
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="deskripsikebutuhan" class="form-label">Deskripsi Kebutuhan</label>
                            <textarea class="form-control" id="deskripsikebutuhan" rows="5" wire:model='deskripsi'></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="fileUpload">Lampirkan Dokumen</label>
                            <div class="box-file position-relative border box-radius-10 overflow-hidden @error('file') is-invalid @enderror"
                                style="width:100%;">
                                <input type="file" id="fileUpload" class="bg-light position-absolute"
                                    style="width:100%;padding:86px;opacity:0;z-index:10000;" wire:model='file'
                                    onchange="getNameFile('formupload', 'fileUpload', 'displayname')">
                                <div class="display d-flex" style="width: 100%;height:200px">
                                    <div id="placeholder_form_file"
                                        class="{{ $placeholder_upload_fie }} position-absolute w-100">
                                        <div class="border p-3 box-radius-10 dragdrop d-flex " style="height: 245px;">
                                            <div class="d-flex flex-column align-items-center m-auto">
                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M22 15.3335V19.7779C22 20.3673 21.7659 20.9325 21.3491 21.3493C20.9324 21.766 20.3671 22.0002 19.7778 22.0002H4.22222C3.63285 22.0002 3.06762 21.766 2.65087 21.3493C2.23413 20.9325 2 20.3673 2 19.7779V15.3335"
                                                        stroke="#4E5764" stroke-width="2.5" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                    <path d="M17.5554 7.55556L11.9999 2L6.44434 7.55556"
                                                        stroke="#4E5764" stroke-width="2.5" stroke-linecap="round"
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
                                        </div>
                                    </div>
                                    <input name="file_name" type="text" id="displayname"
                                        class="border-0 form-control m-auto" style="height:35px;text-align: center;">
                                </div>
                            </div>
                            @error('file')
                                <div id="validationServerUsernameFeedback" class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div wire:loading.remove>
                    <button type="submit" id="btn-upload"
                        class="mt-3 btn btn-primary rounded-pill d-flex justity-content-center m-auto"
                        style="width: 100%;height:54px; padding:14px 0px;">
                        <div class="m-auto">
                            Submit
                        </div>
                    </button>
                </div>
                <div wire:loading style="width: 100%;">
                    <button disabled type="submit" id="btn-upload"
                        class="mt-3 btn btn-primary rounded-pill d-flex justity-content-center"
                        style="width: 100%;height:54px; padding:14px 0px;">
                        <div class="d-flex m-auto align-items-center">
                            <div class="loader d-flex">
                                <div class="point-loader rounded-circle point-loader1 bg-white"></div>
                                <div class="point-loader rounded-circle point-loader2 bg-white"></div>
                                <div class="point-loader rounded-circle point-loader3 bg-white"></div>
                            </div>
                        </div>
                    </button>
                </div>
                {!! $alertPic !!}
            </form>
        </div>
    </div>
</div>
