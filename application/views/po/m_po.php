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
            <div class="col-md-7">
              <div class="box-body pad">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Agen</label>
                      <input type="hidden" name="kode">
                      <div class="input-group">
                        <input type="hidden" class="form-control" name="ref_cust">
                        <input type="text" class="form-control" name="namacust" readonly="true">
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-flat" onclick="open_cust()"><i class="fa fa-table"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Tanggal</label>
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
                          <input type="hidden" name="pathcorel" id="path">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label>Gambar</label>
                          <input type="file" class="form-control" name="image" id="image">
                          <input type="hidden" name="pathimg" id="path">
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
                </div>
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
                  <div class="col-md-8">
                    <div class="form-group">
                      <label>Alamat Lengkap</label>
                      <input type="text" class="form-control" name="alamat">
                    </div>
                  </div>
                </div>
              </div>
              <div class="box-body pad invisible fadeIn animated" id="box-kurir">
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
                        <input type="text" class="form-control" name="biaya" readonly="true">
                      </div>
                      <div class="col-md-3">
                        <label>Kode Kurir</label>
                        <input type="text" class="form-control" name="kodekurir" readonly="true">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-5">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Produk</label>
                    <input type="hidden" name="id">
                    <input type="hidden" name="arr_produk">
                    <div class="input-group">
                      <input type="hidden" class="form-control" name="kodebrg">
                      <input type="text" class="form-control" name="namabarang" readonly="true">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-primary btn-flat" onclick="open_barang()"><i class="fa fa-table"></i></button>
                      </div>
                    </div>
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
                  </div>
                </div>
                <div class="col-md-4">
                  <label style="visibility: hidden;">xxxx</label>
                  <button type="button" class="btn btn-flat btn-block btn-hijau bounceIn animated" id="btn-tambah-barang" onclick="add_barang()"><i class="fa fa-plus"></i> Tambah</button>
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
                          <th>Harga</th>
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
  <div class="modal fade" id="modal-customer" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Daftar Agen</h4>
        </div>
        <div class="modal-body">
          <div class="box">
            <div class="box-header">
            </div>
            <div class="box-body pad">
              <div class="table-responsive mailbox-messages">
                <table id="table-customer" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>ID</th>
                      <th>Nama</th>
                      <th>Alamat</th>
                      <th>Telp</th>
                      <th>Email</th>
                      <th>Pic</th>
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
    </div>  <!-- END MODAL cust-->
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
                  <table id="table-barang" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th width="5%">No</th>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Konv</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Berat</th>
                        <th>Keterangan</th>
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
                    <table id="table-file" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                          <th width="5%">No</th>
                          <th>ID</th>
                          <th>Kode</th>
                          <th>File Corel</th>
                          <th>File Image</th>
                          <th>xxx</th>
                          <th>xxx</th>
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
