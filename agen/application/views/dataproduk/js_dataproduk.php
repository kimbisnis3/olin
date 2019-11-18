<script type="text/javascript">
  var path = 'dataproduk';
  var title = 'Data Produk';
  var grupmenu = 'Master Data';
  var apiurl = "<?php echo base_url('') ?>" + path;
  var state;
  var idx     = -1;
  var table ;
  var tablehargaedit ;
  var sat   = [];
  var arrsat = JSON.stringify(sat);

//   $('.add-btn').removeClass('invisible')
//   $('.edit-btn').removeClass('invisible')
//   $('.delete-btn').removeClass('invisible')
//   $('.option-btn').removeClass('invisible')

  $(document).ready(function() {
      getAkses(title);
      select2();
      
      activemenux('masterdata', 'dataproduk');
      $('[name="filterktg"]').val('GX0001');
      $('[name="filterktg"]').trigger('change');

      table = $('#table').DataTable({
          "processing": true,
          "scrollX": true,
          "ajax": {
              "url": `${apiurl}/getall`,
              "type": "POST",
              "data": {
                // filterktg  : function() { return $('[name="filterktg"]').val() },
              },
          },
          "columns": [
          //data 0 for detail-controls
          { "render" : (data,type,row,meta) => {return "detil"} , "visible" : false },
          { "render" : (data,type,row,meta) => {return meta.row + 1} },
          { "data": "id" , "visible" : false},
          { "data": "kodebarang" , "visible" : true},
          { "data": "idbarang" , "visible" : false},
          { "data": "namabarang" },
          { "data": "konv", "visible" : false },
          { "data": "namasatuan" },
          { "render" : (data,type,row,meta) => { return numeral(row['harga']).format('0,0')} },
          { "data": "ketbarang" },
          { "data": "namadesign" },
          { "data": "kategori_nama" },
          { "render" : (data,type,row,meta) => { return showimage(row['gambardesign'])} },
          { "render" : (data,type,row,meta) => { return showcolor(row['kodewarna'])} },
          { "render" : (data,type,row,meta) => { return row['is_design'] == 't' ? '<span class="label label-success">Custom</span>' : '' }},
          ]
      });

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

    tableharga = $('#table-harga').DataTable({
          "processing": true,
          "paging": false,
          "lengthChange": false,
          "searching": false,
          "ordering": false,
          "info": false,
          "destroy" : true,
          "data": $.parseJSON(arrsat),
          "columnDefs": [{
              "targets": -1,
              "data": null,
              "defaultContent": "<button class='btn btn-sm btn-danger btn-flat'><i class='fa fa-trash'></i></button>"
          }],
          "columns": [
          { "data": "konv" },
          { "data": "satuan" },
          { "data": "harga" },
          { "data": "harga1" },
          { "data": "minorder" },
          { "data": "beratkg" },
          { "data": "ketsatuan" },
          { "data": "deflabel" },
          { "data": "btn"}
          ]
      });

      $('#table-harga tbody').on( 'click', 'button', function () {
        var data = tableharga.row( $(this).parents('tr') ).data();
        let i = _.findIndex(sat, { 
          'konv'  : data.konv, 
          'satuan': data.satuan,
          'beratkg': data.beratkg,
          'harga' : data.harga 
        });
        sat.splice(i, 1);
        console.log(sat);
        reloadharga();
    } );
  });

  function format(callback, data) {
      barloading(1)
      $.ajax({
          url: `${apiurl}/getdetail`,
          type: "POST",
          data: {
              kodebarang: data.kodebarang
          },
          success: function(response) {
              callback($(response)).show();
              barloading(0)
          },
          error: function() {
              $('#output').html('Bummer: there was an error!');
              barloading(0)
          }
      });
  }

  function refresh() {
      table.ajax.reload(null, false);
      idx = -1;
  }

  function refreshimage() {
      tbgambar.ajax.reload(null, false);
  }

  function image_data() 
  {
    kode = table.cell( idx, 3).data();
    if (idx == -1) {
          return false;
    }
    tbgambar = $('#tbgambar').DataTable({
          "processing": true,
          "scrollX": true,
          "destroy" : true,
          "ajax": {
              "url": `${apiurl}/getimage`,
              "type": "POST",
              "data": {
                kode : kode
              },
          },
          "columns": [
          { "render" : (data,type,row,meta) => { return meta.row + 1} },
          { "render" : (data,type,row,meta) => { return showimage(row['image'])} },
          { "render" : (data,type,row,meta) => { return `<button class="btn btn-sm btn-merah btn-flat" onclick="del_image('${row['id']}')"><i class="fa fa-trash"></i></button>` } },
          ]
      });
      $('#modal-gambar').modal('show');
      $('#modal-gambar .modal-title').text('Gambar');
  }

  function add_image() 
  {
        kode = table.cell( idx, 3).data();
        $('#form-gambar')[0].reset();
        $('#kodebarang').val(kode);
        $('#modal-add-gambar').modal('show');
        $('#modal-add-gambar .modal-title').text('Tambah Data');
  }

  function saveimage() {
      var formData = new FormData($('#form-gambar')[0]);
      $.ajax({
          url: `${apiurl}/saveimage`,
          type: "POST",
          data: formData,
          dataType: "JSON",
          mimeType: "multipart/form-data",
          contentType: false,
          cache: false,
          processData: false,
          success: function(data) {
              if (data.sukses == 'success') {
                  $('#modal-add-gambar').modal('hide');
                  refreshimage();
                  state == 'add' ? showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success') : showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-add-gambar').modal('hide');
                  refreshimage();
                  showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
              }

          },
          error: function(jqXHR, textStatus, errorThrown) {
              alert('Error on process');
          }
      });
  }

  function del_image(id) {
      $.ajax({
          url: `${apiurl}/delimage`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
            showNotif('Sukses', 'Data Berhasil Dihapus', 'success')
            refreshimage();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function add_harga() {
      if (state == 'add') {
        let defvalue;
        let deflabel;
        if (sat.filter(st => st.konv == '1').length && $('[name="konv"]').val() == '1') {
            showNotif('Warning', 'Konv 1 Sudah Ada', 'warning')
        } else {
          if ($('[name="konv"]').val() == '1') {
            defvalue = 't'
            deflabel = '<span class="label label-success">Default</span>'
          } else {
            defvalue = ''
            deflabel = ''
          }
            sat.push({
                'konv': $('[name="konv"]').val(),
                'harga': $('[name="harga"]').val(),
                'beratkg': $('[name="beratkg"]').val(),
                'ref_sat': $('[name="ref_sat"]').val(),
                'satuan': $('[name="ref_sat"] option:selected').html(),
                'ketsatuan': $('[name="ketsatuan"]').val(),
                'harga1': $('[name="harga1"]').val(),
                'minorder': $('[name="minorder"]').val(),
                'def': defvalue,
                'deflabel': deflabel,
            });
            reloadharga();
            clearformsat()
        }
        
        
      } else if (state == 'update') {
        if (ceknull('konv')) { return false }
        if (ceknull('harga')) { return false }
        if (ceknull('ref_sat')) { return false }
        if (ceknull('ket')) { return false }
        param = {
          'ref_brg': $('[name="kode"]').val(),
          'konv': $('[name="konv"]').val(),
          'harga': $('[name="harga"]').val(),
          'beratkg': $('[name="beratkg"]').val(),
          'ref_sat': $('[name="ref_sat"]').val(),
          'def': '',
          'harga1': $('[name="harga1"]').val(),
          'minorder': $('[name="minorder"]').val(),
          'ketsatuan': $('[name="ketsatuan"]').val()
          
        }
        unipost(`${apiurl}/addharga`, param, function(res) {
            if (res.sukses == "success") {
                clearformsat()
                state_insatuan()
                tablehargaedit.ajax.reload(null, false);
                refresh();
                showNotif('Sukses', 'Data Harga Berhasil Ditambahkan', 'success')
            }
        })
      }
  }

  function edit_harga(id) {
      Pace.restart();
      unipost(`${apiurl}/editharga`, { id : id }, function(data) {
          $('[name="konv"]').val(data.konv);
          $('[name="idsatuan"]').val(id);
          $('[name="harga"]').val(data.harga);
          $('[name="beratkg"]').val(data.beratkg);
          $('[name="ref_sat"]').val(data.ref_sat);
          $('[name="ketsatuan"]').val(data.ket);
          $('[name="harga1"]').val(data.harga1);
          $('[name="minorder"]').val(data.minorder);
          $('.select2').trigger('change');
      })
      state_edsatuan();
  }

  function batal_harga() {
      state_insatuan()
      clearformsat()
  }

  function simpan_harga() {
      param = {
          'id': $('[name="idsatuan"]').val(),
          'konv': $('[name="konv"]').val(),
          'harga': $('[name="harga"]').val(),
          'beratkg': $('[name="beratkg"]').val(),
          'ref_sat': $('[name="ref_sat"]').val(),
          'harga1': $('[name="harga1"]').val(),
          'minorder': $('[name="minorder"]').val(),
          'ketsatuan': $('[name="ketsatuan"]').val()
      }
      unipost(`${apiurl}/updateharga`, param, function(res) {
          if (res.sukses == "success") {
              clearformsat()
              state_insatuan()
              tablehargaedit.ajax.reload(null, false);
              showNotif('Sukses', 'Data Harga Berhasil Ditambahkan', 'success')
          }
      })
  }

  function reloadharga() {
      a = JSON.stringify(sat);
      tableharga.clear().rows.add($.parseJSON(a)).draw();
  }

  function clearformsat() {
      $('[name="konv"]').val('');
      $('[name="harga"]').val('');
      $('[name="beratkg"]').val('');
      $('[name="ref_sat"]').val('');
      $('[name="ketsatuan"]').val('');
      $('[name="harga1"]').val('');
      $('[name="minorder"]').val('');
      $('.select2').trigger('change');
  }

  function state_edsatuan() {
      $('#btn-tambah-harga').addClass('invisible')
      $('#btn-batal-harga').removeClass('invisible')
      $('#btn-simpan-harga').removeClass('invisible')
  }

  function state_insatuan() {
      $('#btn-tambah-harga').removeClass('invisible')
      $('#btn-batal-harga').addClass('invisible')
      $('#btn-simpan-harga').addClass('invisible')
  }

  function add_data() {
      state = 'add';
      sat   = [];
      reloadharga()
      $('#form-data')[0].reset();
      clearformsat()
      $('.box-table-harga-edit').addClass('invisible');
      $('.box-table-harga').removeClass('invisible');
      $('.select2').trigger('change');
      $('#modal-data').modal('show');
      $('.select2').trigger('change');
      $('.modal-title').text('Tambah Data');
      state_insatuan()
  }

  function edit_data() {
      kode = table.cell( idx, 3).data();
      let label_old = $('.edit-btn').html();
      cbs('.edit-btn',"start","Memuat");
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
              //barang
              $('[name="idbarang"]').val(data.barang.id);
              $('[name="nama"]').val(data.barang.nama);
              $('[name="ket"]').val(data.barang.ket);
              $('[name="bahan"]').val(data.barang.bahan);
              $('[name="dimensi"]').val(data.barang.dimensi);
              $('[name="kapasitas"]').val(data.barang.kapasitas);
              $('[name="ref_ktg"]').val(data.barang.ref_ktg);
              $('[name="kode"]').val(data.barang.kode);

              //spek barang
              if (data.spek) {
                $('[name="model"]').val(data.spek.model);
                $('[name="warna"]').val(data.spek.warna);
                $('[name="ketspek"]').val(data.spek.ket); 
              }

              //detail satuan barang
              // sat = data.harga;
              // reloadharga();
              $('.box-table-harga').addClass('invisible');
              $('.box-table-harga-edit').removeClass('invisible');
              state_insatuan();
              tablehargaedit = $('#table-harga-edit').DataTable({
                  "processing": true,
                  "destroy" : true,
                  "ajax": {
                      "url": `${apiurl}/getdetailharga`,
                      "type": "POST",
                      "data": {
                        kodebarang : data.barang.kode
                      },
                  },
                  "columns": [
                  { "data": "id" , "visible" : false},
                  { "data": "konv" },
                  { "data": "namasatuan" },
                  { "data": "harga" },
                  { "data": "harga1" },
                  { "data": "minorder" },
                  { "data": "beratkg" },
                  { "data": "ket" },
                  { "data": "def" },
                  { "data": "btn" },
                  ]
              });

              $('#table-harga-edit tbody').on( 'click', '#hapussat', function () {
                var data = tablehargaedit.row( $(this).parents('tr') ).data();
                hapus_harga(data.id);
              } );
              $('.select2').trigger('change');
              $('#modal-data').modal('show');
              $('#modal-data .modal-title').text('Edit Data');
              cbs('.edit-btn',"stop",label_old);
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
              cbs('#edit-btn',"stop",label_old);
          }
      });
  }

  function savedata() {
      if (ceknull('nama')) { return false }
      // if (ceknull('ket')) { return false }
      var url;
      if (state == 'add') {
          url = `${apiurl}/savedata`;
      } else {
          url = `${apiurl}/updatedata`;
      }
      $.ajax({
          url: url,
          type: "POST",
          data: {
            idbarang    : $('[name="idbarang"]').val(),
            kode        : $('[name="kode"]').val(),
            idsatbarang : $('[name="idsatbarang"]').val(),
            nama        : $('[name="nama"]').val(),
            ket         : $('[name="ket"]').val(),
            bahan       : $('[name="bahan"]').val(),
            dimensi     : $('[name="dimensi"]').val(),
            kapasitas   : $('[name="kapasitas"]').val(),
            ref_ktg     : $('[name="ref_ktg"]').val(),
            ref_gud     : $('[name="ref_gud"]').val(),

            model       : $('[name="model"]').val(),
            warna       : $('[name="warna"]').val(),
            ketspek     : $('[name="ketspek"]').val(),

            arrHarga    : JSON.stringify(sat)
          },
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

  function open_komponen() {
      kode = table.cell( idx, 3).data();
      nama = table.cell( idx, 5).data();
      if (idx == -1) {
          return false;
      }
      tbkomponen = $('#tbkomponen').DataTable({
          "processing": true,
          "destroy": true,
          scrollY : '50vh',
          scrollCollapse: true,
          "ajax": {
              "url": `${apiurl}/getkomponen`,
              "type": "POST",
              "data": {
                  kode: kode
              },
          },
           "columns": [
              { "render" : (data,type,row,meta) => {return meta.row + 1} },
              { "data": "id" , "visible" : false},
              { "data": "kodebarang" , "visible" : true},
              { "data": "idbarang" , "visible" : false},
              { "data": "namabarang" },
              { "data": "konv", "visible" : false },
              { "data": "namasatuan" },
              { "render" : (data,type,row,meta) => { return numeral(row['harga']).format('0,0')} },
              { "data": "ketbarang" },
              { "data": "namadesign"  , "visible" : true},
              { "render" : (data,type,row,meta) => { return showimage(row['gambardesign'])}  , "visible" : true},
              { "render" : (data,type,row,meta) => { return showcolor(row['kodewarna'])}  , "visible" : true},
              { "render" : (data,type,row,meta) => { return `<button class="btn btn-sm btn-merah btn-flat" onclick="del_komponen(${row['mbarangd_id']})"><i class="fa fa-trash"></i></button>` }},
              ]
      });
      $('#modal-komponen').modal('show');
      $('#modal-komponen .modal-title').html("Komponen "+nama);
  }

  function add_komponen() {
      let label_old = $('#btn-tambah-komponen').html();
      cbs('#btn-tambah-komponen',"start","Menyimpan");
      param = {
        ref_brgp  : $('#select-komponen').val(),
        ref_brg   : kode,
      }
      $.ajax({
          url: `${apiurl}/addkomponen`,
          type: "POST",
          dataType: "JSON",
          data: {
              ref_brgp  : $('#select-komponen').val(),
              ref_brg   : kode,
          },
          success: function(data) {
              if (data.sukses == 'success') {
                  $('#select-komponen').val('');
                  $('#select-komponen').trigger('change');
                  cbs('#btn-tambah-komponen',"stop",label_old)
                  tbkomponen.ajax.reload(null, false);
                  showNotif('Sukses', 'Data Berhasil Ditambahkan', 'success')
              } else if (data.sukses == 'fail') {
                  tablehargaedit.ajax.reload(null, false);
                  cbs('#btn-tambah-komponen',"stop",label_old)
                  showNotif('Gagal', 'Data Gagal Diubah', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function del_komponen(id) {
    $.ajax({
          url: `${apiurl}/delkomponen`,
          type: "POST",
          dataType: "JSON",
          data: {
              id : id,
          },
          success: function(data) {
              if (data.sukses == 'success') {
                  tbkomponen.ajax.reload(null, false);
                  showNotif('Sukses', 'Data Berhasil Dihapus', 'success')
              } else if (data.sukses == 'fail') {
                  tbkomponen.ajax.reload(null, false);
                  showNotif('Gagal', 'Data Gagal Dihapus', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function custom_data() {
      //id barang
      id = table.cell( idx, 4).data();
      if (idx == -1) {
          return false;
      }
      $('.modal-title').text('Ubah Tipe Produk ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'do_custom_data(' + id + ')');
  }

  function do_custom_data(id) {
      $.ajax({
          url: `${apiurl}/custom_data`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  table.ajax.reload(null, false);
                  showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-konfirmasi').modal('hide');
                  showNotif('Gagal', 'Data Gagal Diubah', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function default_data(id) {
      $('.modal-title').text('Default Produk ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'do_default_data(' + id + ')');
  }

  function do_default_data(id) {
      $.ajax({
          url: `${apiurl}/default_data`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  tablehargaedit.ajax.reload(null, false);
                  table.ajax.reload(null, false);
                  showNotif('Sukses', 'Data Berhasil Diubah', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-konfirmasi').modal('hide');
                  tablehargaedit.ajax.reload(null, false);
                  showNotif('Gagal', 'Data Gagal Diubah', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
          }
      });
  }

  function hapus_data() {
      idbarang = table.cell( idx, 4).data();
      if (idx == -1) {
          return false;
      }
      $('.modal-title').text('Yakin Hapus Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'delete_data(' + idbarang + ')');
  }

  function delete_data(idbarang) {
      $.ajax({
          url: `${apiurl}/deletedata`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: idbarang,
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

  function hapus_harga(id) {
      $('.modal-title').text('Yakin Hapus Data ?');
      $('#modal-konfirmasi').modal('show');
      $('#btnHapus').attr('onclick', 'delete_harga(' + id + ')');
  }

  function delete_harga(id) {
      $.ajax({
          url: `${apiurl}/deleteharga`,
          type: "POST",
          dataType: "JSON",
          data: {
              id: id,
          },
          success: function(data) {
              $('#modal-konfirmasi').modal('hide');
              if (data.sukses == 'success') {
                  tablehargaedit.ajax.reload(null, false);
                  showNotif('Sukses', 'Data Harga Berhasil Dihapus', 'success')
              } else if (data.sukses == 'fail') {
                  $('#modal-konfirmasi').modal('hide');
                  refresh();
                  showNotif('Gagal', 'Data Harga Gagal Dihapus', 'danger')
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              $('#modal-konfirmasi').modal('hide');
              showNotif('Gagal', 'Barang Sudah Digunakan', 'danger');
          }
      });
  }

  </script>