<div class="position-absolute modal-custom modal-custom-perbaiki {{ $active }} d-flex" id="modal-perbaiki-targeted"
    style="z-index: 10000;">
    <div class="close-modal position-absolute " wire:click='closeX()'>
    </div>
    <div class="modal-content">
        <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
            <h1>Perbaiki PDS : {{ $data['judul'] }}</h1>
            <i class="bi bi-x-lg" style="cursor: pointer;" wire:click='closeX()'></i>
        </div>
        <div class="box-modal-content p-3 overflow-auto">
            <div
                class="catatan-perbaikan border border-danger p-3 box-radius-10 position-relative mb-3 border-opacity-50">
                <h1 class="m-0 fs-6 position-absolute fw-medium text-danger px-1" style="top: -12px;background:white;">
                    Catatan Perbaikan : {{ $person }}
                </h1>
                {{ $history['pesan'] }}
            </div>
            <form method="POST" wire:submit.prevent='update_file' enctype="multipart/form-data">
                @csrf
                <input type="text" wire:model="judul" value="{{ $data['judul'] }}">
                <div class="mb-3">
                    <label class="form-label" for="fileUpload">Lampirkan Dokumen</label>
                    <div class="box-file position-relative border box-radius-10 overflow-hidden @error('file') is-invalid @enderror"
                        style="width:100%;">
                        <input type="file" id="fileUpload" class="bg-light position-absolute"
                            style="width:100%;padding:86px;opacity:0;" wire:model.defer='file'
                            onchange="getNameFile('formupload', 'fileUpload', 'displayname')">
                        <div class="display d-flex" style="width: 100%;height:200px">
                            <input name="file_name" type="text" id="displayname" class="border-0 form-control m-auto"
                                style="height:35px;text-align: center;">
                        </div>
                    </div>
                    @error('file')
                        <div id="validationServerUsernameFeedback" class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div wire:loading.remove>
                    <button type="submit" id="btn-upload"
                        class="btn btn-primary rounded-pill d-flex justity-content-center m-auto"
                        style="width: 100%;height:54px; padding:14px 0px;">
                        <div class="m-auto">
                            Submit
                        </div>
                    </button>
                </div>
                <div wire:loading style="width: 100%;">
                    <button disabled type="submit" id="btn-upload"
                        class="btn btn-primary rounded-pill d-flex justity-content-center"
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
                {{-- <div class="d-flex"> --}}
                {{-- <div wire:loading> --}}
                {{-- <div class="d-flex"> --}}
                {{-- <div wire:loading.class="d-flex">
                    <button disabled class="btn btn-primary d-flex rounded-pill" style="width: 100%; padding:14px 0px;">
                        <div class="d-flex m-auto align-items-center px-1 py-1">
                            <div class="loader d-flex">
                                <div class="point-loader rounded-circle point-loader1 bg-white"></div>
                                <div class="point-loader rounded-circle point-loader2 bg-white"></div>
                                <div class="point-loader rounded-circle point-loader3 bg-white"></div>
                            </div>
                        </div>
                    </button>
                </div> --}}
                {{-- </div> --}}
                {{-- </div> --}}
                {{-- <div wire:loading.remove>
                    <button type="submit" class="btn btn-primary rounded-pill"
                        style="width: 100%; padding:14px 0px;">Submit</button>
                </div> --}}
                {{-- </div> --}}
            </form>
        </div>
    </div>
</div>
