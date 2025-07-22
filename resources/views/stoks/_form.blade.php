<div class="card-body">
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Barang</label>
        <div class="col-sm-10">
            {{ Form::select('barang_id', $barangs->pluck('nama','id'), null, ['class'=>'form-control select2','placeholder'=>'Pilih Barang']) }}
            @if ($errors->has('barang_id')) <span class="help-block" style="color:red">{{ $errors->first('barang_id') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Tipe</label>
        <div class="col-sm-10">
            {{ Form::select('tipe', ['masuk'=>'Masuk','keluar'=>'Keluar'], null, ['class'=>'form-control']) }}
            @if ($errors->has('tipe')) <span class="help-block" style="color:red">{{ $errors->first('tipe') }}</span> @endif
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
        <a href="{{ route('stoks.index') }}" class="btn btn-danger btn-sm"><i class="fas fa-backward"></i> Kembali</a>
    </div>
</div> 