<div class="card-body">
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Barang</label>
        <div class="col-sm-10">
            <select name="barang_id" class="form-control select2" id="barang_id" required>
                <option value="">Pilih Barang</option>
                @foreach($barangs as $barang)
                    @php
                        $stok = $barang->stoks->where('tipe','masuk')->sum('jumlah') - $barang->stoks->where('tipe','keluar')->sum('jumlah');
                    @endphp
                    <option value="{{ $barang->id }}" data-stok="{{ $stok }}" {{ old('barang_id', isset($penjualan) ? $penjualan->barang_id : '') == $barang->id ? 'selected' : '' }}>{{ $barang->nama }}</option>
                @endforeach
            </select>
            @if ($errors->has('barang_id')) <span class="help-block" style="color:red">{{ $errors->first('barang_id') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Jumlah</label>
        <div class="col-sm-10">
            {{ Form::number('jumlah',null,['class'=>'form-control','placeholder'=>'Jumlah']) }}
            @if ($errors->has('jumlah')) <span class="help-block" style="color:red">{{ $errors->first('jumlah') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Harga Jual</label>
        <div class="col-sm-10">
            {{ Form::number('harga_jual',null,['class'=>'form-control','placeholder'=>'Harga Jual']) }}
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
        <label class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            {{ Form::text('keterangan',null,['class'=>'form-control','placeholder'=>'Keterangan']) }}
            @if ($errors->has('keterangan')) <span class="help-block" style="color:red">{{ $errors->first('keterangan') }}</span> @endif
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
        var harga = parseFloat($("input[name='harga_jual']").val()) || 0;
        var jumlah = parseFloat($("input[name='jumlah']").val()) || 0;
        $("#total").val(harga * jumlah);
    }
    $("input[name='harga_jual'], input[name='jumlah']").on('input', hitungTotal);
    hitungTotal();

    function cekStok() {
        var jumlah = parseFloat($("input[name='jumlah']").val()) || 0;
        var stok = parseFloat($('#barang_id option:selected').data('stok')) || 0;
        if(jumlah > stok) {
            alert('Jumlah penjualan melebihi stok tersedia!');
            $("input[name='jumlah']").val(stok);
            hitungTotal();
        }
    }
    $("input[name='jumlah']").on('input', cekStok);
    $('#barang_id').on('change', cekStok);
});
</script>
@endpush 