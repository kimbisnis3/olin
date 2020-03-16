<div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
  <div class="modal-dialog modal-lg" style="width: 90vw">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <form id="form-data">
          <div class="row">
          <div class="col-md-5">
              <div class="row">
                <div class="col-md-12">
                  <table id="table-barang" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Produk</label>
                    <input type="hidden" name="id">
                    <input type="hidden" name="arr_produk">
                    <input type="hidden" class="form-control" name="kodebrg">
                    <input type="text" class="form-control" name="namabarang" readonly="true">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Harga</label>
                    <input type="text" class="form-control" name="harga" readonly="true">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Jumlah</label>
                    <input type="number" class="form-control" name="jumlah" id="jumlah">
                    <input type="hidden" class="form-control" name="beratkg" id="beratkg">
                    <input type="hidden" class="form-control" name="total" id="input-total-harga">
                    <input type="hidden" class="form-control" name="xorderd_id" id="xorderd_id">
                    <input type="hidden" class="form-control" name="kodepesanan" id="kodepesanan">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="row">
                    <div class="col-md-6">
                      <label style="visibility: hidden;">xxxx</label>
                      <button type="button" class="btn btn-flat btn-hijau" id="btn-tambah-barang" onclick="add_barang()"><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <div class="col-md-6">
                      <label style="visibility: hidden;">xxxx</label>
                      <button type="button" class="btn btn-flat btn-biru" onclick="loadpesanan()"><i class="fa fa-circle-o"></i> Muat Pesananan</button>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      <button type="button" class="btn btn-flat btn-block btn-oren bounceIn animated" id="btn-simpan-barang" onclick="update_barang()"><i class="fa fa-save"></i></button>
                    </div>
                    <div class="col-md-6">
                      <button type="button" class="btn btn-flat btn-block btn-merah bounceIn animated" id="btn-batal-barang" onclick="batal_barang()"><i class="fa fa-times"></i></button>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <div class="table-responsive mailbox-messages">
                    <table id="table-add-barang" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>ID</th>
                          <th>Produk</th>
                          <th>Jumlah</th>
                          <th>Berat p/item (kg)</th>
                          <th>Harga</th>
                          <th>Xorder_id</th>
                          <th>Opsi</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                      <tfoot>
                        <tr>
                          <th></th>
                          <th></th>
                          <th></th>
                          <th>Total</th>
                          <th colspan="2" id="total-harga"></th>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="box-body pad">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Tanggal</label>
                      <input type="hidden" name="kode">
                      <input type="text" class="form-control datepicker" name="tgl">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Keterangan</label>
                      <input type="text" class="form-control" name="ket">
                    </div>
                  </div>
                  <div class="col-md-8">
                    <div class="row box-upload">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>File Corel * </label>
                          <input type="file" class="form-control" name="corel" id="corel">
                          <input type="hidden" name="pathcorel">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Gambar</label>
                          <input type="file" class="form-control" name="image" id="image">
                          <input type="hidden" name="pathimg">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Penerima</label>
                      <input type="text" class="form-control" name="kirimke">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Layanan</label>
                      <select class="form-control select2" name="ref_layanan">
                        <option value="">-</option>
                        <?php foreach ($mlayanan as $i => $v): ?>
                        <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Pengiriman</label>
                      <select class="form-control select2" name="ref_kirim" onchange="changekirim()" id="ref_kirim">
                        <option value="">-</option>
                        <?php foreach ($mkirim as $i => $v): ?>
                        <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                    <label>No Hp</label>
                    <input type="text" class="form-control" name="telp">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Bank</label>
                      <select class="form-control select2" name="ref_bank" id="ref_bank">
                        <option value="">-</option>
                        <?php foreach ($mbank as $i => $v): ?>
                        <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?> - (<?php echo $v->norek; ?>)</option>
                        <?php endforeach ?>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-body pad invisible fadeIn animated" id="box-kurir">
                <div class="row">
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>Nama Pengirim</label>
                      <input type="text" class="form-control" name="namakirim">
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="form-group">
                      <label>No. Hp Pengirim</label>
                      <input type="text" class="form-control" name="hpkirim">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Alamat Lengkap</label>
                      <input type="text" class="form-control" name="alamat">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Provinsi Asal</label>
                          <select class="form-control select2" id="select-provinsi" name="provinsi" onchange="setCity()">
                            <option value="">- Pilih Data -</option>
                          </select>
                          <input type="hidden" name="mask-provinsi">
                        </div>
                        <div class="form-group">
                          <label>Kota Asal</label>
                          <select class="form-control select2" id="select-city" name="city">
                            <option value="">- Pilih Data -</option>
                          </select>
                          <input type="hidden" name="mask-city">
                        </div>
                        <div class="form-group">
                          <label>Kecamatan Asal</label>
                          <select class="form-control select2" id="select-dist" name="dist">
                            <option value="">- Pilih Data -</option>
                          </select>
                          <input type="hidden" name="mask-dist">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Provinsi Tujuan</label>
                          <select class="form-control select2" id="select-provinsi-to" name="provinsito" onchange="setCityTo()">
                            <option value="">- Pilih Data -</option>
                          </select>
                          <input type="hidden" name="mask-provinsito">
                        </div>
                        <div class="form-group">
                          <label>Kota Tujuan</label>
                          <select class="form-control select2" id="select-city-to" name="cityto" onchange="setDistTo()">
                            <option value="">- Pilih Data -</option>
                          </select>
                          <input type="hidden" name="mask-cityto">
                        </div>
                        <div class="form-group">
                          <label>Kecamatan Tujuan</label>
                          <select class="form-control select2" id="select-dist-to" name="distto">
                            <option value="">- Pilih Data -</option>
                          </select>
                          <input type="hidden" name="mask-distto">
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <label>Berat (kg)</label>
                          <input type="number" class="form-control" name="berat" onkeyup="setService()" id="berat" readonly>
                        </div>
                        <div class="form-group">
                          <label>Kurir</label>
                          <select class="form-control select2" id="select-kurir" name="kurir" onchange="setService()">
                            <option value="">- Pilih Data -</option>
                            <option value="jne">JNE</option>
                            <option value="tiki">TIKI</option>
                            <option value="pos">POS</option>
                            <option value="jnt">J&T</option>
                            <option value="sicepat">SICEPAT</option>
                          </select>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Service</label>
                          <select class="form-control select2" id="select-service" name="serv" onchange="setPrice()">
                            <option value="">- Pilih Data -</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <label>Biaya</label>
                        <input type="text" class="form-control" name="biaya" id="biayakirim" readonly="true">
                      </div>
                      <div class="col-md-3">
                        <label>Kode Kurir</label>
                        <input type="text" class="form-control" name="kodekurir" id="kodekurirkirim" readonly="true">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" id="btnSimpan" onclick="savedata()" class="btn btn-primary btn-flat btn-save">Simpan</button>
      </div>
    </div>
  </div>
  </div>  <!-- END MODAL INPUT-->
  <div class="modal fade" id="modal-location" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th>Lokasi Tujuan</th>
                <th>Berat</th>
                <th>Kurir</th>
                <th>Service</th>
                <th>Biaya Kirim</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><span id="loc-location"></span></td>
                <td><span id="loc-berat"></span></td>
                <td><span id="loc-kurir"></span></td>
                <td><span id="loc-service"></span></td>
                <td><span id="loc-bykirim"></span></td>
              </tr>
            </tbody>
          </table>
          <div class="modal-body">
            <button type="button" class="btn btn-warning" onclick="open_box_location()">Ubah Lokasi Pengiriman</button>
          </div>
        </div>
        <div class="modal-body" id="box-location">
          <form id="form-location">
            <div class="row">
              <div class="col-md-12">
                <div class="box-body pad">
                  <div class="row">
                    <input type="hidden" name="kode">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Provinsi Tujuan</label>
                            <select class="form-control select2" name="provinsito" id="select-provinsi-edit" onchange="setCityTo()">
                              <option value="">- Pilih Data -</option>
                            </select>
                            <input type="hidden" name="mask-provinsito">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Kota Tujuan</label>
                            <select class="form-control select2" name="cityto" onchange="setDistTo()">
                              <option value="">- Pilih Data -</option>
                            </select>
                            <input type="hidden" name="mask-cityto">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Kecamatan Tujuan</label>
                            <select class="form-control select2" name="distto">
                              <option value="">- Pilih Data -</option>
                            </select>
                            <input type="hidden" name="mask-distto">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Berat (kg)</label>
                            <input type="number" class="form-control" name="berat" readonly>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label>Kurir</label>
                            <select class="form-control select2" name="kurir" onchange="setService()">
                              <option value="">- Pilih Data -</option>
                              <option value="jne">JNE</option>
                              <option value="tiki">TIKI</option>
                              <option value="pos">POS</option>
                              <option value="jnt">J&T</option>
                              <option value="sicepat">SICEPAT</option>
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Service</label>
                            <select class="form-control select2" name="serv" onchange="setPrice()">
                              <option value="">- Pilih Data -</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <label>Biaya</label>
                          <input type="text" class="form-control" name="biayax" readonly="true">
                        </div>
                        <div class="col-md-3">
                          <label>Kode Kurir</label>
                          <input type="text" class="form-control" name="kodekurirx" readonly="true">
                        </div>
                      </div>
                      <div class="row pull-right">
                        <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
                        <button type="button" id="btnSimpan" onclick="savelocation()" class="btn btn-primary btn-flat btn-save">Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>  <!-- END MODAL LOCATION-->
    <div class="modal fade" id="modal-barang" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Daftar Produk</h4>
        </div>
        <div class="modal-body">
          <div class="box">
            <div class="box-header">
            </div>
            <div class="box-body pad">
              <div class="table-responsive mailbox-messages">
                <table id="table-barang" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
    </div>  <!-- END MODAL SPEK-->
    <div class="modal fade" id="modal-file" role="dialog" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Data File</h4>
        </div>
        <div class="modal-body">
          <div class="box">
            <div class="box-header">
            </div>
            <div class="box-body pad">
              <div class="table-responsive mailbox-messages">
                <table id="table-file" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
    </div>  <!-- END MODAL SPEK-->
  <div class="modal fade" id="modal-input-file" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="box-body pad">
          <form id="form-file">
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>File Corel * </label>
                  <input type="hidden" name="editkodefile">
                  <input type="file" class="form-control" name="editcorel" id="editcorel">
                  <input type="hidden" name="editpathcorel">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Gambar</label>
                  <input type="file" class="form-control" name="editimage" id="editimage">
                  <input type="hidden" name="editpathimage">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" id="btnSave" onclick="updatefile()" class="btn btn-primary btn-flat">Simpan</button>
      </div>
    </div>
  </div>
  </div>  <!-- END MODAL INPUT-->
  <div class="modal fade" id="modal-pesanan" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Data Pesanan</h4>
        </div>
        <div class="modal-body">
          <div class="box">
            <div class="box-header">
            </div>
            <div class="box-body pad">
              <div class="table-responsive mailbox-messages">
                <table id="table-pesanan" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>  <!-- END MODAL SPEK-->
  <div id="modal-konfirmasi" class="modal fade" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-body">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <center><h4 class="modal-title"></h4></center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tidak</button>
          <button type="button" id="btnHapus" class="btn btn-danger btn-flat">Ya</button>
        </div>
      </div>
    </div>
  </div>
