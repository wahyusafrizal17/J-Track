<div class="card-body">
    <div class="alert alert-info">
        <i data-feather="info"></i>
        <strong>Info:</strong> Ketika penjualan dibuat, stok akan otomatis berkurang. Harga jual akan otomatis terisi dengan harga barang. Pastikan stok mencukupi sebelum melakukan penjualan.
    </div>
    
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Barang</label>
        <div class="col-sm-10">
            <select name="barang_id" class="form-control select2" id="barang_id" required>
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                    @php
                        $stok = $barang->stoks->where('tipe','masuk')->sum('jumlah') - $barang->stoks->where('tipe','keluar')->sum('jumlah');
                    @endphp
                    <option value="{{ $barang->id }}" 
                            data-stok="{{ $stok }}" 
                            data-harga="{{ $barang->harga }}"
                            {{ old('barang_id', isset($penjualan) ? $penjualan->barang_id : '') == $barang->id ? 'selected' : '' }}>
                        {{ $barang->nama }} (Stok: {{ $stok }} | Harga: Rp {{ number_format($barang->harga,0,',','.') }})
                    </option>
                @endforeach
            </select>
            @if ($errors->has('barang_id')) <span class="help-block" style="color:red">{{ $errors->first('barang_id') }}</span> @endif
        </div>
    </div>
    
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Stok & Harga</label>
        <div class="col-sm-10">
            <span id="stok-info" class="form-control-plaintext">Pilih barang terlebih dahulu</span>
            <br>
            <span id="harga-info" class="form-control-plaintext text-muted"></span>
        </div>
    </div>
    
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Jumlah</label>
        <div class="col-sm-10">
            {{ Form::number('jumlah',null,['class'=>'form-control','placeholder'=>'Jumlah', 'min'=>'1']) }}
            @if ($errors->has('jumlah')) <span class="help-block" style="color:red">{{ $errors->first('jumlah') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Harga Jual</label>
        <div class="col-sm-10">
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" id="override_harga">
                <label class="form-check-label" for="override_harga">
                    Ubah harga jual manual
                </label>
            </div>
            {{ Form::number('harga_jual',null,['class'=>'form-control','placeholder'=>'Harga Jual', 'min'=>'0', 'step'=>'0.01', 'id'=>'harga_jual']) }}
            @if ($errors->has('harga_jual')) <span class="help-block" style="color:red">{{ $errors->first('harga_jual') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Total</label>
        <div class="col-sm-10">
            {{ Form::number('total',null,['class'=>'form-control','placeholder'=>'Total', 'id'=>'total', 'readonly'=>true]) }}
            @if ($errors->has('total')) <span class="help-block" style="color:red">{{ $errors->first('total') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Tanggal</label>
        <div class="col-sm-10">
            {{ Form::date('tanggal',null,['class'=>'form-control']) }}
            @if ($errors->has('tanggal')) <span class="help-block" style="color:red">{{ $errors->first('tanggal') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Pembayaran</label>
        <div class="col-sm-10">
            {{ Form::text('pembayaran',null,['class'=>'form-control','placeholder'=>'Pembayaran']) }}
            @if ($errors->has('pembayaran')) <span class="help-block" style="color:red">{{ $errors->first('pembayaran') }}</span> @endif
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('penjualans.index') }}" class="btn btn-danger btn-sm"><i class="fas fa-backward"></i> Kembali</a>
    </div>
</div>
@push('scripts')
<script>
$(function() {
    function hitungTotal() {
        var harga = parseFloat($("#harga_jual").val()) || 0;
        var jumlah = parseFloat($("input[name='jumlah']").val()) || 0;
        $("#total").val(harga * jumlah);
    }
    
    function updateStokInfo() {
        var selectedOption = $('#barang_id option:selected');
        var stok = parseFloat(selectedOption.data('stok')) || 0;
        var harga = parseFloat(selectedOption.data('harga')) || 0;
        
        if (stok > 0) {
            $('#stok-info').html('<span class="text-success">' + stok + ' unit tersedia</span>');
        } else {
            $('#stok-info').html('<span class="text-danger">Stok habis</span>');
        }
        
        if (harga > 0) {
            $('#harga-info').html('Harga: Rp ' + harga.toLocaleString('id-ID'));
        } else {
            $('#harga-info').html('');
        }
    }
    
    function updateHargaJual() {
        var selectedOption = $('#barang_id option:selected');
        var harga = parseFloat(selectedOption.data('harga')) || 0;
        var overrideChecked = $('#override_harga').is(':checked');
        
        if (harga > 0 && !overrideChecked) {
            $("#harga_jual").val(harga);
            hitungTotal();
        } else if (harga <= 0) {
            $("#harga_jual").val('');
            $("#total").val('');
        }
    }
    
    function cekStok() {
        var jumlah = parseFloat($("input[name='jumlah']").val()) || 0;
        var stok = parseFloat($('#barang_id option:selected').data('stok')) || 0;
        
        if (jumlah > stok && stok > 0) {
            alert('Jumlah penjualan melebihi stok tersedia! Stok tersedia: ' + stok);
            $("input[name='jumlah']").val(stok);
            hitungTotal();
        } else if (stok <= 0) {
            alert('Stok barang ini habis!');
            $("input[name='jumlah']").val(0);
            hitungTotal();
        }
    }
    
    // Event listeners
    $("input[name='jumlah'], #harga_jual").on('input', hitungTotal);
    
    $('#barang_id').on('change', function() {
        updateStokInfo();
        updateHargaJual();
        cekStok();
    });
    
    $('#override_harga').on('change', function() {
        if ($(this).is(':checked')) {
            // Allow manual editing
            $("#harga_jual").prop('readonly', false);
        } else {
            // Auto-fill with product price
            updateHargaJual();
            $("#harga_jual").prop('readonly', false);
        }
    });
    
    $("input[name='jumlah']").on('input', cekStok);
    
    // Initialize
    updateStokInfo();
    updateHargaJual();
    hitungTotal();
});
</script>
@endpush 