<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $product;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        $this->product = new ProductModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $productId = (int) $this->request->getPost('id');
        $product = $this->product->find($productId);

        if (!$product) {
            return redirect()->back()->with('failed', 'Produk tidak ditemukan.');
        }

        if ((int) $product['jumlah'] <= 0) {
            return redirect()->back()->with('failed', 'Stok produk sedang habis.');
        }

        foreach ($this->cart->contents() as $item) {
            if ((int) $item['id'] === $productId) {
                if ($item['qty'] >= (int) $product['jumlah']) {
                    return redirect()->back()->with('failed', 'Jumlah produk di keranjang sudah mencapai stok tersedia.');
                }

                $this->cart->update([
                    'rowid' => $item['rowid'],
                    'qty' => $item['qty'] + 1,
                ]);

                return redirect()->back()->with('success', 'Jumlah produk di keranjang diperbarui. <a href="' . base_url('keranjang') . '">Lihat keranjang</a>');
            }
        }

        $this->cart->insert([
            'id' => $product['id'],
            'qty' => 1,
            'price' => $product['harga'],
            'name' => $product['nama'],
            'options' => [
                'foto' => $product['foto'],
                'stok' => $product['jumlah'],
            ],
        ]);

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang. <a href="' . base_url('keranjang') . '">Lihat keranjang</a>');
    }

    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $qty = (int) $this->request->getPost('qty' . $i++);
            $product = $this->product->find($value['id']);

            if (!$product) {
                $this->cart->remove($value['rowid']);
                continue;
            }

            if ($qty < 1) {
                $qty = 1;
            }

            if ($qty > (int) $product['jumlah']) {
                return redirect()->back()->with('failed', 'Jumlah "' . esc($product['nama']) . '" melebihi stok tersedia.');
            }

            $this->cart->update([
                'rowid' => $value['rowid'],
                'qty' => $qty,
            ]);
        }

        session()->setflashdata('success', 'Keranjang berhasil diperbarui.');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }
    public function checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        if (empty($data['items'])) {
            return redirect()->to(base_url('keranjang'))->with('failed', 'Keranjang masih kosong.');
        }

        return view('v_checkout', $data);
    }
    public function getLocation()
    {
        //keyword pencarian yang dikirimkan dari halaman checkout
        $search = $this->request->getGet('search');

        if (!$search || strlen($search) < 3) {
            return $this->response->setJSON([]);
        }

        try {
            $response = $this->client->request(
                'GET',
                'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search=' . urlencode($search) . '&limit=50',
                [
                    'headers' => [
                        'accept' => 'application/json',
                        'key' => $this->apiKey,
                    ],
                    'timeout' => 10,
                ]
            );
        } catch (\Throwable $e) {
            log_message('error', 'RajaOngkir location error: ' . $e->getMessage());
            return $this->response->setStatusCode(502)->setJSON([]);
        }

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data'] ?? []);
    }

    public function getCost()
    {
        //ID lokasi yang dikirimkan dari halaman checkout
        $destination = $this->request->getGet('destination');

        if (!$destination) {
            return $this->response->setJSON([]);
        }

        //parameter daerah asal pengiriman, berat produk, dan kurir dibuat statis
        //valuenya => 64999 : PEDURUNGAN TENGAH , 1000 gram, dan JNE
        try {
            $response = $this->client->request(
                'POST',
                'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost',
                [
                    'multipart' => [
                        [
                            'name' => 'origin',
                            'contents' => '64999'
                        ],
                        [
                            'name' => 'destination',
                            'contents' => $destination
                        ],
                        [
                            'name' => 'weight',
                            'contents' => '1000'
                        ],
                        [
                            'name' => 'courier',
                            'contents' => 'jne'
                        ]
                    ],
                    'headers' => [
                        'accept' => 'application/json',
                        'key' => $this->apiKey,
                    ],
                    'timeout' => 10,
                ]
            );
        } catch (\Throwable $e) {
            log_message('error', 'RajaOngkir cost error: ' . $e->getMessage());
            return $this->response->setStatusCode(502)->setJSON([]);
        }

        $body = json_decode($response->getBody(), true);
        return $this->response->setJSON($body['data'] ?? []);
    }

    public function buy()
    {
        if (!$this->request->getPost()) {
            return redirect()->back()->with('failed', 'Data tidak valid.');
        }

        $items = $this->cart->contents();
        if (empty($items)) {
            return redirect()->to(base_url('keranjang'))->with('failed', 'Keranjang masih kosong.');
        }

        foreach ($items as $item) {
            $product = $this->product->find($item['id']);

            if (!$product) {
                return redirect()->to(base_url('keranjang'))->with('failed', 'Ada produk yang sudah tidak tersedia.');
            }

            if ($item['qty'] > (int) $product['jumlah']) {
                return redirect()->to(base_url('keranjang'))->with('failed', 'Stok "' . esc($product['nama']) . '" tidak mencukupi untuk checkout.');
            }
        }

        $rules = [
            'alamat' => 'required',
            'kelurahan' => 'required',
            'nama_kelurahan' => 'required',
            'layanan' => 'required',
            'ongkir' => 'required|numeric',
            'bukti_pembayaran' => 'uploaded[bukti_pembayaran]|max_size[bukti_pembayaran,2048]|ext_in[bukti_pembayaran,jpg,jpeg,png,pdf]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('failed', $this->validator->listErrors());
        }

        $file = $this->request->getFile('bukti_pembayaran');
        $buktiPath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $targetPath = FCPATH . 'uploads/bukti';

            if (!$file->move($targetPath, $namaFile)) {
                return redirect()->back()->withInput()->with('failed', 'Gagal mengunggah bukti pembayaran.');
            }

            $buktiPath = 'uploads/bukti/' . $namaFile;
        }

        $now = date('Y-m-d H:i:s');
        $ongkir = (float) $this->request->getPost('ongkir');
        $totalHarga = $this->cart->total() + $ongkir;

        $dataForm = [
            'username' => session()->get('username'),
            'total_harga' => $totalHarga,
            'alamat' => $this->request->getPost('alamat'),
            'kelurahan' => $this->request->getPost('kelurahan'),
            'kelurahan_nama' => $this->request->getPost('nama_kelurahan'),
            'layanan' => $this->request->getPost('layanan'),
            'ongkir' => $ongkir,
            'status' => 0,
            'status_kirim' => 'diproses',
            'status_bayar' => 'menunggu konfirmasi',
            'bukti_pembayaran' => $buktiPath,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        if (!$this->transaction->insert($dataForm)) {
            log_message('error', 'Insert transaksi gagal: ' . json_encode($this->transaction->errors()));
            return redirect()->back()->withInput()->with('failed', 'Gagal membuat pesanan. Silakan coba lagi.');
        }

        $lastId = $this->transaction->getInsertID();

        foreach ($items as $item) {
            $this->transaction_detail->insert([
                'transaction_id' => $lastId,
                'product_id' => $item['id'],
                'jumlah' => $item['qty'],
                'diskon' => 0,
                'subtotal_harga' => $item['qty'] * $item['price'],
                'created_at' => $now,
                'updated_at' => $now,
            ]);

            $product = $this->product->find($item['id']);
            if ($product) {
                $this->product->update($item['id'], [
                    'jumlah' => max(0, (int) $product['jumlah'] - (int) $item['qty']),
                    'updated_at' => $now,
                ]);
            }
        }

        $this->cart->destroy();

        return redirect()->to(base_url('invoice/' . $lastId))->with('success', 'Pesanan berhasil dibuat.');
    }


    public function invoice($id)
    {
        $transaction = $this->transaction->find($id);

        if (!$transaction) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Invoice tidak ditemukan.');
        }

        if (!$this->canAccessTransaction($transaction)) {
            return redirect()->to(base_url('profile'))->with('failed', 'Anda tidak memiliki akses ke invoice ini.');
        }

        $details = $this->transaction_detail
            ->select('transaction_detail.*, product.nama, product.harga, product.foto, product.deskripsi') // ← tambahkan deskripsi
            ->join('product', 'product.id = transaction_detail.product_id')
            ->where('transaction_id', $id)
            ->findAll();


        return view('v_invoice', [
            'transaction' => $transaction,
            'details' => $details
        ]);
    }



    public function invoiceRedirect()
    {
        $id = $this->request->getGet('id');
        if ($id && is_numeric($id)) {
            return redirect()->to(base_url('invoice/' . $id));
        }
        return redirect()->back()->with('failed', 'ID Transaksi tidak valid.');
    }

    public function uploadBuktiPembayaran($id)
    {
        $transaction = $this->transaction->find($id);
        if (!$transaction) {
            return redirect()->back()->with('failed', 'Transaksi tidak ditemukan');
        }

        if (!$this->canAccessTransaction($transaction)) {
            return redirect()->to(base_url('profile'))->with('failed', 'Anda tidak memiliki akses ke transaksi ini.');
        }

        $file = $this->request->getFile('bukti_pembayaran');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move(FCPATH . 'uploads/bukti', $namaFile);

            $this->transaction->update($id, [
                'bukti_pembayaran' => 'uploads/bukti/' . $namaFile,
                'status_bayar' => 'menunggu konfirmasi'
            ]);

            return redirect()->to(base_url('invoice/' . $id))->with('success', 'Bukti pembayaran sudah terupload.');
        }

        return redirect()->back()->with('failed', 'Gagal mengunggah file.');
    }

    private function canAccessTransaction(array $transaction): bool
    {
        return session()->get('role') === 'admin' || $transaction['username'] === session()->get('username');
    }
}
