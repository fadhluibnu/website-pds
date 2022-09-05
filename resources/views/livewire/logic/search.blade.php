<div>
    <form wire:submit.prevent='search' class="filter bg-white p-3 box-radius-10">
        @csrf
        <input type="text" wire:model='search'>
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
</div>
