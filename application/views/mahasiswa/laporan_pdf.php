<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title_pdf ?></title>
</head>

<body>
    <h4 style="text-align: center;">Daftar Mahasiswa</h4>
    <table>
        <thead>
            <tr>
                <th>NAMA</th>
                <th>NRP</th>
                <th>EMAIL</th>
                <th>JURUSAN</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mahasiswa as $mhs) : ?>
                <tr>
                    <td><?= $mhs['nama']; ?></td>
                    <td><?= $mhs['nrp']; ?></td>
                    <td><?= $mhs['email']; ?></td>
                    <td><?= $mhs['jurusan']; ?></td>
                </tr>
        </tbody>
    <?php endforeach; ?>
    </table>
</body>

</html>