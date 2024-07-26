<div class="modal fade" id="modaltambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data Mahasiswa</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('Mahasiswa/simpandata') ?>" class="simpandata">
                    <!-- <div class="pesan" style="display: none;"></div> -->
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="Nama" class="form-label">Nama Mahasiswa</label>
                            <input type="text" name="nama" class="form-control" id="Nama">

                        </div>
                        <div class="mb-3">
                            <label for="Nrp" class="form-label">Nrp Mahasiswa</label>
                            <input type="number" name="nrp" class="form-control" id="Nrp">

                        </div>
                        <div class="mb-3">
                            <label for="Email" class="form-label">email Mahasiswa</label>
                            <input type="text" name="email" class="form-control" id="Email">

                        </div>
                        <div class="mb-3">
                            <label for="Jurusan" class="form-label">Jurusan Mahasiswa</label>
                            <input type="text" name="jurusan" class="form-control" id="Jurusan">

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">SIMPAN DATA</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.simpandata').submit(function(e) {
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                dataType: 'json',
                success: function(response) {
                    if (response.error) {
                        swal({
                            title: "Gagal",
                            text: response.error,
                            icon: "warning",
                            button: "Kembali",
                        });
                    }
                    if (response.sukses) {
                        swal({
                            title: "Berhasil",
                            text: response.sukses,
                            icon: "success",
                            button: "Kembali",
                        });
                        $('#modaltambah').modal('hide');
                        ambilData();
                    }

                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status + "\n" + xhr.respone + "\n" + thrownError)
                }

            });
            return false;
        });

    });
</script>