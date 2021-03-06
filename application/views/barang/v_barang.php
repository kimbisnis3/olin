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
              <div class="modal-body"  id="staticProgress">
                <div class="box-body pad">
                  <form id="form-data">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Provinsi Asal</label>
                              <select class="form-control select2" id="select-provinsi" name="provinsi" onchange="setCity()">
                                <option value="">- Pilih Data -</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Kota Asal</label>
                              <select class="form-control select2" id="select-city" name="city">
                                <option value="">- Pilih Data -</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>Provinsi Tujuan</label>
                              <select class="form-control select2" id="select-provinsi-to" name="provinsito" onchange="setCityTo()">
                                <option value="">- Pilih Data -</option>
                              </select>
                            </div>
                            <div class="form-group">
                              <label>Kota Tujuan</label>
                              <select class="form-control select2" id="select-city-to" name="cityto">
                                <option value="">- Pilih Data -</option>
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-4">
                            <div class="form-group">
                              <label>Berat (kg)</label>
                              <input type="text" class="form-control" name="berat" onkeyup="setService()">
                            </div>
                          </div>
                          <div class="col-md-8">
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
                          <div class="col-md-7">
                            <div class="form-group">
                              <label>Service</label>
                              <select class="form-control select2" id="select-service" name="serv" onchange="setPrice()">
                                <option value="">- Pilih Data -</option>
                              </select>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <label>Biaya</label>
                            <input type="text" class="form-control" name="biaya" disabled="true">
                          </div>
                          <div class="col-md-2">
                            <label>Kode Kurir</label>
                            <input type="text" class="form-control" name="kodekurir" disabled="true">
                          </div>
                        </div>
                        <div class="row">
                          
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
                          <label>Filter 1</label>
                          <input type="text" class="form-control datepicker" name="xx">
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <label>Filter 2</label>
                          <input type="text" class="form-control" name="zzz">
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
                      <button class="btn btn-success btn-flat refresh-btn" onclick="refresh()"><i class="fa fa-refresh"></i> Refresh</button>
                      <button class="btn btn-primary btn-flat add-btn invisible" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
                    </div>
                    <div class="pull-right">
                      <button class="btn btn-warning btn-flat edit-btn invisible" onclick="edit_data()"><i class="fa fa-pencil"></i> Ubah</button>
                      <button class="btn btn-danger btn-flat delete-btn invisible" onclick="hapus_data()" ><i class="fa fa-trash"></i> Hapus</button>
                    </div>
                  </div>
                  <div class="box-body">
                    <div class="table-responsive mailbox-messages">
                      <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                        <thead>
                          <tr id="repeat">
                            <th width="5%">No</th>
                            <th>ID</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Keterangan</th>
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
  var path = 'barang';
  var title = 'Data Produk';
  var grupmenu = 'Master';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;

  $(document).ready(function() {
      getAkses(title);
      allowAkses();
      select2();
      activemenux('master', 'dataproduk');
      setProvince();
      $('#select-city').prop("disabled",true);
      $('#select-city-to').prop("disabled",true);
      $('#select-service').prop("disabled",true);

      table = $('#table').DataTable({
          "processing": true,
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {},
          },
          "columns": [
          { "data": "no" }, 
          { "data": "id" , "visible" : false},
          { "data": "kode" }, 
          { "data": "nama" }, 
          { "data": "status" }, 
          { "data": "ket" }
          ]
      });

    $('#table tbody').on('click', 'tr', function() {
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
  });

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function add_data() {
      state = 'add';
      $('#form-data')[0].reset();
      $('.select2').trigger('change');
      $('#modal-data').modal('show');
      $('.modal-title').text('Tambah Data');
  }

  function edit_data() {
      id = table.cell( idx, 1).data();
      if (idx == -1) {
          return false;
      }
      state = 'update';
      $('#form-data')[0].reset();
      $.ajax({
          url: `${apiurl}/edit`,
          type: "POST",
          data: {
              id: id,
          },
          dataType: "JSON",
          success: function(data) {
              $('[name="id"]').val(data.id);
              $('[name="judul"]').val(data.judul);
              $('[name="ket"]').val(data.ket);
              $('#selectsatu').val(data.id);
              $('#selectdua').val(data.id);
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

  function hapus_data() {
      id = table.cell( idx, 1).data();
      if (idx == -1) {
          return false;
      }
      $('.modal-title').text('Yakin Hapus Data ?');
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

  function setProvince() {
      $('#select-provinsi').load('<?php echo site_url()?>barang/request_province', function(){
        console.log('finish')
      });
      $('#select-provinsi-to').load('<?php echo site_url()?>barang/request_province');
      return false;
  }

  function setCity() {
      let id_province = $('#select-provinsi').val();
      if (id_province.length) {
          $('#select-city').load(`<?php echo site_url()?>barang/request_city?province=${id_province}`, function() {
            console.log('finish City');
            $('#select-city').prop("disabled",false)
          });
      }
      return false;
  }

  function setCityTo() {
      let id_province = $('#select-provinsi-to').val();
      if (id_province) {
          $('#select-city-to').load(`<?php echo site_url()?>barang/request_city?province=${id_province}`, function () {
            console.log('finish City to');
            $('#select-city-to').prop("disabled",false)
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
        $('#select-service').load(`<?php echo site_url()?>barang/request_ongkir?origin=${origin}&destination=${destination}&weight=${weight}&courier=${courier}`, function() {
        console.log('finish Service');
        $('#select-service').prop("disabled",false)
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



  </script>
</body>
</html>