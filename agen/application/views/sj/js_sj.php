<script type="text/javascript">
var path = 'sj';
var title = 'Surat Jalan ';
var grupmenu = 'Store';
var apiurl = "<?php echo base_url('') ?>" + path;
var state;
var idx     = -1;
var table ;

$(document).ready(function() {
    // getAkses(title);
    select2();
    activemenux('store', 'suratjalan');
    dpicker();
    setMonth('filterawal',30);
    setMonth('filterakhir',0);

    table = $('#table').DataTable({
        "processing": true,
        "createdRow": function( row, data, dataIndex )
        {
          if ( data.posted == "t" ) {
            $(row).addClass('uni-green');
          }else {
            $(row).addClass('uni-red');
          }
        },
        "ajax": {
            "url": `${apiurl}/getall`,
            "type": "POST",
            "data": {
              filterawal  : function() { return $('[name="filterawal"]').val() },
              filterakhir : function() { return $('[name="filterakhir"').val() }
            },
        },
        "columns": [{
            "className": 'details-control',
            "orderable": false,
            "data": null,
            "defaultContent": ''
        },
        { "data": "id" , "note" : "num" },
        { "data": "id" , "visible" : false},
        { "data": "kode" , "visible" : false},
        { "data": "posted" , "visible" : false},
        { "data": "tgl" },
        { "data": "tglkirim" },
        { "data": "mcustomer_nama" },
        { "data": "kirim" },
        { "data": "kgkirim" },
        { "data": "kurir" },
        { "data": "lokasike" },
        { "data": "biayakirim" },
        { "data": "telp" },
        { "data": "ket" },
        { "render" : (data,type,row,meta) => { return row['posted'] == 't' ? '<span class="label label-success"><i class="fa fa-check"></i></span>' : '' }},
        ]
    });

  table.on( 'order.dt search.dt', function () {
      table.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  } ).draw();

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
            kodesj: data.kode
        },
        success: function(response) {
            callback($(response)).show();
        },
        error: function() {
            $('#output').html('Bummer: there was an error!');
        }
    });
}

function open_proc() {
    $('#modal-proc').modal('show');
    tableproc = $('#table-proc').DataTable({
        "processing": true,
        "destroy": true,
        "ajax": {
            "url": `${apiurl}/getproc`,
            "type": "POST",
            "data": {}
        },
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": "<button id='pilih-data' class='btn btn-sm btn-success btn-flat'><i class='fa fa-check'></i></button>"
        }],
        "columns": [
          { "data": "id" },
          { "data": "id" , "visible" : false},
          { "data": "kode" , "visible" : false},
          { "data": "ref_cust" , "visible" : false},
          { "data": "bykirim" , "visible" : false},
          { "data": "kirimke" , "visible" : false},
          { "data": "alamat" , "visible" : false},
          { "data": "kurir" , "visible" : false},
          { "data": "mcustomer_nama" , "visible" : false},
          { "data": "tgl" },
          { "data": "status" },
          { "data": "ket" },
          { "data": "opsi" },
        ]

    });

    tableproc.on( 'order.dt search.dt', function () {
        tableproc.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();

    $('#table-proc tbody').on('click', '#pilih-data', function() {
        var data = tableproc.row($(this).parents('tr')).data();
        $('[name="ref_cust"]').val(data.ref_cust);
        $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
        $('[name="ref_order"]').val(data.kode);
        $('[name="biayakirim"]').val(data.bykirim);
        $('[name="kirim"]').val(data.kirimke);
        $('[name="alamat"]').val(data.alamat);
        $('[name="kurir"]').val(data.kurir);
        $('[name="kodekurir"]').val(data.kodekurir);
        $('#modal-proc').modal('hide');
    });

}

function refresh() {
    table.ajax.reload(null, false);
    idx = -1;
}

function add_data() {
    state = 'add';
    clearform();
    $('#form-data')[0].reset();
    setMonth('tgl',0);
    $('.select2').trigger('change');
    $('#modal-data').modal('show');
    $('.modal-title').text('Tambah Data');
}

function edit_data() {
    kode = table.cell( idx, 3).data();
    let validasiValue = table.cell( idx, 4).data();
    if (validasiValue == 't') {
      showNotif('Perhatian', 'Data Sudah Tervalidasi', 'warning')
      return false;
    }
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
            $('[name="kode"]').val(data.kode);
            $('[name="ref_cust"]').val(data.ref_cust);
            $('[name="ref_order"]').val(data.ref_order);
            $('[name="mcustomer_nama"]').val(data.mcustomer_nama);
            $('[name="tgl"]').val(data.tgl);
            $('[name="tglkirim"]').val(data.tglkirim);
            $('[name="biayakirim"]').val(data.biayakirim);
            $('[name="pic"]').val(data.pic);
            $('[name="kirim"]').val(data.kirim);
            $('[name="ket"]').val(data.ket);
            $('[name="noresi"]').val(data.noresi);
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
    if (ceknull('ref_order')) { return false }
    if (ceknull('mcustomer_nama')) { return false }
    if (ceknull('kirim')) { return false }
    if (ceknull('biayakirim')) { return false }
    if (ceknull('tgl')) { return false }
    if (ceknull('tglkirim')) { return false }
    if (ceknull('pic')) { return false }

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

function valid_data() {
    kode = table.cell(idx, 3).data();
    if (idx == -1) {
        return false;
    }
    let validasiValue = table.cell(idx, 4).data();
    if (validasiValue == 't') {
        showNotif('Perhatian', 'Data Sudah Tervalidasi', 'warning')
        return false;
    }
    $.ajax({
        url: `${apiurl}/ceklunas`,
        type: "POST",
        dataType: "JSON",
        data: {
            kode: kode,
        },
        success: function(data) {
            if (data.lunas == 'L') {
                $('.modal-title').text('Validasi Data ?');
                $('#modal-konfirmasi').modal('show');
                $('#btnHapus').attr('onclick', `validation_data('${kode}')`);
            } else {
                showNotif('Perhatian', 'Pembayaran Belum Lunas ', 'warning')
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            showNotif('Fail', 'Internal Error', 'danger');
        }
    });

}

function validation_data(kode) {
    $.ajax({
        url: `${apiurl}/validdata`,
        type: "POST",
        dataType: "JSON",
        data: {
            kode: kode,
        },
        success: function(data) {
            if (data.sukses == 'success') {
                refresh();
                showNotif('Sukses', 'Data Berhasil di Validasi', 'success')
                $('#modal-konfirmasi').modal('hide');
            } else if (data.sukses == 'fail') {
                refresh();
                showNotif('Gagal', 'Data Gagal di Validasi', 'danger')
                $('#modal-konfirmasi').modal('hide');
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            showNotif('Fail', 'Internal Error', 'danger');
        }
    });
}


function void_data() {
    id = table.cell( idx, 2).data();
    if (idx == -1) {
        return false;
    }
    $('.modal-title').text('Yakin Void Data ?');
    $('#modal-konfirmasi').modal('show');
    $('#btnHapus').attr('onclick', 'do_void_data(' + id + ')');
}

function do_void_data(id) {
    $.ajax({
        url: `${apiurl}/voiddata`,
        type: "POST",
        dataType: "JSON",
        data: {
            id: id,
        },
        success: function(data) {
            $('#modal-konfirmasi').modal('hide');
            if (data.sukses == 'success') {
                refresh();
                showNotif('Sukses', 'Data Berhasil Divoid', 'success')
            } else if (data.sukses == 'fail') {
                $('#modal-data').modal('hide');
                refresh();
                showNotif('Gagal', 'Data Gagal Divoid', 'danger')
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            showNotif('Fail', 'Internal Error', 'danger');
        }
    });
}

function cetak_data() {
    kode = table.cell(idx, 3).data();
    if (idx == -1) {
        return false;
    }
    window.open(`${apiurl}/cetak?kode=${kode}`);
}

</script>
