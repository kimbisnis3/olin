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
                <center><h4 class="modal-title">QC Data ?</h4></center>
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
              <!-- <div class="row">
                <div class="col-xs-12">
                  <div class="box box-info">
                    <div class="box-body">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Awal</label>
                            <input type="text" class="form-control datepicker" v-model="tglAwal">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Akhir</label>
                            <input type="text" class="form-control datepicker" v-model="tglAkhir">
                          </div>
                        </div>
                        <div class="col-md-2">
                          <div class="form-group">
                            <label style="color: #ffffff">zzzz</label>
                            <button @Click="refreshList" class="btn btn-success btn-flat btn-block"><i class="fa fa-refresh"></i> Refresh</button>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div> -->
                <div class="row">
                  <div class="col-md-3" v-for="item in maindata">
                    <div class="box box-widget widget-user-2">
                      <div class="widget-user-header bg-yellow">
                        <div class="widget-user-image">
                          <img class="img-circle" :src="item.pathimage" alt="Img Produk">
                        </div>
                        <h4 class="widget-user-desc">{{ item.xorder_kode }}</h4>
                        <h5 class="widget-user-desc">{{ item.mbarang_nama }}</h5>
                      </div>
                      <div class="box-footer no-padding">
                        <ul class="nav nav-stacked">
                          <li><a href="#">Antri Produksi <span  class="pull-right badge" :class="item.a ==  'T' ? 'bg-green' : 'bg-red'">{{ item.a == 'T' ? selesai : noselesai }}</span></a>
                          </li>
                          <li><a href="#">Sudah Print <span  class="pull-right badge" :class="item.b ==  'T' ? 'bg-green' : 'bg-red'">{{ item.b == 'T' ? selesai : noselesai }}</span></a>
                          </li>
                          <li><a href="#">---- <span  class="pull-right badge" :class="item.c ==  'T' ? 'bg-green' : 'bg-red'">{{ item.c == 'T' ? selesai : noselesai }}</span></a>
                          </li>
                          <li><a href="#">Sudah Jahit <span  class="pull-right badge" :class="item.d ==  'T' ? 'bg-green' : 'bg-red'">{{ item.d == 'T' ? selesai : noselesai }}</span></a>
                          </li>
                          <li><a href="#">Siap Kirim<span  class="pull-right badge" :class="item.e ==  'T' ? 'bg-green' : 'bg-red'">{{ item.e == 'T' ? selesai : noselesai }}</span></a>
                          </li>
                        </ul>
                      </div>
                      <div class="box-footer no-padding">
                        <button class="btn btn-success btn-block" @click="ask_qc(item.id)" :disabled="item.status >= 4">{{ item.status >= '4' ? 'Selesai' : 'QC'}}</button>
                      </div>
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
  <script type="text/javascript" src="<?php echo base_url() ?>assets/vue.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url() ?>assets/axios.min.js"></script>
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
      // setMonth('filterawal',30);
      // setMonth('filterakhir',0);
  });

  var app = new Vue({
      el: '#app',
      data: {
          input: {},
          maindata: [],
          state: 'view',
          selesai : 'OK',
          noselesai : 'WAIT',
          id_qc:'',
          // tglAwal:'',
          // tglAkhir: ''
      },
      methods: {
          getall: function() {
              axios.get(`${apiurl}/getall?awal=${this.tglAwal}&akhir=${this.tglAkhir}`)
                  .then(res => {
                      this.maindata = res.data.data
                  })
                  .catch(e => {
                      this.errors.push(e)
                  })
          },
          ask_qc: function(id) {
            $('#modal-konfirmasi').modal('show');
            this.id_qc = id;
          },
          do_qc: function() {
              axios
                  .get(`${apiurl}/do_qc?id=${this.id_qc}`)
                  .then(res => {
                      if (res.data.sukses == "success") {
                          $('#modal-konfirmasi').modal('hide');
                          showNotif('Sukses', 'QC Sukses', 'success');
                          this.id_qc = '';
                          this.getall()
                      }
                  })
                  .catch(e => {
                      this.errors.push(e)
                  })
          },
          editData: function(id) {
              this.state = 'edit'
              this.titleModal = 'Edit Data';
              axios.get(`${url}/getrow/${id}`)
                  .then(res => {
                      this.input = res.data
                      $('#modal-data').modal('show')
                      console.log(this.state)
                  })
                  .catch(e => {
                      this.errors.push(e)
                  })
          },
          refreshList : function() {
            this.getall();
          }
      },
      created() {
          this.refreshList();
      }
  })

  </script>
</body>
</html>