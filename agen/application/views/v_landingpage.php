<!DOCTYPE html>
<html>
<?php $this->load->view('_partials/head'); ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper" id="app">
    <?php $this->load->view('_partials/topbar'); ?>
    <?php $this->load->view('_partials/sidebar'); ?>
    <div class="content-wrapper">
      <section class="content-header">
        <h1 class="title">
          <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active title"><?php echo $title; ?></li>
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
                            <input type="text" class="form-control" name="ref_order" readonly="true">
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
      </div> <!-- END MODAL INPUT-->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-info">
              <div class="box-header">
                <div class="pull-left"><h4>PO Belum Dibayar</h4></div>  
                <div class="pull-right">
                  <button class="btn btn-act btn-success btn-flat refresh-btn" onclick="refresh()"><i
                      class="fa fa-refresh"></i> Refresh</button>
                  <button class="btn btn-act btn-primary btn-flat add-btn invisible" onclick="add_data()"><i
                      class="fa fa-plus"></i> Tambah</button>
                </div>
              </div>
              <div class="box-body">
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
                      <th>Mask_Total</th>
                      <th>Mask_Dibayar</th>
                      <th>Mask_Kurang</th>
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
        </div>
      </section>
    </div>
    <?php $this->load->view('_partials/foot'); ?>
  </div>
</body>

</html>
<?php $this->load->view('_partials/js'); ?>
<script>
  var path = 'pembayaran';
  var apiurl = "<?php echo base_url('') ?>" + path;
  $(".title").html("Dashboard");
  $(document).ready(function () {
    open_order()
    select2();
    dpicker();
    setMonth('filterawal', 30);
    setMonth('filterakhir', 0);
  })

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
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
            { "render" : (data,type,row,meta) => {return format_number(row['total']) } } ,
            { "render" : (data,type,row,meta) => {return format_number(row['dibayar']) } } ,
            { "render" : (data,type,row,meta) => {return format_number(row['kurang']) } } ,
            { "render" : (data,type,row,meta) => {return row['total'] }, "visible" : false } ,
            { "render" : (data,type,row,meta) => {return row['dibayar'] }, "visible" : false } ,
            { "render" : (data,type,row,meta) => {return row['kurang'] }, "visible" : false } ,
            { "data": "ket" },
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
      });

      $('#table-order tbody').on('click', '#pilih-order', function() {
          state = 'add';
          $('#form-data')[0].reset();
          var data = tableorder.row($(this).parents('tr')).data();
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
                  state == 'add' ? showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success') : showNotif('Sukses', 'Data Berhasil Diubah', 'success')
                  state == 'add' ? showNotif('', 'Kode Unik Anda '+data.kodeunik, 'success') : ''
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
</script>