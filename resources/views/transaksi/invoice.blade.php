<div class="invoice-pos">
    <div class="header">
        <div class="title" style="font-weight: bold; font-size: 16px;">SDIT ARRAHMAH LUMAJANG</div>
        <div class="subtitle" style="font-size: 12px;">Jl. RA Kartini No.08, Pandanwangi, Tukum, Kec. Tekung, Kabupaten Lumajang, Jawa Timur 67381</div>
        <div class="subtitle" style="font-size: 12px;">Telp: 08123456789</div>
    </div>

    <div class="divider"></div>

    <div class="transaction-info">
        <div>
            <span class="label" style="font-weight: bold;">No. Transaksi:</span>
            <span>TRX-{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div>
            <span class="label" style="font-weight: bold;">Tanggal:</span>
            <span>{{ $transaksi->created_at->format('d/m/Y H:i') }}</span>
        </div>
        <div>
            <span class="label" style="font-weight: bold;">Nama:</span>
            <span>{{ $transaksi->tabungan->user->name }}</span>
        </div>
        <div>
            <span class="label" style="font-weight: bold;">No. Anggota:</span>
            <span>{{ $transaksi->tabungan->user->id }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <div class="transaction-details">
        <div style="text-align: center; font-weight: bold; margin-bottom: 5px; font-size: 14px;">
            {{ strtoupper($transaksi->jenis) }}
        </div>
        <div
            style="display: flex; justify-content: space-between; font-size: 16px; font-weight: bold; margin-bottom: 10px;">
            <span>JUMLAH:</span>
            <span>Rp {{ number_format($transaksi->jumlah, 0, ',', '.') }}</span>
        </div>
    </div>

    <div class="divider"></div>

    <div class="transaction-info">
        <div>
            <span class="label" style="font-weight: bold;">Status:</span>
            <span style="text-transform: uppercase;">{{ $transaksi->status }}</span>
        </div>
        @if ($transaksi->keterangan)
            <div>
                <span class="label" style="font-weight: bold;">Keterangan:</span>
                <span>{{ $transaksi->keterangan }}</span>
            </div>
        @endif
    </div>

    <div class="footer"
        style="text-align: center; margin-top: 10px; font-size: 10px; border-top: 1px dashed #000; padding-top: 5px;">
        Terima kasih telah bertransaksi<br>
        {{ date('d/m/Y H:i') }}
    </div>
</div>
