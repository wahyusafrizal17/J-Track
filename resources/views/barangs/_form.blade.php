<div class="card-body">
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Kode</label>
        <div class="col-sm-10">
            {{ Form::text('kode',null,['class'=>'form-control','placeholder'=>'Kode']) }}
            @if ($errors->has('kode')) <span class="help-block" style="color:red">{{ $errors->first('kode') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            {{ Form::text('nama',null,['class'=>'form-control','placeholder'=>'Nama']) }}
            @if ($errors->has('nama')) <span class="help-block" style="color:red">{{ $errors->first('nama') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Deskripsi</label>
        <div class="col-sm-10">
            {{ Form::textarea('deskripsi',null,['class'=>'form-control','placeholder'=>'Deskripsi']) }}
            @if ($errors->has('deskripsi')) <span class="help-block" style="color:red">{{ $errors->first('deskripsi') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Harga</label>
        <div class="col-sm-10">
            {{ Form::number('harga',null,['class'=>'form-control','placeholder'=>'Harga']) }}
            @if ($errors->has('harga')) <span class="help-block" style="color:red">{{ $errors->first('harga') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Satuan</label>
        <div class="col-sm-10">
            {{ Form::text('satuan',null,['class'=>'form-control','placeholder'=>'Satuan']) }}
            @if ($errors->has('satuan')) <span class="help-block" style="color:red">{{ $errors->first('satuan') }}</span> @endif
        </div>
    </div>
    <div class="form-group row mt-2">
        <label class="col-sm-2 col-form-label">Stok Minimal</label>
        <div class="col-sm-10">
            {{ Form::number('stok_minimal',null,['class'=>'form-control','placeholder'=>'Stok Minimal']) }}
            @if ($errors->has('stok_minimal')) <span class="help-block" style="color:red">{{ $errors->first('stok_minimal') }}</span> @endif
        </div>
    </div>
</div>
<div class="card-footer">
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('barangs.index') }}" class="btn btn-danger btn-sm"><i class="fas fa-backward"></i> Kembali</a>
    </div>
</div> 