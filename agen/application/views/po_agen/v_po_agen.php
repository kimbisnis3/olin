<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app">
      <?php $this->load->view('_partials/topbar'); ?>
      <?php $this->load->view('_partials/sidebar'); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1 class="title"></h1>
          <ol class="breadcrumb">
            <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active title"></li>
          </ol>
        </section>
          <div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                  <form id="form-data">
                    <div class="box-body pad">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Produk</label>
                            <input type="hidden" name="id">
                            <div class="input-group">
                              <input type="hidden" class="form-control" name="kodebrg">
                              <input type="text" class="form-control" name="namabarang" readonly="true">
                              <div class="input-group-btn">
                                <button type="button" class="btn btn-primary btn-flat" onclick="open_barang()"><i class="fa fa-table"></i></button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Tanggal</label>
                            <input type="text" class="form-control datepicker" name="tgl">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Jumlah</label>
                                <input type="text" class="form-control" name="jumlah" id="jumlah">
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="form-group">
                                <label>Harga</label>
                                <input type="text" class="form-control" name="harga" readonly="true">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" class="form-control" name="ket">
                          </div>
                        </div>
                        <div class="col-md-6">
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
                                <select class="form-control select2" id="select-city-to" name="cityto">
                                  <option value="">- Pilih Data -</option>
                                </select>
                                <input type="hidden" name="mask-cityto">
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <label>Berat (kg) max 30kg</label>
                                <input type="number" class="form-control" name="berat" onkeyup="setService()" id="berat">
                              </div>
                              <div class="form-group">
                                <label>Kurir</label>
                                <select class="form-control select2" id="select-kurir" name="kurir" onchange="setService()">
                                  <option value="">- Pilih Data -</option>
                                  <option value="jne">JNE</option>
                                  <option value="tiki">TIKI</option>
                                  <option value="pos">POS</option>
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
            <section class="content">
              <div class="row">
                <div class="col-xs-12">
                  <div class="box box-info">
                    <div class="box-header bg">
                      <div class="pull-right box-tools">
                        <button class="btn btn-default btn-sm pull-right" data-widget="collapse" data-toggle="tooltip" title="Collapse" style="margin-right: 5px;"><i class="fa fa-minus"></i></button>
                      </div>
                      <i class="fa fa-search"></i>
                      <h3 class="box-title">
                      Filter Data
                      </h3>
                    </div>
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Tanggal Awal</label>
                            <input type="text" class="form-control datepicker" name="filterawal">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Tanggal Akhir</label>
                            <input type="text" class="form-control datepicker" name="filterakhir">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="box box-info">
                    <div class="box-header">
                      <div class="pull-left">
                        <button class="btn btn-act btn-success btn-flat refresh-btn" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                        <button class="btn btn-act btn-primary btn-flat add-btn invisible" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
                      </div>
                      <div class="pull-right">
                        <button class="btn btn-act bg-navy btn-flat file-btn" onclick="open_file()"><i class="fa fa-file"></i> File</button>
                        <button class="btn btn-act bg-olive btn-flat" onclick="cetak_data()" ><i class="fa fa-print"></i> Cetak</button>
                      </div>
                    </div>
                    <div class="box-body">
                      <div class="table-responsive mailbox-messages">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr id="repeat">
                              <th width="5%"></th>
                              <th width="5%">No</th>
                              <th>ID</th>
                              <th>Kode</th>
                              <th>Tanggal</th>
                              <th>Agen</th>
                              <th>Layanan</th>
                              <th>Pengiriman</th>
                              <th>Keterangan</th>
                              <th>Status</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            </div><!-- /.content-wrapper -->
            <?php $this->load->view('_partials/foot'); ?>
          </div>
        </body>
      </html>
  <?php $this->load->view('_partials/js'); ?>
  <script type="text/javascript">
  var path = 'po_agen';
  var title = 'Purchase Order Agen';
  var grupmenu = 'Transaksi';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;

  $(document).ready(function() {
      getAkses(title);
      setMonth('filterawal',30);
      setMonth('filterakhir',0);
      select2();
      activemenux('transaksi', 'purchaseorderagen');
      dpicker();
      setProvince();
      $('#select-city').select2({ disabled: true });
      $('#select-city-to').select2({ disabled: true });
      $('#select-service').select2({ disabled: true });
      // $('#filteragen').attr('onchange','refresh()')
      
      nilaimax('berat',30)
      // nilaimax('jumlah',1)

      table = $('#table').DataTable({
          "processing": true,
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {
                filterawal  : function() { return $('[name="filterawal"]').val() },
                filterakhir : function() { return $('[name="filterakhir"').val() }
              },
          },
          "columns": [{ 
              "className": 'details-control',
              "orderable": false,
              "data": null,
              "defaultContent": ''
          },
          { "data": "no" }, 
          { "data": "id" , "visible" : false},
          { "data": "kode" },
          { "data": "tgl" },
          { "data": "namacust", "visible" : false },
          { "data": "mlayanan_nama" },
          { "data": "mkirim_nama" },
          { "data": "ket" },
          { "data": "status" }
          ]
      });

    $('#table tbody').on('click', '.odd', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            idx = -1;
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            if (table.row(this).index() > -1) {
                idx = table.row(this).index();
            }
        }
    });

    $('#table tbody').on('click', '.even', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
            idx = -1;
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
            if (table.row(this).index() > -1) {
                idx = table.row(this).index();
            }
        }
    });

    $('#table tbody').on('click', 'td.details-control', function() {
        var tr = $(this).closest('tr');
        var row = table.row(tr);

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            format(row.child, row.data());
            tr.addClass('shown');
        }
    });
  });

  function format(callback, data) {
      $.ajax({
          url: `${apiurl}/getdetail`,
          type: "POST",
          data: {
              xorderkode: data.kode
          },
          success: function(response) {
              callback($(response)).show();
          },
          error: function() {
              $('#output').html('Bummer: there was an error!');
          }
      });
  }

  function previewImage() {
      document.getElementById("image-preview").style.display = "block";
      var oFReader = new FileReader();
      oFReader.readAsDataURL(document.getElementById("image").files[0]);

      oFReader.onload = function(oFREvent) {
          document.getElementById("image-preview").src = oFREvent.target.result;
      };
  };

  function filePreview(input) {
      if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function(e) {
              $('#img-preview').remove();
              $('#image-preview').append('<img id="img-preview" src="' + e.target.result + '"/>');
          }
          reader.readAsDataURL(input.files[0]);
      }
  }

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function refreshfile() {
      tablefile.ajax.reload(null, false);
      idx = -1;
  }

  function open_cust() {
      $('#modal-customer').modal('show');
      tablecust = $('#table-customer').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/loadcustomer`,
              "type": "POST",
              "data": {}
          },
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
          }],
          "columns": [
            { "data": "no" }, 
            { "data": "id" , "visible" : false},
            { "data": "kode" , "visible" : false},
            { "data": "nama" },
            { "data": "alamat" },
            { "data": "telp" },
            { "data": "email" },
            { "data": "opsi" },
          ]

      });

      $('#table-customer tbody').on('click', 'button', function() {
          var data = tablecust.row($(this).parents('tr')).data();
          $('[name="ref_cust"]').val(data.kode);
          $('[name="namacust"]').val(data.nama);
          $('#modal-customer').modal('hide');
      });

  }

  function open_barang() {
      $('#modal-barang').modal('show');
      tablebarang = $('#table-barang').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/loadbrg`,
              "type": "POST",
              "data": {}
          },
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
          }],
          "columns": [
            { "data": "no" }, 
            { "data": "id" , "visible" : false},
            { "data": "kode" , "visible" : false},
            { "data": "nama" },
            { "data": "konv" },
            { "data": "namasatuan" },
            { "data": "harga" },
            { "data": "ket" },
            { "data": "opsi" },
          ]

      });

      $('#table-barang tbody').on('click', 'button', function() {
          var data = tablebarang.row($(this).parents('tr')).data();
          $('[name="kodebrg"]').val(data.kode);
          $('[name="harga"]').val(`${numeral(data.harga).format('0,0')}`);
          $('[name="namabarang"]').val(`${data.nama} (${data.konv} ${data.namasatuan}) Rp. ${numeral(data.harga).format('0,0')}`);
          $('#modal-barang').modal('hide');
      });

  }

  function open_file() {
      xorderkode = table.cell( idx, 3).data();
      if (idx == -1) {
          return false;
      }
      $('#modal-file').modal('show');
      $('#modal-title').modal('Data File');
      tablefile = $('#table-file').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/loadfilelist`,
              "type": "POST",
              "data": {
                xorderkode : xorderkode
              }
          },
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button id='btn-edit-file' class='btn btn-sm btn-warning btn-flat'><i class='fa fa-pencil'></i></button>"
          }],
          "columns": [
            { "data": "no" }, 
            { "data": "id" , "visible" : false},
            { "data": "kode" , "visible" : false},
            { "data": "elempathcorel" },
            { "data": "elempathimage" },
            { "data": "pathcorel" , "visible" : false },
            { "data": "pathimage" , "visible" : false },
            { "data": "opsi" },
          ]

      });

      $('#table-file tbody').on('click', '#btn-edit-file', function() {
          var data = tablefile.row($(this).parents('tr')).data();
          $('#form-file')[0].reset();
          $('[name="editpathcorel"]').val(data.pathcorel);
          $('[name="editpathimage"]').val(data.pathimage);
          $('[name="editkodefile"]').val(data.kode);
          $('#modal-input-file').modal('show');
      });

  }

  function updatefile() {
      var formfile = new FormData($('#form-file')[0]);
      url = "<?php echo base_url() ?>po/updatefile"
      $.ajax({
          url: url,
          type: "POST",
          data: formfile,
          dataType: "JSON",
          mimeType: "multipart/form-data",
          contentType: false,
          cache: false,
          processData: false,
          success: function(data) {
              if (data.sukses == 'success') {
                  $('#modal-input-file').modal('hide');
                  refreshfile();
                  showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-input-file').modal('hide');
                  refreshfile();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
              }

          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger')
          }
      });
  }

  function add_data() {
      state = 'add';
      clearform();
      $('.btn-save').prop('disabled',false);
      $('.box-upload').removeClass('invisible');
      $('#form-data')[0].reset();
      $('#img-preview').remove();
      $('[name="ref_layanan"]').val('2019000002');
      $('#select-provinsi').val('10'); //set to Jawa Tengah
      setMonth('tgl',0);
      $('.select2').trigger('change');
      $('#modal-data').modal('show');
      $('.modal-title').text('Tambah Data');
  }

  function edit_data() {
      $('#btnSimpan').prop('disabled',true);
      kode = table.cell( idx, 3).data();
      $('.box-upload').addClass('invisible');
      if (idx == -1) {
          return false;
      }
      state = 'update';
      $('#form-data')[0].reset();
      $('#img-preview').remove();
      $.ajax({
          url: `${apiurl}/edit`,
          type: "POST",
          data: {
              kode: kode,
          },
          dataType: "JSON",
          success: function(data) {
              $('[name="kode"]').val(data.kode);
              $('[name="kodebrg"]').val(data.kodebrg);
              $('[name="tgl"]').val(data.tgl);
              $('[name="ref_kirim"]').val(data.ref_kirim);
              $('[name="ref_cust"]').val(data.ref_cust);
              $('[name="namacust"]').val(data.mcustomer_nama);
              $('[name="namabarang"]').val(data.mbarang_nama);
              $('[name="ref_layanan"]').val(data.ref_layanan);
              $('[name="kirimke"]').val(data.kirimke);
              $('[name="ket"]').val(data.ket);
              $('[name="alamat"]').val(data.alamat);
              $('[name="jumlah"]').val(data.jumlah);
              $('[name="harga"]').val(data.harga);
              $('[name="berat"]').val(data.kgkirim);
              $('[name="provinsi"]').val(data.kodeprovfrom);
              $('[name="provinsito"]').val(data.kodeprovto);
              $('[name="city"]').val(data.kodecityfrom);
              setTimeout(function(){ 
                $('[name="cityto"]').val(data.kodecityto);
                $('[name="kurir"]').val(data.kurir);
                $('[name="kurir"]').trigger('change'); 
                $('[name="cityto"]').trigger('change'); 
              }, 4000);
              setTimeout(function(){ 
                $('[name="biaya"]').val(data.bykirim);
                $('[name="kodekurir"]').val(data.kodekurir);
                $('[name="biaya"], [name="kodekurir"]').trigger('change');
                $('#btnSimpan').prop('disabled',false); 
              }, 5000);
              console.log($('[name="cityto"]').val());
              $('.select2').trigger('change');
              $('#modal-data').modal('show');
              notifLoading();
              $('.modal-title').text('Edit Data');
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function savedata() {
      if (ceknull('namabarang')) { return false }
      if (ceknull('tgl')) { return false }
      if (ceknull('jumlah')) { return false }
      if (state == 'add') {
        if (ceknull('corel')) { return false }
      }
      if (ceknull('ref_kirim')) { return false }
      if (ceknull('kirimke')) { return false }
      if (ceknull('ref_layanan')) { return false }
      $('[name="mask-provinsi"]').val($('[name="provinsi"]  option:selected').html());
      $('[name="mask-city"]').val($('[name="city"]  option:selected').html());
      $('[name="mask-provinsito"]').val($('[name="provinsito"]  option:selected').html());
      $('[name="mask-cityto"]').val($('[name="cityto"] option:selected').html());
      var url;
      if (state == 'add') {
          url = `${apiurl}/savedata`;
      } else {
          url = `${apiurl}/updatedata`;
      }
      var formData = new FormData($('#form-data')[0]);
      $('.btn-save').prop('disabled',true);
      $.ajax({
          url: url,
          type: "POST",
          data: formData,
          dataType: "JSON",
          mimeType: "multipart/form-data",
          contentType: false,
          cache: false,
          processData: false,
          success: function(data) {
              if (data.sukses == 'success') {
                  $('#modal-data').modal('hide');
                  refresh();
                  state == 'add' ? showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success') : showNotif('Sukses', 'Data Berhasil Diubah', 'success')
                  $('.btn-save').prop('disabled',false);
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
                  $('.btn-save').prop('disabled',false);
              }

          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger')
              $('.btn-save').prop('disabled',false);
          }
      });
  }

  function hapus_data() {
      id = table.cell( idx, 2).data();
      if (idx == -1) {
          return false;
      }
      $('.modal-title').text('Yakin Void Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'delete_data(' + id + ')');
  }

  function delete_data(id) {
      $.ajax({
          url: `${apiurl}/deletedata`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  refresh();
                  showNotif('Sukses', 'Data Berhasil Dihapus', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Gagal', 'Data Gagal Dihapus', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function unduh_data(dt) {
      window.open("<?php echo site_url('')?>" + dt);
  }

  function changekirim() {
    let kode = $('#ref_kirim').val();
    let label= $('#ref_kirim option:selected').html();
    if ((kode == 'GX0002') || (label == 'kurir')) {
      $('#box-kurir').removeClass('invisible');
    } else {
      $('#box-kurir').addClass('invisible');
    }
  }

  function setProvince() {
      $('#select-provinsi').load(`${apiurl}/request_province`, function(){
        console.log('finish')
        $('#select-provinsi').val('10');
        $('#select-provinsi').trigger('change');
      });
      $('#select-provinsi-to').load(`${apiurl}/request_province`, function(){
        console.log('finish')
      });
      return false;
  }

  function setCity() {
      let id_province = $('#select-provinsi').val();
      $('#select-city').select2({ disabled: false });
      if (id_province.length) {
          $('#select-city').load(`${apiurl}/request_city?province=${id_province}`, function() {
            console.log('finish City');
            $('#select-city').select2({ disabled: false });
            $('#select-city').val('445');
            $('#select-city').trigger('change');
          });
      }
      return false;
  }

  function setCityTo() {
      let id_province = $('#select-provinsi-to').val();
      $('#select-city-to').select2({ disabled: true });
      if (id_province) {
          $('#select-city-to').load(`${apiurl}/request_city?province=${id_province}`, function () {
            console.log('finish City to');
            $('#select-city-to').select2({ disabled: false });
          });
      }
      return false;
  }

  function setService() {
      let origin      = $('[name="city"]').val();
      let destination = $('[name="cityto"]').val();
      let weight      = $('[name="berat"]').val();
      let courier     = $('[name="kurir"]').val();
      if ($('#select-kurir').val()) {
        $('#select-service').load(`${apiurl}/request_ongkir?origin=${origin}&destination=${destination}&weight=${weight}&courier=${courier}`, function() {
        console.log('finish Service');
        $('#select-service').select2({ disabled: false });
      });
      }
      
      $('[name="biaya"]').val($('#select-service').val()) ; 
      $('[name="biaya"]').val('');
      $('[name="kodekurir"]').val('');
      return false;
  }

  function setPrice() {
    let s = $('#select-service').val()
    if (s.length > 0) {
      let b = s.match((/\?(.*?)\?/g));
      let k = s.match((/\@(.*?)\@/g));
      $('[name="biaya"]').val(b.toString().replace(/\?/g, ''));
      $('[name="kodekurir"]').val(k.toString().replace(/\@/g, ''));
    }
  }

  function cetak_data() {
      kode = table.cell(idx, 3).data();
      if (idx == -1) {
          return false;
      }
      window.open(`${apiurl}/cetak?kode=${kode}`);
  }


  
  </script>
</body>
</html>