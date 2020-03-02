<script type="text/javascript">
var path = 'po';
var title = 'Purchase Order';
var grupmenu = 'Transaksi';
var apiurl = "<?php echo base_url('') ?>" + path;
var designUrl = "<?php echo lumise_url() ?>" + 'editor.php';
var state;
var idx     = -1;
var table ;
var arr_produk =[];

$(document).ready(function() {
    getAkses(title);
    setMonth('filterawal',30);
    setMonth('filterakhir',0);
    select2();
    activemenux('transaksi', 'purchaseorder');
    dpicker();
    setProvince();
    $('#select-provinsi').select2({ disabled: true });
    $('#select-city').select2({ disabled: true });
    $('#select-city-to').select2({ disabled: true });
    $('#select-service').select2({ disabled: true });
    // $('#filteragen').attr('onchange','refresh()')

    nilaimax('berat',30)
    // nilaimax('jumlah',1)

    table = $('#table').DataTable({
        "processing": true,
        "ajax": {
            "url": `${apiurl}/getall`,
            "type": "POST",
            "data": {
              filterawal  : function() { return $('[name="filterawal"]').val() },
              filterakhir : function() { return $('[name="filterakhir"').val() },
            },
        },
        "columns": [{
            "className": 'details-control',
            "orderable": false,
            "data": null,
            "defaultContent": ''
        },
        { "render" : (data,type,row,meta) => {return meta.row + 1} },
        { "data": "id" , "visible" : false},
        { "data": "kode" },
        { "data": "tgl" },
        { "data": "namacust" , "visible" : false },
        { "data": "mlayanan_nama" },
        { "data": "mkirim_nama" },
        { "data": "noresi" },
        { "data": "bykirim" },
        { "data": "totalall" },
        { "data": "ket" },
        { "data": "statusorder" },
        { "data": "lunas" , "visible" : false },
        { "data": "validasi" , "visible" : false},
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
});

function format(callback, data) {
    $.ajax({
        url: `${apiurl}/getdetail`,
        type: "POST",
        data: {
            xorderkode: data.kode
        },
        success: function(response) {
            callback($(response)).show();
            imgError(image)
        },
        error: function() {
            $('#output').html('Bummer: there was an error!');
        }
    });
}

function previewImage() {
    document.getElementById("image-preview").style.display = "block";
    var oFReader = new FileReader();
    oFReader.readAsDataURL(document.getElementById("image").files[0]);

    oFReader.onload = function(oFREvent) {
        document.getElementById("image-preview").src = oFREvent.target.result;
    };
};

function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#img-preview').remove();
            $('#image-preview').append('<img id="img-preview" src="' + e.target.result + '"/>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function refresh() {
    table.ajax.reload(null, false);
    idx = -1;
}

function refreshfile() {
    tablefile.ajax.reload(null, false);
    idx = -1;
}

function open_cust() {
    $('#modal-customer').modal('show');
    tablecust = $('#table-customer').DataTable({
        "processing": true,
        "destroy": true,
        "ajax": {
            "url": `${apiurl}/loadcustomer`,
            "type": "POST",
            "data": {}
        },
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<button class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
        }],
        "columns": [
          { "data": "no" },
          { "data": "id" , "visible" : false},
          { "data": "kode" , "visible" : false},
          { "data": "nama" },
          { "data": "alamat" },
          { "data": "telp" },
          { "data": "email" },
          { "data": "opsi" },
        ]

    });

    $('#table-customer tbody').on('click', 'button', function() {
        var data = tablecust.row($(this).parents('tr')).data();
        $('[name="ref_cust"]').val(data.kode);
        $('[name="namacust"]').val(data.nama);
        $('#modal-customer').modal('hide');
    });

}

function open_barang() {
    // $('#modal-barang').modal('show');
    tablebarang = $('#table-barang').DataTable({
        "processing": true,
        "destroy": true,
        "lengthMenu": [[5, 10], [5, 10]],
        scrollY:        '400px',
        scrollCollapse: true,
        "ajax": {
            "url": `${apiurl}/loadbrg`,
            "type": "POST",
            "data": {}
        },
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<button type='button' class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
        }],
        "columns": [
          { "data": "no", "visible" : false },
          { "data": "id" , "visible" : false},
          { "data": "kode" , "visible" : false},
          { "data": "nama" },
          { "data": "konv" },
          { "data": "namasatuan" },
          { "data": "harga" },
          { "data": "beratkg", "visible" : false },
          { "data": "ket" },
          { "data": "opsi" },
        ]

    });

    $('#table-barang tbody').on('click', 'button', function() {
        var data = tablebarang.row($(this).parents('tr')).data();
        $('[name="kodebrg"]').val(data.kode);
        $('[name="beratkg"]').val(data.beratkg);
        $('[name="harga"]').val(`${numeral(data.harga).format('0,0')}`);
        $('[name="namabarang"]').val(`${data.nama}`);
        $('#modal-barang').modal('hide');
    });

}

function open_file() {
    xorderkode = table.cell( idx, 3).data();
	validasi = table.cell(idx, 14).data();
    if (idx == -1) {
        return false;
    }
	if (validasi == 't') {
    	showNotif('Fail', 'PO sudah divalidasi!', 'danger')
        return false;
    }

    $('#modal-file').modal('show');
    $('#modal-title').modal('Data File');
    tablefile = $('#table-file').DataTable({
        "processing": true,
        "destroy": true,
        "ajax": {
            "url": `${apiurl}/loadfilelist`,
            "type": "POST",
            "data": {
              xorderkode : xorderkode
            }
        },
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<button id='btn-edit-file' class='btn btn-sm btn-warning btn-flat'><i class='fa fa-pencil'></i></button>"
        }],
        "columns": [
          { "data": "no" },
          { "data": "id" , "visible" : false},
          { "data": "kode" , "visible" : false},
          { "data": "elempathcorel" },
          { "data": "elempathimage" },
          { "data": "pathcorel" , "visible" : false },
          { "data": "pathimage" , "visible" : false },
          { "data": "opsi" },
        ]

    });

    $('#table-file tbody').on('click', '#btn-edit-file', function() {
        var data = tablefile.row($(this).parents('tr')).data();
        $('#form-file')[0].reset();
        $('[name="editpathcorel"]').val(data.pathcorel);
        $('[name="editpathimage"]').val(data.pathimage);
        $('[name="editkodefile"]').val(data.kode);
        $('#modal-input-file').modal('show');
    });

}

function updatefile() {
    var formfile = new FormData($('#form-file')[0])
    $.ajax({
        url: `${apiurl}/updatefile`,
        type: "POST",
        data: formfile,
        dataType: "JSON",
        mimeType: "multipart/form-data",
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
            if (data.sukses == 'success') {
                $('#modal-input-file').modal('hide');
                refreshfile();
                showNotif('Sukses', 'Data Berhasil Diubah', 'success')
            } else if (data.sukses == 'fail') {
                $('#modal-input-file').modal('hide');
                refreshfile();
                showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
            }

        },
        error: function(jqXHR, textStatus, errorThrown) {
            showNotif('Fail', 'Internal Error', 'danger')
        }
    });
}

function add_data() {
    state = 'add';
    clearform();
    $('.btn-save').prop('disabled',false);
    $('.box-upload').removeClass('invisible');
    $('#form-data')[0].reset();
    $('#img-preview').remove();
    $('[name="ref_layanan"]').val('2019000002');
    $('#select-provinsi').val('10'); //set to Jawa Tengah
    setMonth('tgl',0);
    $('.select2').trigger('change');
    $('#modal-data').modal('show');
    $('#modal-data .modal-title').text('Tambah Data');
    tabel_add_barang()
    state_insatuan()
    arr_produk =[]
    reloadbarang();
    clearbarang();
    open_barang()
}

function clearbarang() {
    $('[name="namabarang"]').val('')
    $('[name="kodebrg"]').val('')
    $('[name="jumlah"]').val('')
    $('[name="harga"]').val('')
    $('[name="xorderd_id"]').val('')
    $('#total-harga').html('');
    $('#input-total-harga').val('');
}

function total_harga() {
    let total = _.sumBy(arr_produk, function(o) {
        return parseFloat(o.harga.replace(",", "")) * o.jumlah
    });
    let berat = _.sumBy(arr_produk, function(o) {
      return o.beratkg * o.jumlah
    });
    $('#total-harga').html(numeral(total).format('0,0'));
    $('#input-total-harga').val(total);
    $('[name="berat"]').val(berat);
    let biayaperkilo = getbiayakirim($('[name="serv"]').val());
    $('[name="biaya"]').val(biayaperkilo * berat);
}

function reloadbarang() {
    tableaddbarang.clear().rows.add(arr_produk).draw();
}

function loadpesanan()
{
    $('#modal-pesanan .modall-title').text('Data Pesanan');
    $('#modal-pesanan').modal('show');
    table_pesanan();
}

function add_pesanan(kodebrg, jumlah, xorderd_id, kodeorder)
{
  $.ajax({
      url: `${apiurl}/loadbrgbykode`,
      type: "GET",
      dataType: "JSON",
      data: {
          kodebrg   : kodebrg,
          kodeorder : kodeorder,
      },
      success: function(data) {
        $('[name="kodebrg"]').val(data.barang.kode);
        $('[name="beratkg"]').val(data.barang.beratkg);
        $('[name="harga"]').val(data.barang.harga);
        $('[name="namabarang"]').val(data.barang.nama);
        $('[name="jumlah"]').val(jumlah);
        $('[name="xorderd_id"]').val(xorderd_id);
      	//form
        $('[name="alamat"]').val(data.order.alamat);
        $('[name="telp"]').val(data.order.telp);
        $('[name="ket"]').val(data.order.ket);
        $('[name="kirimke"]').val(data.order.kirimke);
        $('[name="ref_layanan"]').val(data.order.ref_layanan);
        $('[name="ref_layanan"]').trigger('change');
        $('[name="ref_kirim"]').val(data.order.ref_kirim);
        $('[name="ref_kirim"]').trigger('change');
        $('[name="namakirim"]').val(data.order.namakirim);
        $('[name="hpkirim"]').val(data.order.hpkirim);
        $('#modal-pesanan').modal('hide');
      },
      error: function(jqXHR, textStatus, errorThrown) {
          showNotif('Fail', 'Internal Error', 'danger');
      }
  });

}

function table_pesanan()
{
  var _id = [];
  $.each(arr_produk, function( key, value ) {
    // console.log(value['xorderd_id']);
    _id.push(value['xorderd_id'])
  });
  tablepesanan = $('#table-pesanan').DataTable({
      "processing": true,
      "destroy" : true,
      "ajax": {
          "url": `${apiurl}/getpesanan`,
          "type": "POST",
          "data": {
            arr_produk  : function() { return JSON.stringify(_id) },
          },
      },
      "columns": [
      { "data": "no" },
      { "data": "id" , "visible" : false},
      { "data": "kodeorder" },
      { "data": "tgl" },
      { "data": "nama" },
      { "data": "customer_nama" },
      { "data": "jumlah" },
      { "data": "harga" , "visible" : false  },
      { "render" : (data,type,row,meta) => { return `<button type="button" class="btn btn-sm btn-hijau btn-flat" onclick="add_pesanan('${row.kodebrg}','${row.jumlah}','${row.xorderd_id}','${row.kodeorder}')"><i class="fa fa-check"></i></button>` }},
      ]
  });

}

function tabel_add_barang() {
  tableaddbarang = $('#table-add-barang').DataTable({
        "processing": true,
        "paging": false,
        "lengthChange": false,
        "searching": false,
        "ordering": false,
        "info": false,
        "destroy" : true,
        "data": arr_produk,
        "columns": [
        { "render" : (data,type,row,meta) => {return meta.row + 1} },
        { "data": "id" , "visible" : false},
        { "data": "nama" },
        { "data": "jumlah" },
        { "data": "beratkg" },
        { "data": "harga" },
        { "data": "xorderd_id" , "visible" : false   },
        { "render" : (data,type,row,meta) => { return `<button type="button" class="btn btn-sm btn-oren btn-flat" onclick="edit_barang(${meta.row})"><i class="fa fa-pencil"></i></button>
        <button type="button" class="btn btn-sm btn-merah btn-flat" onclick="del_barang(${meta.row},${row.id})"><i class="fa fa-trash"></i></button>` }},
        ]
    });
}

function edit_barang(index) {
  $('[name="id"]').val(arr_produk[index]['id'])
  $('[name="namabarang"]').val(arr_produk[index]['nama'])
  $('[name="kodebrg"]').val(arr_produk[index]['kode'])
  $('[name="jumlah"]').val(arr_produk[index]['jumlah'])
  $('[name="harga"]').val(arr_produk[index]['harga'])
  $('[name="beratkg"]').val(arr_produk[index]['beratkg'])
  state_edsatuan()
  $('#btn-simpan-barang').attr('onclick', 'update_barang(' + index + ')');
  total_harga()
}

function update_barang(index) {
  if (state == 'add') {
    let newval = {
        'id': $('[name="id"]').val(),
        'nama': $('[name="namabarang"]').val(),
        'kode': $('[name="kodebrg"]').val(),
        'jumlah': $('[name="jumlah"]').val(),
        'harga': $('[name="harga"]').val(),
        'beratkg': $('[name="beratkg"]').val(),
        'xorderd_id': $('[name="xorderd_id"]').val(),
    };
    arr_produk[index] = newval;
    reloadbarang()
    // showNotif('', 'Data Diubah', 'success');
    state_insatuan()
    clearbarang()
    total_harga()
  } else if (state == 'update') {
      let label_old = $('#btn-simpan-barang').html();
      cbs('#btn-simpan-barang', "start", "");
      kodeorder = table.cell(idx, 3).data();
      $.ajax({
          url: `${apiurl}/updatebarang`,
          type: "POST",
          dataType: "JSON",
          data: {
              kodeorder: kodeorder,
              id: $('[name="id"]').val(),
              nama: $('[name="namabarang"]').val(),
              kode: $('[name="kodebrg"]').val(),
              jumlah: $('[name="jumlah"]').val(),
              harga: $('[name="harga"]').val(),
              beratkg: $('[name="beratkg"]').val(),
          },
          success: function(data) {
              if (data.sukses == 'success') {
                  arr_produk = data.barang
                  reloadbarang();
                  clearbarang();
                  total_harga()
                  cbs('#btn-simpan-barang', "stop", label_old);
              } else if (data.sukses == 'fail') {
                  reloadbarang();
                  cbs('#btn-simpan-barang', "stop", label_old);
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Fail', 'Internal Error', 'danger');
              cbs('#btn-simpan-barang', "stop", label_old);
          }
      });
  }
}

function add_barang() {
    if (state == 'add') {
        let label_old = $('#btn-tambah-barang').html();
        // cbs('#btn-tambah-barang', "start", "Memuat");
        if (ceknull('namabarang')) {
            return false
        }
        if (ceknull('jumlah')) {
            return false
        }
        if (ceknull('harga')) {
            return false
        }
        arr_produk.push({
            'id': $('[name="id"]').val(),
            'nama': $('[name="namabarang"]').val(),
            'kode': $('[name="kodebrg"]').val(),
            'jumlah': $('[name="jumlah"]').val(),
            'harga': $('[name="harga"]').val(),
            'beratkg': $('[name="beratkg"]').val(),
            'xorderd_id': $('[name="xorderd_id"]').val(),
        });
        reloadbarang();
        clearbarang();
        total_harga()
        // cbs('#btn-tambah-barang', "stop", label_old);
        console.log(arr_produk)
    } else if (state == 'update') {
        let label_old = $('#btn-tambah-barang').html();
        cbs('#btn-tambah-barang', "start", "Memuat");
        kodeorder = table.cell(idx, 3).data();
        $.ajax({
            url: `${apiurl}/addbarang`,
            type: "POST",
            dataType: "JSON",
            data: {
                kodeorder: kodeorder,
                id: $('[name="id"]').val(),
                nama: $('[name="namabarang"]').val(),
                kode: $('[name="kodebrg"]').val(),
                jumlah: $('[name="jumlah"]').val(),
                harga: $('[name="harga"]').val(),
                beratkg: $('[name="beratkg"]').val(),
            },
            success: function(data) {
                if (data.sukses == 'success') {
                    arr_produk = data.barang
                    reloadbarang();
                    clearbarang();
                    total_harga()
                    cbs('#btn-tambah-barang', "stop", label_old);
                } else if (data.sukses == 'fail') {
                    reloadbarang();
                    cbs('#btn-tambah-barang', "stop", label_old);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                showNotif('Fail', 'Internal Error', 'danger');
                cbs('#btn-tambah-barang', "stop", label_old);
            }
        });
    }

}

function del_barang(index, id) {
    if (state == 'add') {
        arr_produk.splice(index, 1);
        reloadbarang()
        state_insatuan()
        total_harga()
    } else if (state == 'update') {
        $.ajax({
            url: `${apiurl}/deletebarang`,
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
                total: $('#input-total-harga').val(),
            },
            success: function(data) {
                if (data.sukses == 'success') {
                    arr_produk.splice(index, 1);
                    total_harga()
                    reloadbarang();
                } else if (data.sukses == 'fail') {
                    reloadbarang();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                showNotif('Fail', 'Internal Error', 'danger');
            }
        });
    }
}

function batal_barang() {
  state_insatuan()
  clearbarang()
  total_harga()
}

function state_edsatuan() {
    $('#btn-tambah-barang').addClass('invisible')
    $('#btn-batal-barang').removeClass('invisible')
    $('#btn-simpan-barang').removeClass('invisible')
}

function state_insatuan() {
    $('#btn-tambah-barang').removeClass('invisible')
    $('#btn-batal-barang').addClass('invisible')
    $('#btn-simpan-barang').addClass('invisible')
}

function edit_data() {
    if (idx == -1) {
        return false;
    }

	statusorder = table.cell(idx, 12).data();
	if (statusorder !== '<span class="label label-warning">Belum Selesai</span>') {
    	showNotif('Fail', 'PO sudah diproses!', 'danger')
        return false;
    }
    arr_produk =[]
    let label_old = $('.edit-btn').html();
    cbs('.edit-btn',"start","Memuat");
    tabel_add_barang()
    state_insatuan()
    // $('#btnSimpan').prop('disabled',true);
    clearbarang()
    kode = table.cell( idx, 3).data();
    $('.box-upload').addClass('invisible');

    state = 'update';
    $('#form-data')[0].reset();
    $('#img-preview').remove();
    $.ajax({
        url: `${apiurl}/edit`,
        type: "POST",
        data: {
            kode: kode,
        },
        dataType: "JSON",
        success: function(data) {
            arr_produk = data.barang
            reloadbarang();
            $('[name="kode"]').val(data.po.kode);
            $('[name="tgl"]').val(data.po.tgl);
            $('[name="ref_kirim"]').val(data.po.ref_kirim);
            $('[name="ref_cust"]').val(data.po.ref_cust);
            $('[name="namacust"]').val(data.po.mcustomer_nama);
            $('[name="ref_layanan"]').val(data.po.ref_layanan);
            $('[name="kirimke"]').val(data.po.kirimke);
            $('[name="ket"]').val(data.po.ket);
            $('[name="total"]').val(data.po.total - data.po.bykirim);
            $('#total-harga').html(data.po.total - data.po.bykirim);
            $('[name="alamat"]').val(data.po.alamat);
            $('[name="telp"]').val(data.po.telp);
            $('[name="berat"]').val(data.po.kgkirim);
            $('[name="provinsi"]').val(data.po.kodeprovfrom);
            $('[name="provinsito"]').val(data.po.kodeprovto);
            $('[name="city"]').val(data.po.kodecityfrom);
            $('[name="ref_bank"]').val(data.po.ref_bank);
            setTimeout(function(){
              $('[name="cityto"]').val(data.po.kodecityto);
              $('[name="kurir"]').val(data.po.kurir);
              $('[name="kurir"]').trigger('change');
              $('[name="cityto"]').trigger('change');
            }, 4000);
            setTimeout(function(){
              $('[name="biaya"]').val(data.po.bykirim);
              $('[name="kodekurir"]').val(data.po.kodekurir);
              $('[name="biaya"], [name="kodekurir"]').trigger('change');
              $('[name="serv"]').val(`@${data.po.kodekurir}@?${data.po.bykirim / data.po.kgkirim}?`);
              $('[name="serv"]').trigger('change');
              $('#btnSimpan').prop('disabled',false);
            }, 5000);
            console.log($('[name="cityto"]').val());
            $('.select2').trigger('change');
            $('#modal-data').modal('show');
            notifLoading();
            $('#modal-data .modal-title').text('Edit Data');
            cbs('.edit-btn',"stop",label_old);
            $('#btnSimpan').prop('disabled',false);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            showNotif('Fail', 'Internal Error', 'danger');
            cbs('.edit-btn',"stop",label_old);
            $('#btnSimpan').prop('disabled',false);
        }
    });
}

function savedata() {
    if (ceknull('tgl')) { return false }
    // if (state == 'add') {
    //   if (ceknull('corel')) { return false }
    // }
    if (ceknull('ref_kirim')) { return false }
    if (ceknull('kirimke')) { return false }
    if (ceknull('ref_layanan')) { return false }
    if (state == 'update' && ($('#ref_kirim').val() == 'GX0002') && ($('#select-service').val() == '' || $('#select-service').val() == null)) {
        showNotif('', 'Pilih Service Kurir', 'danger');
        $('#select-service').focus()
        $('#select-service').addClass('pulse animated');
        return false
    }
    let label_old = $('.btn-save').html();
    cbs('.btn-save',"start","Mengirim");
    $('[name="mask-provinsi"]').val($('[name="provinsi"]  option:selected').html());
    $('[name="mask-city"]').val($('[name="city"]  option:selected').html());
    $('[name="mask-provinsito"]').val($('[name="provinsito"]  option:selected').html());
    $('[name="mask-cityto"]').val($('[name="cityto"]  option:selected').html());
    $('[name="mask-distto"]').val($('[name="distto"] option:selected').html());
    var url;
    if (state == 'add') {
        url = `${apiurl}/savedata`;
    } else {
        url = `${apiurl}/updatedata`;
    }
    $('[name="arr_produk"]').val(JSON.stringify(arr_produk));
    var formData = new FormData($('#form-data')[0]);
    $('.btn-save').prop('disabled',true);
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
                $('.btn-save').prop('disabled',false);
            } else if (data.sukses == 'fail') {
                $('#modal-data').modal('hide');
                refresh();
                showNotif('Sukses', 'Tidak Ada Perubahan', 'success')
                $('.btn-save').prop('disabled',false);
            }
          cbs('.btn-save',"stop",label_old);

        },
        error: function(jqXHR, textStatus, errorThrown) {
            showNotif('Fail', 'Internal Error', 'danger')
            $('.btn-save').prop('disabled',false);
            cbs('.btn-save',"stop",label_old);
        }
    });
}

function hapus_data() {
    id = table.cell( idx, 2).data();
	let validasiValue = table.cell( idx, 13).data();
    if (validasiValue == 't') {
        showNotif('Perhatian', 'Void Tidak Diijinkan', 'warning');
        cbs('.edit-btn',"stop",label_old);
      return false;
    }
    if (idx == -1) {
        return false;
    }
    $('.modal-title').text('Yakin Void Data ?');
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

function unduh_data(dt) {
    window.open("<?php echo site_url('')?>" + dt);
}

function changekirim() {
  let kode = $('#ref_kirim').val();
  let label= $('#ref_kirim option:selected').html();
  if ((kode == 'GX0002') || (label == 'kurir')) {
    $('#box-kurir').removeClass('invisible');
  } else {
    $('#box-kurir').addClass('invisible');
  }
}

function setProvince() {
    $('#select-provinsi').load(`${apiurl}/request_province`, function(){
      console.log('finish')
      $('#select-provinsi').val('10');
      $('#select-provinsi').trigger('change');
    });
    $('#select-provinsi-to').load(`${apiurl}/request_province`, function(){
      console.log('finish')
    });
    return false;
}

function setCity() {
    let id_province = $('#select-provinsi').val();
    $('#select-city').select2({ disabled: true });
    if (id_province.length) {
        $('#select-city').load(`${apiurl}/request_city?province=${id_province}`, function() {
          console.log('finish City');
          $('#select-city').val('445');
          $('#select-city').trigger('change');
          setDist()
        });
    }
    return false;
}

function setCityTo() {
    let id_province = $('#select-provinsi-to').val();
    $('#select-city-to').select2({ disabled: true });
    if (id_province) {
        $('#select-city-to').load(`${apiurl}/request_city?province=${id_province}`, function () {
          console.log('finish City to');
          $('#select-city-to').select2({ disabled: false });
        });
    }
    return false;
}

function setDist() {
    let id_city = $('#select-city').val();
    $('#select-dist').select2({ disabled: true });
    if (id_city.length) {
        $('#select-dist').load(`${apiurl}/request_dist?city=${id_city}`, function() {
          console.log('finish Dist');
          $('#select-dist').val('6164');
          $('#select-dist').trigger('change');
        });
    }
    return false;
}

function setDistTo() {
    let id_city = $('#select-city-to').val();
    $('#select-dist-to').select2({ disabled: true });
    if (id_city) {
        $('#select-dist-to').load(`${apiurl}/request_dist?city=${id_city}`, function () {
          console.log('finish Dist to');
          $('#select-dist-to').select2({ disabled: false });
        });
    }
    return false;
}

function setService() {
    let origin      = $('[name="dist"]').val();
    let destination = $('[name="distto"]').val();
    let weight      = $('[name="berat"]').val();
    let courier     = $('[name="kurir"]').val();
    if ($('#select-kurir').val()) {
      $('#select-service').load(`${apiurl}/request_ongkir?origin=${origin}&destination=${destination}&weight=${weight}&courier=${courier}`, function() {
      console.log('finish Service');
      $('#select-service').select2({ disabled: false });
    });
    }

    $('[name="biaya"]').val($('#select-service').val()) ;
    $('[name="biaya"]').val('');
    $('[name="kodekurir"]').val('');
    return false;
}

function setPrice() {
  let s = $('#select-service').val()
  let berat = $('[name="berat"]').val()
  if (s.length > 0) {
    let b = getbiayakirim(s);
    let k = kodekurir(s);
    $('[name="biaya"]').val(b * Math.ceil(berat));
    $('[name="kodekurir"]').val(k);
    console.log(s);
  }
}

function getbiayakirim(s) {
  if (s) {
    let b = s.match((/\?(.*?)\?/g));
    return parseFloat(b.toString().replace(/\?/g, ''))
  }
}

function kodekurir(s) {
  if (s) {
    let k = s.match((/\@(.*?)\@/g));
    return k.toString().replace(/\@/g, '')
  }
}

function cetak_data() {
    kode = table.cell(idx, 3).data();
    if (idx == -1) {
        return false;
    }
    window.open(`${apiurl}/cetak?kode=${kode}`);
}

function grab_design(product_id, design_id, order_id) {
  window.open(
    `${designUrl}?product_base=${product_id}&design_print=${design_id}&order_print=${order_id}`,
    `_blank`
  );
}



</script>
