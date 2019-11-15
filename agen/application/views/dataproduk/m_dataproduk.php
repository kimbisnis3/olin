<div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="box-body pad">
                    <form id="form-data">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Nama</label>
                                    <input type="hidden" name="idbarang">
                                    <input type="hidden" name="idsatbarang">
                                    <input type="text" class="form-control" name="nama">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select class="form-control select2" name="ref_ktg">
                            <option value=""></option>
                            <?php foreach ($ktg as $i => $v): ?>
                              <option value="<?php echo $v->kode?>"><?php echo $v->nama ?></option>
                            <?php endforeach ?>
                          </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" name="ket">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Bahan</label>
                                    <input type="text" class="form-control" name="bahan">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Dimensi</label>
                                    <input type="text" class="form-control" name="dimensi">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Kapasitas</label>
                                    <input type="text" class="form-control" name="kapasitas">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kode Produk</label>
                                    <input type="text" class="form-control" name="kode">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Model</label>
                                    <select class="form-control select2" name="model">
                            <option value="">-</option>
                            <?php foreach ($design as $i => $v): ?>
                            <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                            <?php endforeach ?>
                          </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Warna</label>
                                    <select class="form-control select2" name="warna">
                            <option value="">-</option>
                            <?php foreach ($warna as $i => $v): ?>
                            <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                            <?php endforeach ?>
                          </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <input type="text" class="form-control" name="ketspek">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box box-info">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Konv</label>
                                    <input type="hidden" class="form-control" name="idsatuan">
                                    <input type="number" class="form-control" name="konv">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <select class="form-control select2" name="ref_sat">
                          <option value="">-</option>
                          <?php foreach ($satuan as $i => $v): ?>
                          <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                          <?php endforeach ?>
                        </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Harga</label>
                                    <input type="number" class="form-control" name="harga">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Berat (kg)</label>
                                    <input type="number" class="form-control" name="beratkg">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Keterangan Harga</label>
                                    <input type="text" class="form-control" name="ketsatuan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Harga 1</label>
                                    <input type="number" class="form-control" name="harga1">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Minimum Order</label>
                                    <input type="number" class="form-control" name="minorder">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="pull-right">
                                <button style="margin-right: 19px!important" type="button" class="btn btn-primary btn-flat add-btn bounceIn animated" onclick="add_harga()" id="btn-tambah-harga"><i class="fa fa-plus"></i> Tambah</button>
                                <button style="margin-right: 19px!important" type="button" class="btn btn-warning btn-flat add-btn bounceIn animated" onclick="simpan_harga()" id="btn-simpan-harga"><i class="fa fa-save"></i> Simpan</button>
                                <button style="margin-right: 19px!important" type="button" class="btn btn-danger btn-flat add-btn bounceIn animated" onclick="batal_harga()" id="btn-batal-harga"><i class="fa fa-times"></i> Batal</button>
                            </div>
                        </div>
                    </div>
                    <div class="box-body pad">
                        <div class="table-responsive mailbox-messages box-table-harga">
                            <table id="table-harga" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr id="repeat">
                                        <th>Konv</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Harga 1</th>
                                        <th>Min Order</th>
                                        <th>Berat</th>
                                        <th>Keterangan</th>
                                        <th>Default</th>
                                        <th width="15%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive mailbox-messages box-table-harga-edit">
                            <table id="table-harga-edit" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr id="repeat">
                                        <th>ID</th>
                                        <th>Konv</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Harga 1</th>
                                        <th>Min Order</th>
                                        <th>Berat</th>
                                        <th>Keterangan</th>
                                        <th>Default</th>
                                        <th width="15%">Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
                <button type="button" id="btnSave" onclick="savedata()" class="btn btn-primary btn-flat">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL INPUT-->
<div class="modal fade" id="modal-komponen" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select class="form-control select2" id="select-komponen">
                              <option value=""></option>
                              <?php foreach ($komp as $i => $v): ?>
                              <option value="<?php echo $v->kode ?>"><?php echo $v->nama ?></option>
                              <?php endforeach ?>
                            </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-md btn-flat btn-block btn-hijau" id="btn-tambah-komponen" onclick="add_komponen()"><i class="fa fa-plus"></i> Tambah Komponen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body pad">
                        <div class="table-responsive mailbox-messages">
                            <table id="tbkomponen" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr id="repeat">
                                        <th width="5%">No</th>
                                        <th>ID</th>
                                        <th>Kode Barang</th>
                                        <th>ID Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Konv</th>
                                        <th>Nama Satuan</th>
                                        <th>Harga</th>
                                        <th>Ket</th>
                                        <th>Design</th>
                                        <th>Gambar Design</th>
                                        <th>Warna</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-gambar" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="box box-info">
                    <div class="box-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <button type="button" class="btn btn-md btn-flat btn-block btn-hijau" id="btn-tambah-komponen" onclick="add_image()"><i class="fa fa-plus"></i> Tambah</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-body pad">
                        <div class="table-responsive mailbox-messages">
                            <table id="tbgambar" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Gambar</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-gambar" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <form id="form-gambar">
                    <div class="form-group">
                        <label>Kode Barang</label>
                        <input type="text" class="form-control" name="kodebarang" id="kodebarang" readonly>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" class="form-control" name="image" id="image">
                        <input type="hidden" name="path" id="path">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-hijau btn-flat" onclick="saveimage()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- END MODAL KOMPONEN-->
<div id="modal-konfirmasi" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center>
                    <h4 class="modal-title"></h4>
                </center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tidak</button>
                <button type="button" id="btnHapus" class="btn btn-danger btn-flat">Ya</button>
            </div>
        </div>
    </div>
</div>