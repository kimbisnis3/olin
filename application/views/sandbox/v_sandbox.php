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
          <div class="modal fade" id="modal-lirik" role="dialog" data-backdrop="static">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body">
                  <p id="lirik-box"></p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <div class="box box-success">
                <div class="box-header">
                  <div class="row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Artist</label>
                        <input type="text" class="form-control" id="artist" onkeyup="getsong()">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Track</label>
                        <input type="text" class="form-control" id="track" onkeyup="getsong()">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label>Entries</label>
                        <select class="form-control select2" id="entries" onchange="getsong()">
                          <option value=""></option>
                          <option value="5">5</option>
                          <option value="10">10</option>
                          <option value="25">25</option>
                          <option value="50">50</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="box box-body" style="max-height: 400px; overflow: auto;">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th width="5%"><button type="button" class="btn btn-sm btn-block"><i class="fa fa-search"></i></button></th>
                        <th><span class="label-header-table">Artist</span><input type="text" class="search-header-table form-control invisible" placeholder="Artist"></th>
                        <th>Track</th>
                        <th>Album</th>
                        <th>Lyrics</th>
                      </tr>
                    </thead>
                    <tbody class="tbodytrack">
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </section>
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
      // getprovince();
      // console.log($unibind.attr('uni-bind-val'));
      load_data()
      $("#entries").val('10').trigger('change')

      
  });

  function getsong() {
    $(".trtrack").remove();
    $.ajax({
          url: 'https://api.musixmatch.com/ws/1.1/track.search',
          type: "GET",
          dataType: "text",
          data : {
            apikey          : 'd8998ca75b7d46df6a305a269c2d2a27',
            format          : 'jsonp',
            callback        : 'callback',
            q_artist        : $("#artist").val(),
            q_track         : $("#track").val(),
            s_artist_rating : 'asc',
            s_track_rating  : 'asc',
            quorum_factor   : '1',
            page_size       : $("#entries").val(),
            page            : '1',
            f_has_lyrics    : '0',
          },
          success: function(data) {
              let b = data.replace(/callback\(/g, '');
              let x = b+'@';
              let z = x.replace(/\);@/g, '')
              let js = (JSON.parse(z))
              let source = js.message.body.track_list
              $.each(source, function(i, v) {
                $(".tbodytrack").append(`
                  <tr class="trtrack  fadeIn animated">
                    <td>${i + 1}.</td>
                    <td>${v.track.artist_name}</td>
                    <td>${v.track.track_name}</td>
                    <td>${v.track.album_name}</td>
                    <td><button type="button" class="btn btn-md btn-block btn-success" onclick="open_lirik(${v.track.track_id}, '${v.track.track_name}')"><i class="fa fa-eye"></i></button></td>
                  </tr>
                  `);
              })
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Error', 'Failed Get Data', 'danger')
          }
      });
  }

  function open_lirik(track_id, track_name) {
    $.ajax({
          url: 'https://api.musixmatch.com/ws/1.1/track.lyrics.get',
          type: "GET",
          dataType: "text",
          data : {
            apikey    : 'd8998ca75b7d46df6a305a269c2d2a27',
            format    : 'jsonp',
            callback  : 'callback',
            track_id  : track_id
          },
          success: function(data) {
              let b = data.replace(/callback\(/g, '');
              let x = b+'@';
              let z = x.replace(/\);@/g, '')
              let js = (JSON.parse(z))
              let source = js.message.body.lyrics
              let lirik = source.lyrics_body.replace(/\n/g, "<br />")
              $('#lirik-box').html(lirik)
              $('#modal-lirik .modal-title').text(track_name)
              $('#modal-lirik').modal('show');
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Error', 'Failed Get Data', 'danger')
          }
      });
  }

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
          if (res.status == "success") {
              console.log(res.data)
              let a = getObject(res.data, '3', 'province_id')
              console.log(a);
          }
      })
  }

  function uniget(u, d, r = function() {}) {
    $.ajax({
          url: u,
          type: "GET",
          dataType: "JSON",
          data : d,
          success: function(data) {
              r(data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Error', 'Failed Get Data', 'danger')
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

  

  </script>
</body>
</html>