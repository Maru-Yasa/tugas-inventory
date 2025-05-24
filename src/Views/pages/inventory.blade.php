@extends('components.app')
@section('main')

<h1 class="mt-4">Inventory</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Inventory</li>
</ol>

<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#form-modal-inventory">
    <i class="fas fa-plus"></i>
    Tambah Barang
</button>

<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-table me-1"></i>
        Data Inventory
    </div>
    <div class="card-body">
        <table id="datatablesSimple">
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
                                    action="/inventory/destroy?id={{ $item['id'] }}"></form>
                                <div style="display: flex; gap: 12px; justify-content: center;">
                                    <button data-item="{{ json_encode($item) }}" class="btn btn-light" onclick="toggleModal(this, 'inventory', 'edit', '#form-modal-inventory')">
                                        <i class="fas fa-pencil"></i>
                                    </button>
                                    <button data-item="{{ json_encode($item) }}" class="btn btn-danger" onclick="toggleModal(this, 'inventory', 'destroy', '#delete-modal-inventory')">
                                        <i class="fas fa-trash-alt"></i>
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

@component('components.inventory.form-modal')
@endcomponent
@component('components.inventory.delete-modal')
@endcomponent

@endsection