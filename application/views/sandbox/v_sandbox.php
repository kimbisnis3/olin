<!DOCTYPE html>
<html>
  <?php $this->load->view('_partials/head'); ?>
  <?php $this->load->view('sandbox/css_sandbox'); ?>
  <style type="text/css">

  </style>
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
        
        <section class="content invisible">
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
                    <!-- <div class="col-md-3">
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
                    </div> -->
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
        <section class="content invisible">
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
            <div class="col-xs-12">
              <div class="box box-info">
                <div class="box-header">
                  <div class="pull-right">
                    <button class="btn btn-md btn-flat btn-merah" type="button">.btn-merah</button>
                    <button class="btn btn-md btn-flat btn-biru" type="button">.btn-biru</button>
                    <button class="btn btn-md btn-flat btn-hijau" type="button">.btn-hijau</button>
                    <button class="btn btn-md btn-flat btn-oren" type="button">.btn-oren</button>
                    <button class="btn btn-md btn-flat btn-kuning" type="button">.btn-kuning</button>
                    <button class="btn btn-md btn-flat btn-hitam" type="button">.btn-hitam</button>
                    <button class="btn btn-md btn-flat btn-pink" type="button">.btn-pink</button>
                    <button class="btn btn-md btn-flat btn-coklat" type="button">.btn-coklat</button>
                    <button class="btn btn-md btn-flat btn-violet" type="button">.btn-violet</button>
                    <button class="btn btn-md btn-flat btn-teal" type="button">.btn-teal</button>
                    <button class="btn btn-md btn-flat btn-olive" type="button">.btn-olive</button>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-info">
                <div class="box-header">
                  <button class="btn btn-md btn-flat btn-primary" type="button" id="btn-submit" onclick="kirimdata()">Kirim</button>
                </div>
                <div class="box-body">
                  <div class="table-responsive mailbox-messages">
                    <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                      <thead>
                        <tr id="repeat">
                          <th width="5%">ID</th>
                          <th>Kode</th>
                          <th>Nama</th>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/store2/2.9.0/store2.min.js" integrity="sha256-YnOC3D/Zcb05gayw4p1Xk7cyoTd1dnzug9+9nCj/AvA=" crossorigin="anonymous"></script>
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
  var dt_data = [];
  var xxx = [];
  // var dt = [];

  $(function() {
      select2();
      // getprovince();
      // console.log($unibind.attr('uni-bind-val'));
      // $("#entries").val('10').trigger('change')
      // console.log($( document ).height())
      $("body").css("height",$( window ).height())
      maindata();
      console.log(xxxz("bbb"))
      loopx()
  });

  const aa = () => {
      unig('https://jsonplaceholder.typicode.com/users', {}, function(res) {
          // $.each(res.data, function(i, v) {
          //     dt_data.push({
          //         'id': v.id,
          //         'kode': v.kode,
          //         'nama': v.nama,
          //     });
          // })
          store.set('sandbox_user', res)
      })
      return store.get('sandbox_user');
  }

  const loopx = () => {
    let x = aa()
    console.log(x)
  }

  // const storedata = () => {

  //     store.set('user', person)
  // }

  function unig(u, d, r = function() {}) {
      // d["clId"] = 'clId';
      // d["areaId"] = 'xxxx';
      $.ajax({
          url: u,
          type: "GET",
          dataType: "JSON",
          data: d,
          // headers: {
          //     'Authorization':'Basic xxxxxxxxxxxxx',
          // },
          success: function(data) {
              r(data);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Error', 'Failed Get Data', 'danger')
          }
      });
  }

  kirimdata = () => {
    let label_old = $('#btn-submit').html();
    cbs('#btn-submit',"start");
    setTimeout(function(){ cbs('#btn-submit',"stop",label_old); }, 3000);
  }

  cbs = (prop, state, label = "Processing") => {
    if (state == "start") {
      $(prop).prop('disabled',true);
      $(prop).html(`<i class="fa fa-spinner fa-spin"></i> ${label}`);
    } else if(state == "stop") {
      $(prop).prop('disabled',false);
      $(prop).html(`${label}`);
    }
  }

  const maindata = () => {
    table = $('#table').DataTable({
          "data": aa(),
          // "ajax": {
          //     "url": `${apiurl}/tes`,
          //     "type": "POST",
          //     "data": {},
          // },
          "columns": [
          { "render" : (data,type,row,meta) => {return meta.row + 1} },
          { "render" : (data,type,row,meta) => {return row.name} },
          { "render" : (data,type,row,meta) => {return row.name} },
          ]
      });
  }

  const ref = () => {
      table.ajax.reload(null, false);
      idx = -1;
  }

  const refx = () => {
      a = aa();
      table.clear().rows.add(a).draw();
  }

  const xxxz = (a) => {
    return a
  }

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