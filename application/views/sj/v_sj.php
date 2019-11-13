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
          </div>  <!-- END MODAL INPUT-->
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
                              <th>Kirim Ke</th>
                              <th>Ref Biaya</th>
                              <th>Kirim Ke</th>
                              <th>Alamat</th>
                              <th>Kurir</th>
                              <th>Kode Kurir</th>
                              <th>Agen</th>
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
            </div>  <!-- END MODAL ORDER-->
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
                        <div class="col-md-3">
                          <label>Agen</label>
                          <select class="form-control select2" name="filteragen" id="filteragen">
                          </select>
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
                        <button class="btn btn-act btn-warning btn-flat edit-btn invisible" onclick="edit_data()"><i class="fa fa-pencil"></i> Ubah</button>
                        <button class="btn btn-act btn-success btn-flat option-btn invisible" id="btn-valid" onclick="valid_data()"><i class="fa fa-check"></i> Validasi</button>
                        <button class="btn btn-act btn-danger btn-flat delete-btn invisible" onclick="void_data()" ><i class="fa fa-trash"></i> Void</button>
                        <button class="btn btn-act bg-olive btn-flat" onclick="cetak_data()" ><i class="fa fa-print"></i> Cetak</button>
                      </div>
                    </div>
                    <div class="box-body">
                      <div class="table-responsive mailbox-messages">
                        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th></th>
                              <th width="5%">No</th>
                              <th>ID</th>
                              <th>Kode</th>
                              <th>Posted</th>
                              <th>Tanggal</th>
                              <th>Tanggal Kirim</th>
                              <th>Agen</th>
                              <th>Penerima</th>
                              <th>Berat(kg)</th>
                              <th>Kurir</th>
                              <th>Tujuan</th>
                              <th>Biaya</th>
                              <th>Telp</th>
                              <th>Keterangan</th>
                              <th></th>
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
  var path = 'sj';
  var title = 'Surat Jalan ';
  var grupmenu = 'Transaksi';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;

  $(document).ready(function() {
      getAkses(title);
      select2();
      activemenux('transaksi', 'suratjalan');
      dpicker();
      setMonth('filterawal',30);
      setMonth('filterakhir',0);
      getSelectcustom('filteragen', 'universe/getcustomer', 'filteragenclass','kode', 'nama')

      table = $('#table').DataTable({
          "processing": true,
          "createdRow": function( row, data, dataIndex ) 
          {
            if ( data.posted == "t" ) {        
              $(row).addClass('uni-green');
            }else {        
              $(row).addClass('uni-red');
            }
          },
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {
                filterawal  : function() { return $('[name="filterawal"]').val() },
                filterakhir : function() { return $('[name="filterakhir"').val() },
                filteragen : function() { return $('[name="filteragen"').val() },
              },
          },
          "columns": [{ 
              "className": 'details-control',
              "orderable": false,
              "data": null,
              "defaultContent": ''
          },
          { "data": "id" , "note" : "num" }, 
          { "data": "id" , "visible" : false},
          { "data": "kode" , "visible" : false},
          { "data": "posted" , "visible" : false},
          { "data": "tgl" }, 
          { "data": "tglkirim" },
          { "data": "mcustomer_nama" },
          { "data": "kirim" },
          { "data": "kgkirim" },
          { "data": "kurir" },
          { "data": "lokasike" },
          { "data": "biayakirim" },
          { "data": "telp" },
          { "data": "ket" },
          { "render" : (data,type,row,meta) => { return row['posted'] == 't' ? '<span class="label label-success"><i class="fa fa-check"></i></span>' : '' }},
          ]
      });

    table.on( 'order.dt search.dt', function () {
        table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

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
              kodesj: data.kode
          },
          success: function(response) {
              callback($(response)).show();
          },
          error: function() {
              $('#output').html('Bummer: there was an error!');
          }
      });
  }

  function open_proc() {
      $('#modal-proc').modal('show');
      tableproc = $('#table-proc').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/getproc`,
              "type": "POST",
              "data": {}
          },
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button id='pilih-data' class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
          }],
          "columns": [
            { "data": "id" }, 
            { "data": "id" , "visible" : false},
            { "data": "xorder_kode" , "visible" : false},
            { "data": "ref_cust" , "visible" : false},
            { "data": "ref_cust" , "visible" : false},
            { "data": "bykirim" , "visible" : false},
            { "data": "kirimke" , "visible" : false},
            { "data": "alamat" , "visible" : false},
            { "data": "kurir" , "visible" : false},
            { "data": "kodekurir" , "visible" : false},
            { "data": "mbarang_nama" },
            { "data": "tgl" },
            { "data": "status" },
            { "data": "ket" },
            { "data": "opsi" },
          ]

      });

      tableproc.on( 'order.dt search.dt', function () {
          tableproc.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
              cell.innerHTML = i+1;
          } );
      } ).draw();

      $('#table-proc tbody').on('click', '#pilih-data', function() {
          var data = tableproc.row($(this).parents('tr')).data();
          $('[name="ref_cust"]').val(data.ref_cust);
          $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
          $('[name="ref_order"]').val(data.xorder_kode);
          $('[name="biayakirim"]').val(data.bykirim);
          $('[name="kirim"]').val(data.kirimke);
          $('[name="alamat"]').val(data.alamat);
          $('[name="kurir"]').val(data.kurir);
          $('[name="kodekurir"]').val(data.kodekurir);
          $('#modal-proc').modal('hide');
      });

  }

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function add_data() {
      state = 'add';
      clearform();
      $('#form-data')[0].reset();
      setMonth('tgl',0);
      $('.select2').trigger('change');
      $('#modal-data').modal('show');
      $('.modal-title').text('Tambah Data');
  }

  function edit_data() {
      kode = table.cell( idx, 3).data();
      let validasiValue = table.cell( idx, 4).data();
      if (validasiValue == 't') {
        showNotif('Perhatian', 'Data Sudah Tervalidasi', 'warning')
        return false;
      }
      if (idx == -1) {
          return false;
      }
      state = 'update';
      $('#form-data')[0].reset();
      $.ajax({
          url: `${apiurl}/edit`,
          type: "POST",
          data: {
              kode: kode,
          },
          dataType: "JSON",
          success: function(data) {
              $('[name="kode"]').val(data.kode);
              $('[name="ref_cust"]').val(data.ref_cust);
              $('[name="ref_order"]').val(data.ref_order);
              $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
              $('[name="tgl"]').val(data.tgl);
              $('[name="tglkirim"]').val(data.tglkirim);
              $('[name="biayakirim"]').val(data.biayakirim);
              $('[name="pic"]').val(data.pic);
              $('[name="kirim"]').val(data.kirim);
              $('[name="ket"]').val(data.ket);
              $('[name="noresi"]').val(data.noresi);
              $('.select2').trigger('change');
              $('#modal-data').modal('show');
              $('.modal-title').text('Edit Data');
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function savedata() {
      if (ceknull('ref_order')) { return false }
      if (ceknull('mcustomer_nama')) { return false }
      if (ceknull('kirim')) { return false }
      if (ceknull('biayakirim')) { return false }
      if (ceknull('tgl')) { return false }
      if (ceknull('tglkirim')) { return false }
      if (ceknull('pic')) { return false }

      var url;
      if (state == 'add') {
          url = `${apiurl}/savedata`;
      } else {
          url = `${apiurl}/updatedata`;
      }
      $.ajax({
          url: url,
          type: "POST",
          data: $('#form-data').serializeArray(),
          dataType: "JSON",
          success: function(data) {
              if (data.sukses == 'success') {
                  $('#modal-data').modal('hide');
                  refresh();
                  state == 'add' ? showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success') : showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger')
          }
      });
  }

  function valid_data() {
      btnproc('#btn-valid',1)
      kode = table.cell(idx, 3).data();
      if (idx == -1) {
          return false;
          btnproc('#btn-valid',0)
      }
      let validasiValue = table.cell(idx, 4).data();
      if (validasiValue == 't') {
          showNotif('Perhatian', 'Data Sudah Tervalidasi', 'warning')
          btnproc('#btn-valid',0)
          return false;
      }
      $.ajax({
          url: `${apiurl}/ceklunas`,
          type: "POST",
          dataType: "JSON",
          data: {
              kode: kode,
          },
          success: function(data) {
              if (data.lunas == 'L') {
                  $('.modal-title').text('Validasi Data ?');
                  $('#modal-konfirmasi').modal('show');
                  $('#btnHapus').attr('onclick', `validation_data('${kode}')`);
                  btnproc('#btn-valid',0)
              } else {
                  showNotif('Perhatian', 'PEmbayaran Belum Lunas ', 'warning')
                  btnproc('#btn-valid',0)
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });

  }

  function validation_data(kode) {
      $.ajax({
          url: `${apiurl}/validdata`,
          type: "POST",
          dataType: "JSON",
          data: {
              kode: kode,
          },
          success: function(data) {
              if (data.sukses == 'success') {
                  refresh();
                  showNotif('Sukses', 'Data Berhasil di Validasi', 'success')
                  $('#modal-konfirmasi').modal('hide');
              } else if (data.sukses == 'fail') {
                  refresh();
                  showNotif('Gagal', 'Data Gagal di Validasi', 'danger')
                  $('#modal-konfirmasi').modal('hide');
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }


  function void_data() {
      id = table.cell( idx, 2).data();
      if (idx == -1) {
          return false;
      }
      $('.modal-title').text('Yakin Void Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'do_void_data(' + id + ')');
  }

  function do_void_data(id) {
      $.ajax({
          url: `${apiurl}/voiddata`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  refresh();
                  showNotif('Sukses', 'Data Berhasil Divoid', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Gagal', 'Data Gagal Divoid', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
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