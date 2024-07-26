<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class Mahasiswa extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Model_mahasiswa');
    }
    public function index()
    {
        $data['judul'] = 'Crud data mahasiswa for ajax';
        $this->load->view('mahasiswa/header', $data);
        $this->load->view('mahasiswa/sidebar');
        $this->load->view('mahasiswa/index');
        $this->load->view('mahasiswa/footer');
    }
    public function index_pdf()
    {
        $data['mahasiswa'] = $this->db->get('mahasiswa')->result_array();
        $this->load->view('mahasiswa/laporan_pdf', $data);
    }
    public function ambildata()
    {
        $data = $this->Model_mahasiswa->ambildata();
        echo json_encode($data);
    }

    public function modaltambah()
    {
        if ($this->input->is_ajax_request() == true) {
            $pesan = [
                'sukses' => $this->load->view('action/modaltambah', '', true)
            ];
            echo json_encode($pesan);
        }
    }
    public function simpandata()
    {
        if ($this->input->is_ajax_request() == true) {
            $nama = $this->input->post('nama', true);
            $nrp = $this->input->post('nrp', true);
            $email = $this->input->post('email', true);
            $jurusan = $this->input->post('jurusan', true);

            $this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
                'required' => 'Nama harus di isi'
            ]);
            $this->form_validation->set_rules('nrp', 'nrp', 'trim|required', [
                'required' => 'nrp harus di isi'
            ]);
            $this->form_validation->set_rules('email', 'Email', 'trim|required', [
                'required' => 'email harus di isi'
            ]);
            $this->form_validation->set_rules('jurusan', 'Jurusan', 'trim|required', [
                'required' => 'jurusan harus di isi'
            ]);

            if ($this->form_validation->run() == false) {
                $pesan = [
                    'error' => 'semua data harus di isi!!'
                ];
                echo json_encode($pesan);
            } else {
                $data = [
                    'nama' => $nama,
                    'nrp' => $nrp,
                    'email' => $email,
                    'jurusan' => $jurusan
                ];

                $simpan = $this->Model_mahasiswa->inputData($data);
                if ($simpan) {
                    $pesan = [
                        'sukses' => 'Data berhasil ditambahkan'
                    ];
                    echo json_encode($pesan);
                }
            }
        }
    }

    public function modaledit($id)
    {
        $data['mahasiswa'] = $this->Model_mahasiswa->ambilid($id);
        if ($this->input->is_ajax_request() == true) {
            $pesan = [
                'sukses' => $this->load->view('action/modaledit', $data, true)
            ];
            echo json_encode($pesan);
        }
    }

    public function simpaneditdata()
    {
        if ($this->input->is_ajax_request() == true) {
            $nama = $this->input->post('nama', true);
            $nrp = $this->input->post('nrp', true);
            $email = $this->input->post('email', true);
            $jurusan = $this->input->post('jurusan', true);
            $this->form_validation->set_rules('nama', 'Nama', 'trim|required', [
                'required' => 'Nama harus di isi'
            ]);
            $this->form_validation->set_rules('nrp', 'Nrp', 'trim|required', [
                'required' => 'Nrp harus di isi'
            ]);
            $this->form_validation->set_rules('email', 'Email', 'trim|required', [
                'required' => 'Email harus di isi'
            ]);
            $this->form_validation->set_rules('jurusan', 'Jurusan', 'trim|required', [
                'required' => 'Jurusan harus di isi'
            ]);

            if ($this->form_validation->run() == false) {
                $pesan = [
                    'error' => 'Data tidak boleh kosongg !'
                ];
                echo json_encode($pesan);
            } else {
                $data = [
                    'nama' => $nama,
                    'nrp' => $nrp,
                    'email' => $email,
                    'jurusan' => $jurusan
                ];
                $edit = $this->Model_mahasiswa->edit($data);
                if ($edit) {
                    $pesan = [
                        'sukses' => 'Data berhasil diubah!'
                    ];
                    echo json_encode($pesan);
                }
            }
        }
    }

    public function hapus($id)
    {
        if ($this->input->is_ajax_request()) {
            $hapus = $this->Model_mahasiswa->hapus_data($id);
            if ($hapus) {
                $pesan = [
                    'sukses' => 'Data berhasil dihapus'
                ];
                echo json_encode($pesan);
            } else {
                $pesan = [
                    'error' => 'data gagal dihapus'
                ];
                echo json_encode($pesan);
            }
        }
    }

    public function pdf()
    {
        // panggil library yang kita buat sebelumnya yang bernama pdfgenerator
        $this->load->library('pdfgenerator');

        // title dari pdf
        $this->data['title_pdf'] = 'Laporan Data Mahasiswa';
        $this->data['mahasiswa'] = $this->db->get('mahasiswa')->result_array();

        // filename dari pdf ketika didownload
        $file_pdf = 'laporan_penjualan_toko_kita';
        // setting paper
        $paper = 'A4';
        //orientasi paper potrait / landscape
        $orientation = "portrait";

        $html = $this->load->view('mahasiswa/laporan_pdf', $this->data, true);

        // run dompdf
        $this->pdfgenerator->generate($html, $file_pdf, $paper, $orientation);
    }
    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
        ];
        $sheet->setCellValue('A1', "DATA MAHASISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
        $sheet->mergeCells('A1:E1'); // Set Merge Cell pada kolom A1 sampai E1
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1
        // Buat header tabel nya pada baris ke 3
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
        $sheet->setCellValue('B3', "NAMA"); // Set kolom B3 dengan tulisan "NIS"
        $sheet->setCellValue('C3', "NRP"); // Set kolom C3 dengan tulisan "NAMA"
        $sheet->setCellValue('D3', "EMAIL"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
        $sheet->setCellValue('E3', "JURUSAN"); // Set kolom E3 dengan tulisan "ALAMAT"
        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $sheet->getStyle('A2')->applyFromArray($style_col);
        $sheet->getStyle('B2')->applyFromArray($style_col);
        $sheet->getStyle('C2')->applyFromArray($style_col);
        $sheet->getStyle('D2')->applyFromArray($style_col);
        $sheet->getStyle('E2')->applyFromArray($style_col);
        // Panggil function view yang ada di SiswaModel untuk menampilkan semua data siswanya
        $data = $this->Model_mahasiswa->data();
        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach ($data as $dt) { // Lakukan looping pada variabel siswa
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $dt->nama);
            $sheet->setCellValue('C' . $numrow, $dt->nrp);
            $sheet->setCellValue('D' . $numrow, $dt->email);
            $sheet->setCellValue('E' . $numrow, $dt->jurusan);

            // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
            $sheet->getStyle('A' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('B' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('C' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('D' . $numrow)->applyFromArray($style_row);
            $sheet->getStyle('E' . $numrow)->applyFromArray($style_row);

            $no++; // Tambah 1 setiap kali looping
            $numrow++; // Tambah 1 setiap kali looping
        }
        // Set width kolom
        $sheet->getColumnDimension('A')->setWidth(5); // Set width kolom A
        $sheet->getColumnDimension('B')->setWidth(15); // Set width kolom B
        $sheet->getColumnDimension('C')->setWidth(25); // Set width kolom C
        $sheet->getColumnDimension('D')->setWidth(20); // Set width kolom D
        $sheet->getColumnDimension('E')->setWidth(30); // Set width kolom E

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya
        $sheet->setTitle("Laporan Data Mahasiswa");
        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Mahasiswa.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}
