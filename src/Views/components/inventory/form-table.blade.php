@php
    $opsiStatusBarang = [
        1 => 'Tersedia',
        0 => 'Tidak Tersedia'
    ];

    $opsiSatuanBarang = [
        'kg' => 'kg',
        'pcs' => 'pcs',
        'liter' => 'liter',
        'meter' => 'meter'
    ];
@endphp

<tr>
    <form action="/inventory{{ !empty($data) ? '/edit?id=' . $data['id'] : '/create' }}" method="POST">
        <td style="text-align: center;">{{ $data['nomor'] ?? ''}}</td>
        <td>
            <input value="{{ $data['kode_barang'] ?? ''}}" type="text" name="kode_barang" class="form-control" required>
        </td>
        <td>
            <input value="{{ $data['nama_barang'] ?? ''}}" type="text" name="nama_barang" class="form-control" required>
        </td>
        <td>
            <input value="{{ $data['jumlah_barang'] ?? ''}}" type="number" name="jumlah_barang" class="form-control" required>
        </td>
        <td>
            <select name="satuan_barang" class="form-control" required>
                @foreach ($opsiSatuanBarang as $value => $label)
                    <option {{ $value == ($data['satuan_barang'] ?? '') ? 'selected' : '' }} value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input value="{{ $data['harga_beli'] ?? ''}}" type="number" name="harga_beli" class="form-control" required>
        </td>
        <td>
            <select name="status_barang" class="form-control" required>
                @foreach ($opsiStatusBarang as $value => $label)
                    <option {{ $value == ($data['status_barang'] ?? '') ? 'selected' : '' }} value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                <a href="/inventory" class="btn btn-light">
                    <i class="fas fa-x"></i>
                </a>
            </div>
        </td>
    </form>
</tr>
