<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\KategoriModel;

class ProdukController extends BaseController
{
    protected $produkModel;
    protected $kategoriModel;

    public function __construct()
    {
        $this->produkModel = new ProductModel();
        $this->kategoriModel = new KategoriModel();
    }

    public function index()
    {
        $produk = $this->produkModel->findAll();
        return view('admin/v_produk', ['product' => $produk]);
    }

    public function create()
    {
        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'deskripsi' => 'required|min_length[10]',
            'harga' => 'required|numeric|greater_than[0]',
            'jumlah' => 'required|integer|greater_than_equal_to[0]',
            'foto' => 'permit_empty|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
        ])) {
            return redirect()->back()->withInput()->with('failed', $this->validator->listErrors());
        }

        $foto = $this->request->getFile('foto');
        $namaFoto = '';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $namaFoto = $foto->getRandomName();
            $foto->move(FCPATH . 'NiceAdmin/assets/img', $namaFoto);
        }

        $this->produkModel->save([
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'foto' => $namaFoto
        ]);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $dataLama = $this->produkModel->find($id);
        if (!$dataLama) {
            return redirect()->to(base_url('admin/produk'))->with('failed', 'Produk tidak ditemukan.');
        }

        if (!$this->validate([
            'nama' => 'required|min_length[3]',
            'deskripsi' => 'required|min_length[10]',
            'harga' => 'required|numeric|greater_than[0]',
            'jumlah' => 'required|integer|greater_than_equal_to[0]',
            'foto' => 'permit_empty|max_size[foto,2048]|is_image[foto]|mime_in[foto,image/jpg,image/jpeg,image/png,image/webp]',
        ])) {
            return redirect()->back()->withInput()->with('failed', $this->validator->listErrors());
        }

        $namaFoto = $dataLama['foto'];

        if ($this->request->getPost('check')) {
            $foto = $this->request->getFile('foto');

            if ($foto && $foto->isValid() && !$foto->hasMoved()) {
                // Hapus foto lama
                if ($namaFoto && file_exists(FCPATH . "NiceAdmin/assets/img/" . $namaFoto)) {
                    unlink(FCPATH . "NiceAdmin/assets/img/" . $namaFoto);
                }

                $namaFoto = $foto->getRandomName();
                $foto->move(FCPATH . 'NiceAdmin/assets/img', $namaFoto);
            }
        }

        $this->produkModel->update($id, [
            'nama' => $this->request->getPost('nama'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'harga' => $this->request->getPost('harga'),
            'jumlah' => $this->request->getPost('jumlah'),
            'foto' => $namaFoto
        ]);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Data berhasil diubah');
    }

    public function delete($id)
    {
        $data = $this->produkModel->find($id);

        if (!$data) {
            return redirect()->to(base_url('admin/produk'))->with('failed', 'Produk tidak ditemukan.');
        }

        if ($data && $data['foto'] && file_exists(FCPATH . 'NiceAdmin/assets/img/' . $data['foto'])) {
            unlink(FCPATH . 'NiceAdmin/assets/img/' . $data['foto']);
        }

        $this->produkModel->delete($id);
        return redirect()->to(base_url('admin/produk'))->with('success', 'Data berhasil dihapus');
    }

    public function download()
    {
        // export ke excel/pdf bisa ditambahkan di sini
        return redirect()->to(base_url('admin/produk'))->with('success', 'Fitur download belum diimplementasi');
    }
}
