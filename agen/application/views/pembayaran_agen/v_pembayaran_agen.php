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
                              <label>Pesanan</label>
                              <input type="hidden" name="kode">
                              <div class="input-group">
                                <input type="text" class="form-control" name="ref_order" readonly="true">
                                <div class="input-group-btn">
                                  <button type="button" class="btn btn-primary btn-flat" onclick="open_order()"><i class="fa fa-table"></i></button>
                                </div>
                              </div>
                            </div>
                            <div class="form-group">
                              <label>Total</label>
                              <input type="text" class="form-control" name="total" readonly="true">
                              <input type="text" class="form-control invisible" name="kurang" readonly="true">
                            </div>
                            <div class="form-group">
                              <label>Jenis Bayar</label>
                              <select class="form-control select2" name="ref_jenbayar" onchange="jenisbayar()">
                                <option> - </option>
                                <?php foreach ($jenisbayar as $i => $v): ?>
                                <option value="<?php echo $v->kode ?>"><?php echo $v->nama; ?></option>
                                <?php endforeach ?>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <!-- <div class="form-group">
                              <label>Agen</label>
                              <input type="hidden" class="form-control" name="ref_cust">
                              <input type="text" class="form-control" name="mcustomer_nama" readonly="true"/>
                            </div> -->
                            <div class="form-group">
                              <label>Tanggal</label>
                              <input type="text" class="form-control datepicker" name="tgl">
                            </div>
                            <div class="form-group">
                              <label>Bayar</label>
                              <input type="number" class="form-control" name="bayar" id="bayar">
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <label>Keterangan</label>
                              <input type="text" class="form-control" name="ket">
                            </div>
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
          <div class="modal fade" id="modal-order" role="dialog" data-backdrop="static">
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
                        <table id="table-order" class="table table-striped table-bordered" cellspacing="0" width="100%">
                          <thead>
                            <tr>
                              <th width="5%">No</th>
                              <th>ID</th>
                              <th>Kode</th>
                              <th>Ref Cust</th>
                              <th>Agen</th>
                              <th>Tanggal</th>
                              <th>Total</th>
                              <th>Dibayar</th>
                              <th>Kurang</th>
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
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12">
                  <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">Pembayaran</a></li>
                      <li><a href="#tab_2" data-toggle="tab">Riwayat</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <div class="box box-info">
                          <div class="box-header">
                            <div class="pull-left">
                              <button class="btn btn-act btn-success btn-flat refresh-btn" onclick="refresh2()"><i class="fa fa-refresh"></i> Refresh</button>
                            </div>
                          </div>
                          <div class="box-body">
                            <div class="table-responsive mailbox-messages">
                              <table id="table2" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                  <tr>
                                    <th width="5%">No</th>
                                    <th>ID</th>
                                    <th>Kode</th>
                                    <th>Ref Cust</th>
                                    <th>Agen</th>
                                    <th>Tanggal</th>
                                    <th>Total</th>
                                    <th>Dibayar</th>
                                    <th>Kurang</th>
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
                      </div><!-- TAB 1-->
                      <div class="tab-pane" id="tab_2">
                        <div class="box box-info">
                          <div class="box-header">
                            <div class="pull-left">
                              <button class="btn btn-act btn-success btn-flat refresh-btn" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                              <!-- <button class="btn btn-act btn-primary btn-flat add-btn invisible" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button> -->
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
                                    <th>Agen</th>
                                    <th>Kode PO</th>
                                    <th>Jenis Bayar</th>
                                    <th>Bayar</th>
                                    <th>Keterangan</th>
                                    <th>Kode Unik</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div><!-- TAB 2-->
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
  var path = 'pembayaran';
  var title = 'Pembayaran';
  var grupmenu = 'Transaksi';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;

  $(document).ready(function() {
      getAkses(title);
      select2();
      activemenux('transaksi', 'pembayaran');
      dpicker();
      setMonth('filterawal',30);
      setMonth('filterakhir',0);
      data_2()

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
              },
          },
          "columns": [
          { "data": "id", "visible" : false }, 
          { "data": "id", "note" : "numbers" }, 
          { "data": "id" , "visible" : false},
          { "data": "kode" , "visible" : false},
          { "data": "posted" , "visible" : false},
          { "data": "tgl" }, 
          { "data": "mcustomer_nama", "visible" : false },
          { "data": "ref_jual" },
          { "data": "mjenbayar_nama" },
          { "data": "bayar" },
          { "data": "ket" },
          { "data": "kodeunik" },
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

  function data_2() {
    table2 = $('#table2').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/getorder`,
              "type": "POST",
              "data": {}
          },
          "columns": [
            { "render" : (data,type,row,meta) => {return meta.row + 1} },
            { "data": "id" , "visible" : false},
            { "data": "kode" , "visible" : true},
            { "data": "ref_cust" , "visible" : false},
            { "data": "mcustomer_nama" , "visible" : false },
            { "data": "tgl" },
            { "data": "total" },
            { "data": "dibayar" },
            { "data": "kurang" },
            { "data": "kurang" },
            { "render" : (data,type,row,meta) => 
            { 
              if (row['dibayar'] <= 0 || row['dibayar'] == null || row['dibayar'] == '') {
                return "<button type='button' class='btn btn-hijau btn-flat btn-block' id='pilih-order'>Bayar</button>"
              } else {
                return "<button type='button' class='btn btn-biru btn-flat btn-block' id='pilih-order'>Lunasi</button>"
              } 
            }
            }
          ]
    })

    $('#table2 tbody').on('click', '#pilih-order', function() {
          state = 'add';
          $('#form-data')[0].reset();
          var data = table2.row($(this).parents('tr')).data();
          $('[name="ref_cust"]').val(data.ref_cust);
          $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
          $('[name="ref_order"]').val(data.kode);
          $('[name="kurang"]').val(data.kurang);
          $('[name="total"]').val(data.total);
          $('[name="bayar"]').val(parseInt(data.kurang));
          if (data.dibayar <= 0 || data.dibayar == null || data.dibayar == '') {
            $('[name="ref_jenbayar"]').val('GX0003')
            $('.select2').trigger('change');
          } else {
            $('[name="ref_jenbayar"]').val('GX0001')
            $('.select2').trigger('change');
          }
          setMonth('tgl', 0);
          $('#modal-data').modal('show');
      });
  }

  function jenisbayar() {
    let ref_jenbayar = $('[name="ref_jenbayar"]').val()
    let total = $('[name="kurang"]').val()
    if (ref_jenbayar == 'GX0003') {
      $('#bayar').val(total / 2)
    } else if (ref_jenbayar == 'GX0001') {
      $('#bayar').val(total)
    }
  }

  function format(callback, data) {
      $.ajax({
          url: `${apiurl}/getdetail`,
          type: "POST",
          data: {
              kodepelunasan: data.kode
          },
          success: function(response) {
              callback($(response)).show();
          },
          error: function() {
              $('#output').html('Bummer: there was an error!');
          }
      });
  }

  function open_order() {
      $('#modal-order').modal('show');
      tableorder = $('#table-order').DataTable({
          "processing": true,
          "destroy": true,
          "ajax": {
              "url": `${apiurl}/getorder`,
              "type": "POST",
              "data": {}
          },
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button id='pilih-order' class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
          }],
          "columns": [
            { "render" : (data,type,row,meta) => {return meta.row + 1} },
            { "data": "id" , "visible" : false},
            { "data": "kode" , "visible" : true},
            { "data": "ref_cust" , "visible" : false},
            { "data": "mcustomer_nama" , "visible" : false },
            { "data": "tgl" },
            { "data": "total" },
            { "data": "dibayar" },
            { "data": "kurang" },
            { "data": "ket" },
            { "data": "opsi" },
          ]
      });

      $('#table-order tbody').on('click', '#pilih-order', function() {
          var data = tableorder.row($(this).parents('tr')).data();
          $('[name="ref_cust"]').val(data.ref_cust);
          $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
          $('[name="ref_order"]').val(data.kode);
          $('[name="kurang"]').val(data.kurang);
          $('[name="total"]').val(data.total);
          $('[name="bayar"]').val(parseInt(data.kurang));
          // nilaimax('bayar',data.kurang)
          $('#modal-order').modal('hide');
      });

  }

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function refresh2() {
      table2.ajax.reload(null, false);
      idx = -1;
  }

  function add_data() {
      state = 'add';
      $('#form-data')[0].reset();
      clearform();
      setMonth('tgl',0);
      $('.select2').trigger('change');
      $('#modal-data').modal('show');
      $('.select2').trigger('change');
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
              $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
              $('[name="tgl"]').val(data.tgl);
              $('[name="total"]').val(data.total);
              $('[name="bayar"]').val(data.bayar);
              $('[name="ket"]').val(data.ket);
              $('[name="ref_order"]').val(data.ref_jual);
              $('[name="ref_jenbayar"]').val(data.ref_jenbayar);
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
      if (ceknull('tgl')) { return false }
      if (ceknull('ref_jenbayar')) { return false }
      let ref_jenbayar = $('[name="ref_jenbayar"]').val()
      let total = $('[name="kurang"]').val()
      if (ref_jenbayar == 'GX0003' && $('#bayar').val() < (total / 2)) {
        showNotif('Perhatian', 'Pembayaran Tidak Boleh Kurang dari 50%', 'danger');
        return false
      }
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
                  refresh2();
                  state == 'add' ? showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success') : showNotif('Sukses', 'Data Berhasil Diubah', 'success')
                  state == 'add' ? showNotif('', 'Kode Unik Anda '+data.kodeunik, 'success') : ''
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  refresh2();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger')
          }
      });
  }

  function valid_data() {
      id = table.cell( idx, 2).data();
      let validasiValue = table.cell( idx, 4).data();
      if (validasiValue == 't') {
        showNotif('Perhatian', 'Data Sudah Tervalidasi', 'warning')
        return false;
      }
      if (idx == -1) {
          return false;
      }
      $('.modal-title').text('Validasi Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'validation_data(' + id + ')');
  }

  function validation_data(id) {
      $.ajax({
          url: `${apiurl}/validdata`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
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

  </script>
</body>
</html>