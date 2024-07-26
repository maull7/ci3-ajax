<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Data Mahasiswa</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Daftar daftar Mahasiswa</li>
            </ol>
            <div class="row">
                <div class="col-lg-12 d-flex align-items-center">

                    <button class="btn btn-success mb-4" id="tambah">TAMBAH DATA MAHASISWA</button>
                    <a href="<?= base_url('Mahasiswa/pdf'); ?>" class="btn btn-warning ms-3 mb-4">PDF</a>
                    <a href="<?= base_url('Mahasiswa/excel'); ?>" class="btn btn-warning ms-3 mb-4">EXCEL</a>
                </div>
            </div>
            <table class="table table-dark table-striped">
                <thead>
                    <tr>
                        <th>NAMA</th>
                        <th>NRP</th>
                        <th>EMAIL</th>
                        <th>JURUSAN</th>
                        <th>ACTION</th>
                    </tr>
                </thead>
                <tbody id="target">

                </tbody>
            </table>



        </div>
        <div class="viewmodal" style="display : none ;"></div>

    </main>

    <script>
        ambilData();

        function ambilData() {
            $.ajax({
                type: 'POST',
                url: '<?= base_url('Mahasiswa/ambildata'); ?>',
                dataType: 'json',
                success: function(data) {
                    let baris = '';
                    for (let i = 0; i < data.length; i++) {
                        baris += '<tr>' +
                            '<td>' + data[i].nama + '</td>' +
                            '<td>' + data[i].nrp + '</td>' +
                            '<td>' + data[i].email + '</td>' +
                            '<td>' + data[i].jurusan + '</td>' +
                            '<td>' + '<button class="btn btn-primary" onclick="edit(' + data[i].id + ')"> EDIT </button>' + '<button class="btn btn-danger ms-2" onclick="hapus(' + data[i].id + ')">HAPUS</button > ' + ' </td>' +
                            '</tr>'
                    }
                    $('#target').html(baris);
                }
            });
        }

        $(document).ready(function() {
            $('#tambah').click(function(e) {
                $.ajax({
                    url: "<?= base_url('Mahasiswa/modaltambah'); ?>",
                    dataType: 'json',
                    success: function(response) {
                        if (response.sukses) {
                            $('.viewmodal').html(response.sukses).show();
                            $('#modaltambah').modal('show');
                        }
                    }
                })
            });
        });





        function edit(id) {
            $.ajax({
                url: "<?= base_url('Mahasiswa/modaledit/'); ?>" + id,
                dataType: 'json',
                success: function(response) {
                    if (response.sukses) {
                        $('.viewmodal').html(response.sukses).show();
                        $('#modaledit').modal('show');
                    }
                }
            });
        }

        function hapus(id) {
            swal({
                    title: "Apa kamu yakin ingin menghapus ?",
                    text: "Jika data ini dihapus maka akan hilang !",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,

                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'post',
                            url: "<?= base_url('Mahasiswa/hapus/'); ?>" + id,
                            dataType: 'json',
                            success: function(response) {
                                if (response.sukses) {
                                    swal("Kamu berhasil mengahpus data !", {
                                        icon: "success",
                                    });
                                    ambilData();
                                }
                                if (reponse.error) {
                                    swal("Kamu gagal menghapus data !", {
                                        icon: "warning",
                                    });
                                }
                            }
                        });

                    } else {
                        swal("Data kamu tidak jadi di hapus !");
                    }
                });


        }
    </script>