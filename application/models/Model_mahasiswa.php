<?php
class Model_mahasiswa extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ambildata()
    {
        return $this->db->get('mahasiswa')->result_array();
    }
    public function inputData($data)
    {
        return $this->db->insert('mahasiswa', $data);
    }
    public function ambilid($id)
    {
        return $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
    }
    public function edit($data)
    {
        $this->db->where('id', $this->input->post('id'));
        return $this->db->update('mahasiswa', $data);
    }
    public function hapus_data($id)
    {
        $data = $this->db->get_where('mahasiswa', ['id' => $id])->row_array();
        return $this->db->delete('mahasiswa', $data);
    }
    public function data()
    {
        return $this->db->get('mahasiswa')->result();
    }
}
