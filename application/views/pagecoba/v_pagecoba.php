<?php
$this->load->view('template/head');
$this->load->view('template/topbar');
$this->load->view('template/sidebar');
?>
<div class="content-wrapper" ng-controller="pagecoba">
  <section class="content-header">
    <h1 class="title">
    {{titlepage}}
    </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo site_url(); ?>"><i class="fa fa-dashboard"></i> Home</a>
    </li>
    <li class="active title"><?php echo $title; ?></li>
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
                  <input type="hidden" name="artikel_id">
                  <input type="text" class="form-control" name="artikel_judul" ng-model="input.judul">
                </div>
                <div class="form-group">
                  <label>Artikel</label>
                  <textarea class="form-control" rows="7" name="artikel_artikelx" id="artikelx" ng-model="input.artikel"></textarea>
                </div>
                <div class="form-group" style="display : none;">
                  <label>Artikel</label>
                  <textarea class="form-control" rows="7" name="artikel_artikel" id="artikel" ng-model="input.artikel"></textarea>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" class="form-control" name="artikel_ket" ng-model="input.ket">
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
        <button type="button" id="btnSave" ng-click="addStor()" class="btn btn-primary btn-flat">Simpan</button>
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
          <button type="button" id="btnHapus"  class="btn btn-danger btn-flat">Ya</button>
        </div>
      </div>
    </div>
  </div>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <box class="box-header">
          <button class="btn btn-primary btn-flat" onclick="add_list()" ><i class="fa fa-plus"></i> Tambah</button>
          </box>
          <box class="box-body">
          <ul id="listPlace">
            
          </ul>
          </box>
        </div>
        <div class="box box-info">
          <div class="box-header">
            <button class="btn btn-success btn-flat" ng-click="getdata()"  title="Cek Data"><i class="glyphicon glyphicon-refresh"></i> Refresh</button>
            <button class="btn btn-warning btn-flat" onclick="add_data()"><i class="fa fa-plus"></i> Tambah</button>
          </div>
          <div class="box-body">
            <div class="table-responsive mailbox-messages">
              <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
                <thead>
                  <tr id="repeat">
                    <th>Judul</th>
                    <th>Artikel</th>
                    <th>Ket</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat="s in data">
                    <td>{{s.artikel_judul}}</td>
                    <td>{{s.artikel_artikel}}</td>
                    <td>{{s.artikel_ket}}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
  <?php
  $this->load->view('template/js');
  ?>
<script type="text/javascript">

  app.controller('pagecoba', function($scope, $localStorage, $http, $timeout) {
      $scope.$localStorage = $localStorage;
      $localStorage.formInput = ($localStorage.formInput) ? $localStorage.formInput : [];
      $scope.titlepage = 'Page Coba';

      $scope.getdata = function() {
        $timeout(function() {
            $http({
                  method: 'GET',
                  url: baseUrl + 'pagecoba/setView',
                  params: {}
              })
              .then(function(res) {
                  $scope.data = res.data;
                  console.log($scope.data)
              }, function(err) {
                  console.log(err.data);
              })
        })
    }

      $scope.addStor = function() {
          let obj = {
              judul: $scope.input.judul,
              artikel: "aaaaaa",
              ket: $scope.input.ket,
          }
          $localStorage.formInput.push(obj);
      }

      // $scope.getdata = function() {
      //     $http({
      //             method: 'GET',
      //             url: baseUrl + 'pagecoba/setView',
      //             params: {}
      //         })
      //         .then(function(res) {
      //             $scope.data = res.data;
      //         }, function(err) {
      //             console.log(err.data);
      //         })
      // }
  });

  var LStest = JSON.parse(localStorage.getItem("test"));

  $(document).ready(function() {
      table = $('#table').DataTable({});
    })

  function oke() {
    // $.each(JSON.parse(LStest), function(key, value){
    //     $('#dataloop').append('<td>'+value.artikel_judul+'</td><td>'+value.artikel_ket+'</td>');
    // }); 

    $.each(JSON.parse(LStest), function(key, value){
      $('#dataloop').html('<td>'+value.artikel_judul+'</td><td>'+value.artikel_ket+'</td>');
  });
  }

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function dest() {
    table.destroy();
    
  }

  function cr() {
    table = $('#table').DataTable({
          "data" : LStest,
          "columns": [
              {
                  "data": "artikel_judul"
              },
              {
                  "data": "artikel_artikel"
              }, 
              {
                  "data": "artikel_ket"
              }, 
          ]
      });
  }

  function add_data() {
      save_method = 'add';
      $('#form-data')[0].reset();
      CKEDITOR.instances.artikelx.setData('');

      $('#modal-data').modal('show');
      $('.modal-title').text('Tambahkan Data');
  }

  function savefile() {
      artikel = CKEDITOR.instances['artikelx'].getData();
      $('#artikel').val(artikel);
      let data = {
          artikel_judul: $('[name="artikel_judul"]').val(),
          artikel_artikel: $('[name="artikel_artikel"]').val(),
          artikel_ket: $('[name="artikel_ket"]').val(),
      }
      var test = localStorage.getItem("test");
      var obj = [];
      if (test) {
          obj = JSON.parse(test);
      }
      obj.push(data);
      localStorage.setItem("test", JSON.stringify(obj));
  }

  function add_list() {
      // $('#listPlace').append('<button class="btn btn-success">okeee</button>');

      $('#listPlace').empty('');

      $.each(JSON.parse(LStest), function(key, value){
        $('#listPlace').append('<li>'+value.artikel_judul+'</li>');
      });
  }

</script>
