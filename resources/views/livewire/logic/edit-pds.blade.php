<div class="position-absolute modal-custom modal-custom-upload {{ $active }} d-flex" id="modal-upload-targeted"
    style="z-index: 10000;">
    <div class="close-modal position-absolute " wire:click='closeX()'>
    </div>
    <div class="modal-content">
        <div class="header-modal border-bottom d-flex align-items-center justify-content-between">
            <h1>Upload PDS</h1>
            <i class="bi bi-x-lg" style="cursor: pointer;" wire:click='closeX()'></i>
        </div>
        <div class="box-modal-content p-3 overflow-auto">
            <form wire:submit.prevent="updatepds" enctype="multipart/form-data">
                @csrf
                <input type="hidden" wire:model='idUpdate'>
                <input type="hidden" wire:model='pemohon'>
                <input type="hidden" wire:model='status'>
                <input type="hidden" wire:model='user_name'>
                @if ($management)
                    <input type="hidden" wire:model='management'>
                @endif
                @if ($pengendali)
                    <input type="hidden" wire:model='pengendali'>
                @endif
                <div class="row overflow-auto" style="height: 70vh;">
                    <div class="col-6">
                        <div class="mb-3">
                            <label for="namadokumen" class="form-label">Nama Dokumen</label>
                            <input type="text"
                                class="form-control p-2 box-radius-10 @error('judul') is-invalid @enderror"
                                id="namadokumen" placeholder="Pihak terkait" wire:model='judul' required>
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
                                id="nomordokumen" placeholder="Pihak terkait" wire:model='nomor' required>
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
                                @foreach ($jenisdok as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->name }}</option>
                                @endforeach
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
                                @foreach ($jenisper as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
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
                                <input type="checkbox" wire:model.defer="pengendalidokumen"
                                    class="d-none btn-check-custom" id="pengendali-dokumen" value="Document Controller">
                                <label for="pengendali-dokumen" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i> Pengendali
                                    Dokumen</label>
                                <input type="checkbox" wire:model.defer="manageriqa" class="d-none btn-check-custom"
                                    id="manager-iqa" value="Lab Manager IQA">
                                <label for="manager-iqa" class="btn-checkbox"><i class="bi bi-check-circle-fill"></i>
                                    Manager IQA</label>
                                <input type="checkbox" wire:model.defer="managerurel" class="d-none btn-check-custom"
                                    id="manager-urel" value="Lab Manager UREL">
                                <label for="manager-urel" class="btn-checkbox"><i class="bi bi-check-circle-fill"></i>
                                    Manager UREL</label>
                                <input type="checkbox" wire:model.defer="managerdeqa" class="d-none btn-check-custom"
                                    id="manager-deqa" value="Lab Manager DEQA">
                                <label for="manager-deqa" class="btn-checkbox"><i
                                        class="bi bi-check-circle-fill"></i>
                                    Manager DEQA</label>
                                <input type="checkbox" wire:model.defer="smias" class="d-none btn-check-custom"
                                    id="osm-tth" value="2">
                                <label for="osm-tth" class="btn-checkbox"><i class="bi bi-check-circle-fill"></i>
                                    OSM TTH</label>
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
                            <div class="box-file position-relative border box-radius-10 overflow-hidden"
                                style="width:100%;">
                                <input type="file" id="fileUpload" class="bg-light position-absolute"
                                    style="width:100%;padding:86px;opacity:0;" wire:model='file'
                                    onchange="getNameFile('fileUpload', 'nameFile')">
                                <div class="display d-flex" style="width: 100%;height:200px">
                                    <input type="text" id="nameFile" class="border-0 form-control m-auto"
                                        style="height:35px;text-align: center;">
                                </div>
                            </div>
                        </div>
                    </div>
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
                {!! $alertPic !!}
            </form>
        </div>
    </div>
</div>
