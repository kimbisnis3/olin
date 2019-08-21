<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper" id="app">
      <?php $this->load->view('_partials/topbar'); ?>
      <?php $this->load->view('_partials/sidebar'); ?>
      <div class="content-wrapper">
        <section class="content-header">
          <h1 class="title">Sandbox</h1>
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
                            <label uni-bind="prov" uni-bind-val="43">Province</label>
                            <select class="form-control select2" id="province" onchange="getcity()">
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>City</label>
                            <select class="form-control select2" id="city">
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Province To</label>
                            <select class="form-control select2" id="provinceto" onchange="getcityto()">
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>City To</label>
                            <select class="form-control select2" id="cityto">
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Berat</label>
                            <input type="number" class="form-control" id="berat">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Kurir</label>
                            <select class="form-control select2" id="kurir" onchange="getprice()">
                              <option value=""></option>
                              <option value="jne">JNE</option>
                              <option value="tiki">TIKI</option>
                              <option value="pos">POS Indonesia</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label>Price</label>
                            <select class="form-control select2" id="price">
                            </select>
                          </div>
                        </div>
                      </div>
                      <div class="row">
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
              </div>
            </div>
          </section>
          <section class="content">
            <div class="row">
              <div class="col-md-12">
                <div class="box box-success">
                  <div class="box box-body">
                    <div id="mapid" style="height: 180px"></div>
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
  var path = 'sandbox';
  var title = 'SandBox';
  var grupmenu = '';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;
  var $unibind = $('[uni-bind="prov"]');
  var $price = $('#price');

  $(function() {
      select2();
      getprovince();
      console.log($unibind.attr('uni-bind-val'));
      load_data()
  });

  function refresh() {
    getprovince()
  }

  function getprovince() {
    getSelectcustom('province','sandbox/request_province','optprovince','province_id', 'province');
    getSelectcustom('provinceto','sandbox/request_province','optprovinceto','province_id', 'province');
  }

  function getcity() {
      if ($('#province').val() != '' || $('#province').val() != null) {
          let idprov = $('#province').val();
          getSelectcustom('city', `sandbox/request_city?province=${idprov}`, 'optcity', 'city_id', 'city_name');
      }
  }

  function getcityto() {
      if ($('#provinceto').val() != '' || $('#provinceto').val() != null) {
          let idprovto = $('#provinceto').val();
          getSelectcustom('cityto', `sandbox/request_city?province=${idprovto}`, 'optcityto', 'city_id', 'city_name');
      }
  }

  function getprice() {
        let origin  = $('#city').val();
        let dest    = $('#cityto').val();
        let berat   = $('#berat').val();
        let kurir   = $('#kurir').val();
        gx('price', `sandbox/request_ongkir?origin=${origin}&destination=${dest}&weight=${berat}&courier=${kurir}`, 'price', 'service', 'service');
  }

  function gx(id, u, classoption, val, caption) {
      $(`#${id}`).select2({
          disabled: true
      });
      $(`#${id}`).after(function() {
          $(`.${classoption}`).remove()
      });
      $(`#${id}`).val('');
      $(`#${id}`).trigger('change');
      $.ajax({
          url: `${php_base_url}${u}`,
          type: "GET",
          dataType: "JSON",
          success: function(data) {
              $(`#${id}`).select2({
                  disabled: false
              });
              inintSelect2(id);
              $(`#${id}`).append(`<option class="${classoption}" value=""></option>`);
              $.each(data, function(i, v) {
                  $(`#${id}`).append(`<option class="${classoption}" value="${v[val]}">${v[caption]}</option>`);
              })
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.log('Error on process');
              $(`#${id}`).select2({
                  disabled: false
              });
          }
      });
  }

  function load_data() {
    uniget('sandbox/req_province/', {}, function(res) {
            console.log(res.data)
    })
  }

  

  function unipost(u, d, r = function() {}) {
    $.ajax({
          url: u,
          type: "GET",
          dataType: "JSON",
          data : d,
          success: function(data) {
              r(data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              console.log('error');
          }
      });
  }

  function star() {
      $.get(`sandbox/request_ongkir`, {
              origin: "64",
              destination: "402",
              weight: "1",
              courier : "jne"

          })
          .done(function(data) {
              console.log(JSON.parse(data));
          });
  }

  function getIndex(arr, val, key = '') {
      if (key == '') {
          var zzz = arr.indexOf(val);
      } else {
          var zzz = arr.findIndex(function(s) {
              return s[key] == val;
          });
      }
      return zzz;
  }

  function getObject(arr, val, key) {
      var zzz = arr.findIndex(function(s) {
          return s[key] == val;
      });
      return arr[zzz];
  }

  function removeObject(arr, val, key) {
      var zzz = arr.findIndex(function(s) {
          return s[key] == val;
      });
      arr.splice(arr.indexOf(arr[zzz]), 1);
      return arr;
  }

  function replaceObject(arr, val, key, newObj) {
      var zzz = arr.findIndex(function(s) {
          return s[key] == val;
      });
      arr[zzz] = newObj;
      return arr[zzz];
  }

  

  </script>
</body>
</html>