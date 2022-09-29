<div class="container-fluid" style="height: 90vh; overflow-y: auto">
    <a href="{{ route('pengguna') }}" class="nav-link btn d-inline-block p-2 text-primary"><i
            class="bi bi-arrow-left-circle-fill"></i> Kembali</a>
    <div>
        <div class="inpo-data p-1 mb-3 d-flex">
            <div class="detail-dokumen-diupload p-3 bg-white box-radius-10">
                <div class="d-flex">
                    <div class="icon bg-primary rounded d-flex">
                        <i class="bi bi-file-earmark-text-fill m-auto"></i>
                    </div>
                    <p class="m-0 ms-2">Total <br />Dokumen</p>
                </div>
                <h1 class="m-0">{{ $activity['total_dokumen'] }}</h1>
            </div>
            <div class="detail-dokumen-disahkan p-3 bg-white box-radius-10 ms-3">
                <div class="d-flex">
                    <div class="icon bg-success rounded d-flex">
                        <i class="bi bi-file-earmark-check-fill m-auto"></i>
                    </div>
                    <p class="m-0 ms-2">Dokumen <br />Selesai</p>
                </div>
                <h1 class="m-0">{{ $activity['dokumen_selesai'] }}</h1>
            </div>
            <div class="detail-dalam-proses p-3 bg-white box-radius-10 ms-3">
                <div class="d-flex">
                    <div class="icon bg-danger rounded d-flex">
                        <i class="bi bi-file-earmark-excel-fill m-auto"></i>
                    </div>
                    <p class="m-0 ms-2">Dalam <br />Dikembalikan</p>
                </div>
                <h1 class="m-0">{{ $activity['dokumen_dikembalikan'] }}</h1>
            </div>
            <div class="detail-dalam-proses p-3 bg-white box-radius-10 ms-3">
                <div class="d-flex">
                    <div class="icon bg-warning rounded d-flex">
                        <i class="bi bi-file-earmark-arrow-up-fill m-auto"></i>
                    </div>
                    <p class="m-0 ms-2">Dokumen <br />Ditinjau</p>
                </div>
                <h1 class="m-0">{{ $activity['dokumen_ditinjau'] }}</h1>
            </div>
        </div>
    </div>
    <div class="container-fluid box-profil bg-white box-radius-10 mt-3 p-3">
        <div class="row align-items-center">
            <div class="col-4">
                <div class="poto">
                    <div class="profile" style="background-image: url('../assets/thomeas.png')"></div>
                    <div class="d-flex p-3">
                        <p class="m-0 ms-2 p-1">Role</p>
                        <div class="icone bg-primary rounded d-flex">
                            <p class="engginer m-auto p-1">{{ $user['role'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-8">
                <div class="pro">
                    <form>
                        <div class="row mb-3">
                            <label for="inputNama" class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputNama" disabled
                                    value="{{ $user['name'] }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputNIK" class="col-sm-2 col-form-label">NIK</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputNIK" disabled
                                    value="{{ $user['id'] }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="inputEmail3"disabled
                                    value="{{ $user['email'] }}">
                            </div>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
