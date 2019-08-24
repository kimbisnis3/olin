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
        <div id="modal-konfirmasi" class="modal fade" role="dialog">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <center><h4 class="modal-title-konfirmasi"></h4></center>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-warning btn-flat" data-dismiss="modal">Tidak</button>
                <button @click="do_qc" type="button" id="btnHapus" class="btn btn-danger btn-flat">Ya</button>
              </div>
            </div>
          </div>
        </div>
          <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="row">
                <div class="col-xs-12">
                  <div class="box box-info">
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Awal</label>
                            <input type="text" class="form-control datepicker" name="filterawal">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Akhir</label>
                            <input type="text" class="form-control datepicker" name="filterakhir">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Status Proses</label>
                            <select class="form-control select2" name="filterstatus">
                              <option value=""></option>
                              <option value="0">Antri Produksi</option>
                              <option value="1">Sudah Print</option>
                              <option value="2">-</option>
                              <option value="3">Sudah Jahit</option>
                              <option value="4">Siap Kirim</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <label>Agen</label>
                          <select class="form-control select2" name="filteragen" id="filteragen">
                          </select>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label style="color: #ffffff">zzzz</label>
                            <button onclick="refresh()" class="btn btn-success btn-flat btn-block"><i class="fa fa-refresh"></i> Refresh</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
                <div class="row loop-card ">
                  
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
  var path = 'qc';
  var title = 'Quality Control';
  var grupmenu = 'Transaksi';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;

  $(document).ready(function() {
      getAkses(title);
      select2();
      activemenux('transaksi', 'qualitycontrol');
      dpicker();
      setMonth('filterawal',30);
      setMonth('filterakhir',0);
      getSelectcustom('filteragen', 'universe/getcustomer', 'filteragenclass','kode', 'nama')

      $( ".loop-card" ).after(function() {
        getall();
      });

  });

  function refresh() {
    getall();
  }

  function getall() {
      $(".loop-card").after(function() {
          $(".loop-inside").remove()
      });

      $.ajax({
          url: `${apiurl}/getall`,
          type: "POST",
          dataType: "json",
          data: {
              filterawal: $('[name="filterawal"]').val(),
              filterakhir: $('[name="filterakhir"]').val(),
              filterstatus: $('[name="filterstatus"]').val(),
              filteragen: $('[name="filteragen"]').val(),
          },
          success: function(res) {
              $.each(res.data, function(index, v) {
                  let path;
                  if (v.pathimage == null || v.pathimage == '') {
                      path = 'assets/gambar/noimage.png'
                  }
                  let label_a = v.a == "T" ? "Done" : "Wait"
                  let label_b = v.b == "T" ? "Done" : "Wait"
                  let label_c = v.c == "T" ? "Done" : "Wait"
                  let label_d = v.d == "T" ? "Done" : "Wait"
                  let label_e = v.e == "T" ? "Done" : "Wait"

                  let badge_a = v.a == "T" ? "bg-green" : "bg-red"
                  let badge_b = v.b == "T" ? "bg-green" : "bg-red"
                  let badge_c = v.c == "T" ? "bg-green" : "bg-red"
                  let badge_d = v.d == "T" ? "bg-green" : "bg-red"
                  let badge_e = v.e == "T" ? "bg-green" : "bg-red"

                  $(".loop-card").append(`
                    <div class="col-md-3 loop-inside bounceIn animated"><div class="box box-widget widget-user-2"><div class="widget-user-header ${v.status >= 4 ? "bg-green" : "bg-yellow"}">
                    <div class="widget-user-image">
                    <img class="" src="<?php echo base_url() ?>${path}" alt="Img Produk"></div><h5 class="widget-user-desc">${v.kode}</h5><h5 class="widget-user-desc">${v.mbarang_nama}</h5></div>
                    <div class="box-footer no-padding">
                    <ul class="nav nav-stacked">
                      <li><a href="#">Antri Produksi <span class="pull-right badge ${badge_a}">${label_a}</span></a></li>
                      <li><a href="#">Sudah Print <span class="pull-right badge ${badge_b}">${label_b}</span></a></li>
                      <li><a href="#">Sudah Cutting <span class="pull-right badge ${badge_c}">${label_c}</span></a></li>
                      <li><a href="#">Sudah Jahit <span class="pull-right badge ${badge_d}">${label_d}</span></a></li>
                      <li><a href="#">Siap Kirim <span class="pull-right badge ${badge_e}">${label_e}</span></a></li>
                    </ul>
                    </div><div class="box-footer no-padding">
                    <button class="btn btn-success btn-block" ${v.status >= 4 ? "Disabled" : ""} onclick="qc_data(${v.id},${v.status})">${ v.status >= 4 ? "Selesai" : "QC"}</button>
                    </div>
                    </div>
                    </div>`)
              });
          },
          error: function() {
              console.log('error')
          }
      });
  }

  function labelstatus(s) {
      let teks;
      switch (s) {
          case 0:
              teks = "Sudah Print ?";
              break;
          case 1:
              teks = "Sudah Cutting ?";
              break;
          case 2:
              teks = "Sudah Jahit ?";
              break;
          case 3:
              teks = "Siap Kirim ?";
              break;
      }
      return teks;
  }

  function qc_data(id,status) {
      $('.modal-title-konfirmasi').text(labelstatus(status));
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'do_qc(' + id + ')');
  }

  function do_qc(id) {
      $.ajax({
          url: `${apiurl}/do_qc`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  refresh();
                  showNotif('', 'QC Sukses', 'success')
              } else if (data.sukses == 'fail') {
                  refresh();
                  showNotif('', 'QC Error', 'danger')
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