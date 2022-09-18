<div class="container-fluid" style="height: 90vh; overflow-y: auto">
    <div class="bg-white box-radius-10 pengaturan">
      <h1 class="title p-3">Pengaturan</h1>
      <h1 class="title p-3 py-2 fs-6 bg-primary text-white">Profil Akun</h1>
      <form class="p-3" action="">
        <div class="row mb-3">
          <div class="col-3">
            <label for="username" class="col-sm-2 col-form-label"
              >Username</label
            >
          </div>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control"
              id="username"
              value="Username"
            />
          </div>
        </div>
        <div class="row mb-3 ">
          <div class="col-3">
            <label for="nik" class="col-sm-2 col-form-label">NIK</label>
          </div>
          <div class="col-sm-8">
            <input
              type="text"
              class="form-control"
              id="nik"
              value="12345780"
              disabled
            />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-3">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
          </div>
          <div class="col-sm-8">
            <input
              type="email"
              class="form-control"
              id="email"
              value="@gmail.com"
            />
          </div>
        </div>
        <div class="row mb-3">
          <div class="col-3">
            <label for="password" class="col-sm-2 col-form-label"
              >Password</label
            >
          </div>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="password" value="" />
          </div>
        </div>
        <div class="row mb-3 align-items-center">
          <div class="col-3">
            <label for="password" class=" col-form-label"
              >Foto Profil</label
            >
          </div>
          <div class="col-8">
            <div class="row">
              <div class="col-6">
                <div class="profil">
                  <input type="file" class="my_type" />
                </div>
              </div>
              <div class="col-6">
                <div class="Delete text-end">Delete</div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>