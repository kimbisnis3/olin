<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper" id="app">
    <?php $this->load->view('_partials/topbar'); ?>
    <?php $this->load->view('_partials/sidebar'); ?>
  <div class="content-wrapper">
    <section class="content-header">
      <h1 class="title">
      
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active title"></li>
      </ol>
    </section>
    <div class="modal fade" id="modal-data" role="dialog" data-backdrop="static">
      <div class="modal-dialog">
        <!-- Modal content-->
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
                  <div class="form-group">
                    <label>Judul</label>
                    <input type="hidden" name="id">
                    <input type="text" class="form-control" name="judul">
                  </div>
                  <div class="form-group">
                    <label>Gambar</label>
                    <input type="file" class="form-control" name="image" id="image" >
                  </div>
                  <div class="form-group">
                    <label>Artikel</label>
                    <textarea class="form-control" rows="7" name="artikelx" id="artikelx"></textarea>
                  </div>
                  <div class="form-group" style="display : none;">
                    <label>Artikel</label>
                    <textarea class="form-control" rows="7" name="artikel" id="artikel"></textarea>
                  </div>
                  <div class="form-group">
                    <label>Keterangan</label>
                    <input type="text" class="form-control" name="ket" >
                  </div>
                  <div class="form-group">
                    <input type="hidden" name="path" id="path">
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
              <div class="box-header">
                <button class="btn btn-success btn-flat" onclick="refresh()"  title="Cek Data"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
                <button class="btn btn-warning btn-flat" onclick="add_data()" ><i class="fa fa-plus"></i> Tambah</button>
              </div>
              <div class="box-body">
                <div class="table-responsive mailbox-messages">
                  <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr id="repeat">
                        <th>No</th>
                        <th>Judul</th>
                        <th>Artikel</th>
                        <th>Image</th>
                        <th>Keterangan</th>
                        <th>Status</th>
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
      </div><!-- /.content-wrapper -->
    <?php $this->load->view('_partials/foot'); ?>
  </div>
</body>
</html>
  <?php $this->load->view('_partials/js'); ?>
  <script type="text/javascript">
  var controller = 'berita';
  var title = 'Berita';
  var apiurl = "<?php echo base_url('') ?>" + controller;
  var state;
  var grupmenu = 'Berita';

  $(document).ready(function() {
      activemenu()
      table = $('#table').DataTable({
          "processing": true,
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {}
          },
          "columns": [
          { "data": "no" }, 
          { "data": "judul" }, 
          { "data": "artikel" }, 
          { "data": "image" }, 
          { "data": "ket" }, 
          { "data": "aktif" }, 
          { "data": "action"}
          ]
      });
  });


  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function add_data() {
      state = 'add';
      $('#form-data')[0].reset();
      CKEDITOR.instances.artikelx.setData('');
      $('#modal-data').modal('show');
      $('.modal-title').text('Tambah Data');
  }

  function edit_data(id) {
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
              $('[name="path"]').val('.' + data.image);
              CKEDITOR.instances.artikelx.setData(data.artikel);

              $('#modal-data').modal('show');
              $('.modal-title').text('Edit Data');

          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });
  }

  function savedata() {
      var url;
      artikel = CKEDITOR.instances['artikelx'].getData();
      $('#artikel').val(artikel);
      if (state == 'add') {
          url = `${apiurl}/savedata`;
      } else {
          url = `${apiurl}/updatedata`;
      }
      var formData = new FormData($('#form-data')[0]);
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
              } else if (data.sukses == 'fail') {
                  $('#modal-data').modal('hide');
                  refresh();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
              }

          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });
  }

  function hapus_data(id) {
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
              refresh();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });
  }

  function aktif_data(id) {
      $.ajax({
          url: `${apiurl}/aktifdata`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              if (data.sukses == 'success') {
                  refresh();
                  showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  refresh();
                  showNotif('Gagal', 'Data Gagal Diubah', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });
  }

  </script>
</body>
</html>