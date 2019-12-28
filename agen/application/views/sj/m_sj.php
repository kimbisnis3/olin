
<div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"></h4>
      </div>
      <div class="modal-body">
        <div class="box-body pad">
          <form id="form-data">
            <div class="row">
              <div class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <input type="hidden" name="kode">
                      <label>Pesanan</label>
                      <div class="input-group">
                        <input type="text" class="form-control" name="ref_order" readonly="true">
                        <div class="input-group-btn">
                          <button type="button" class="btn btn-primary btn-flat" onclick="open_proc()"><i class="fa fa-table"></i></button>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Kirim Ke</label>
                      <input type="text" class="form-control" name="kirim">
                    </div>
                    <div class="form-group">
                      <label>Tanggal</label>
                      <input type="text" class="form-control datepicker" name="tgl" >
                    </div>
                    <div class="form-group">
                      <label>PIC</label>
                      <input type="text" class="form-control" name="pic">
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label>Agen</label>
                      <input type="hidden" class="form-control" name="ref_cust">
                      <input type="text" class="form-control" name="mcustomer_nama" readonly="true"/>
                    </div>
                    <div class="form-group">
                      <label>Biaya Kirim</label>
                      <input type="number" class="form-control" name="biayakirim">
                    </div>
                    <div class="form-group">
                      <label>Tanggal Kirim</label>
                      <input type="text" class="form-control datepicker" name="tglkirim">
                    </div>
                    <div class="form-group">
                      <label>Keterangan</label>
                      <input type="text" class="form-control" name="ket">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label>Alamat</label>
                      <input type="text" class="form-control" name="alamat">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-8">
                    <div class="form-group">
                      <label>No. Resi</label>
                      <input type="text" class="form-control" name="noresi">
                    </div>
                  </div>
                  <div class="col-md-2">
                      <label>Kurir</label>
                      <input type="text" class="form-control" name="kurir" readonly="true">
                  </div>
                  <div class="col-md-2">
                      <label>Kode</label>
                      <input type="text" class="form-control" name="kodekurir" readonly="true">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Batal</button>
        <button type="button" id="btnSave" onclick="savedata()" class="btn btn-primary btn-flat">Simpan</button>
      </div>
    </div>
  </div>
  </div>
  <div class="modal fade" id="modal-proc" role="dialog" data-backdrop="static">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Daftar Order</h4>
        </div>
        <div class="modal-body">
          <div class="box">
            <div class="box-header">
            </div>
            <div class="box-body pad">
              <div class="table-responsive mailbox-messages">
                <table id="table-proc" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th width="5%">No</th>
                      <th>ID</th>
                      <th>Kode</th>
                      <th>Ref Cust</th>
                      <th>Ref Biaya</th>
                      <th>Kirim Ke</th>
                      <th>Alamat</th>
                      <th>Kurir</th>
                      <th>Nama Customer</th>
                      <th>Tanggal</th>
                      <th>Status</th>
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
    </div>
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
