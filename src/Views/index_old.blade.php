@component('components.app')
<div class="window" style="width: 100rem; margin: 30px auto;">
    <div class="title-bar">
        <button aria-label="Close" class="close"></button>
        <h1 class="title">Sistem Inventory</h1>
        <button aria-label="Resize" disabled class="hidden"></button>
    </div>
    <div class="separator"></div>

    <div class="modeless-dialog">
        <a href="/create" class="btn">+ Tambah Barang</a>
        <table>
            <thead>
                <tr>
                    <th>
                        Nomor
                    </th>
                    <th>
                        Kode Barang
                    </th>
                    <th>
                        Nama Barang
                    </th>
                    <th>
                        Stok Barang
                    </th>
                    <th>
                        Satuan Barang
                    </th>
                    <th>
                        Harga Beli
                    </th>
                    <th>
                        Status Barang
                    </th>
                    <th>
                        Aksi
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($state == 'create')
                    @component('components.inventory.form-table')
                    @endcomponent
                @endif
                @foreach ($data as $key => $item)
                    @if ($state == 'edit' && $edit == $item['id'])
                        @component('components.inventory.form-table', [
                            'data' => [
                                'nomor' => $key + 1,
                                ...$item
                            ]
                        ])
                        @endcomponent
                    @else
                        <tr>
                            <td style="width: 5px; text-align: center;">{{ $key + 1 }}</td>
                            <td>{{ $item['kode_barang'] }}</td>
                            <td>{{ $item['nama_barang'] }}</td>
                            <td style="text-align: right;">{{ $item['jumlah_barang'] }}</td>
                            <td>{{ $item['satuan_barang'] }}</td>
                            <td style="text-align: right;">Rp
                                {{ number_format(num: $item['harga_beli'], thousands_separator: '.') }}</td>
                            <td>
                                @if ($item['status_barang'])
                                    Tersedia
                                @else
                                    Tidak tersedia
                                @endif
                            </td>

                            <td>
                                <form id="delete-{{ $item['id'] }}"
                                    onsubmit="return confirm('Apakah anda yakin akan menghapus?');" hidden method="post"
                                    action="/destroy?id={{ $item['id'] }}"></form>
                                <div style="display: flex; gap: 12px; justify-content: center;">
                                    <button class="btn" onclick="document.getElementById('delete-{{ $item['id'] }}').submit()">
                                        Hapus
                                    </button>
                                    <button class="btn" onclick="location.href = '/edit?id={{ $item['id'] }}'">
                                        Edit
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endcomponent