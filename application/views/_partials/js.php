<div class="control-sidebar-bg"></div>
<script src="<?php echo base_url()?>assets/lte/plugins/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/dist/js/demo_custom.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/notify/bootstrap-notify.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/ajaxupload/jquery.ajaxfileupload.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/pace/pace.js"></script>
<script src="<?php echo base_url()?>assets/numeral.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/moment/moment.js"></script>
<script type="text/javascript">

	var php_base_url = '<?php echo base_url() ?>';
	var php_session_nama = '<?php echo $this->session->userdata("nama") ?>';
	var php_session_id = '<?php echo $this->session->userdata("id") ?>';
	var id_action ;

	$(document).ready(function() {
      // activemenux(grupmenu.toLowerCase(), title.replace(/ /g, "").toLowerCase());
      $('.fa-refresh').addClass('fa-spin');
      $('.btn-act').prop('disabled',true);
      Pace.on('done', function() {
          $('.btn-act').prop('disabled',false);
          $('.fa-refresh').removeClass('fa-spin');
      });
    $("img").on('error', function(){
   		$(this).prop('src',`${php_base_url}assets/gambar/noimage.png`) 
	});

	})

	function setMonth(name, days, tipe = '') {
		if ((tipe == 'min') || ( tipe == '')) {
			let date = moment().subtract(days, 'days').format("DD MMM YYYY");
			$('[name="'+name+'"]').val(date)
		} else if(tipe == 'plus') {
			let date = moment().add(days, 'days').format("DD MMM YYYY");
			$('[name="'+name+'"]').val(date)
		}
	}

	function nilaimax(id, max) {
	    $('#' + id).keyup(function() {
	        if (parseInt($('#' + id).val()) > max) {
	            $('#' + id).trigger('contentchanged');
	        }
	    });

	    $('#' + id).bind('contentchanged', function(e) {
	        $('#' + id).val(max)
	    });
	}

	$(function() {
	    if ($('#artikelx').length) {
	        CKEDITOR.replace('artikelx')
	    }
	})

	function dpicker() {
	    $('.datepicker').datepicker({
	        autoclose: true,
	        format: 'dd M yyyy'
	    })
	}

	function select2() {
	    $('.select2').select2({
	        placeholder: 'Select an option',
	        allowClear: true
	    });
	}

	function inintSelect2(id) {
		$(`#${id}`).select2({
	        placeholder: 'Select an option',
	        allowClear: true
	    });
	}

	function showNotif(title, msg, jenis) {
	    $.notify({
	        title: '<strong>' + title + '</strong>',
	        message: msg
	    }, {
	        type: jenis,
	        z_index: 2000,
	        allow_dismiss: true,
	        delay: 10,
	        animate: {
	            enter: 'animated bounceIn',
				exit: 'animated bounceOut'
	        },
	    }, );
	};

	function notifLoading() {
	    $.notify({
	        title: '<strong> Sedang Memuat Data</strong>',
	        message: '',
	        icon: 'fa fa-circle-o-notch fa-spin',
	    }, {
	        type: 'warning',
	        placement: {
	            align: 'center'
	        },
	        z_index: 2000,
	        allow_dismiss: 'false',
	        animate: {
	            enter: 'animated fadeIn',
	            exit: 'animated fadeOut'
	        },
	    }, );
	}

	function getSelect(id, u, classoption, caption) {
	    $(`#${id}`).after(function() { $(`.${classoption}`).remove() });
		$(`#${id}`).val('');
		$(`#${id}`).trigger('change');
	    $.ajax({
	        url: `${php_base_url}${u}`,
	        type: "POST",
	        dataType: "JSON",
	        success: function(data) {
	        	$(`#${id}`).append(`<option class="${classoption}" value=""></option>`);
	            $.each(data, function(i, v) {
	            	$(`#${id}`).append(`<option class="${classoption}" value="${v.id}">${v[caption]}</option>`);
	            })
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	            console.log('Error on process');
	        }
	    });

	}

	function getSelectcustom(id, u, classoption, val, caption) {
		$(`#${id}`).select2({ disabled: true });
	    $(`#${id}`).after(function() { $(`.${classoption}`).remove() });
		$(`#${id}`).val('');
		$(`#${id}`).trigger('change');
	    $.ajax({
	        url: `${php_base_url}${u}`,
	        type: "GET",
	        dataType: "JSON",
	        success: function(data) {
	            $(`#${id}`).select2({ disabled: false });
	           	inintSelect2(id);
	        	$(`#${id}`).append(`<option class="${classoption}" value=""></option>`);
	            $.each(data, function(i, v) {
	            	$(`#${id}`).append(`<option class="${classoption}" value="${v[val]}">${v[caption]}</option>`);
	            })
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	            console.log('Error on process');
	            $(`#${id}`).select2({ disabled: false });
	        }
	    });
	}

	function getAkses(m) {
	    $.ajax({
	        url: `${php_base_url}/universe/getAkses`,
	        type: "POST",
	        data: {
	            menu: $.trim(m)
	        },
	        dataType: "JSON",
	        success: function(data) {
	        	if (data.super == '1') {
	        		$('.btn').removeClass('invisible')
	        		console.log('s')
	        	} else if ((data.super != '1') && (data.akses <= '0')) {
					showNotif("Forbiden", 'Anda Tidak Memiliki Akses ke Halaman Ini', 'danger');
	                setTimeout(function() {
						window.location.replace(`${php_base_url}landingpage`);
	                }, 1000);
	                console.log('!s!a')
	        	} else if ((data.super != '1') && (data.akses > '0')) {
	        		(data.res.i == 't') ? $('.add-btn').removeClass('invisible') : '';
					(data.res.u == 't') ? $('.edit-btn').removeClass('invisible') : '';
					(data.res.d == 't') ? $('.delete-btn').removeClass('invisible') : '';
					(data.res.o == 't') ? $('.option-btn').removeClass('invisible') : '';
					kodeinduk = data.res.kodeinduk;
					id_action = data.res.id_action;
					console.log('!s a')
	        	}
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	            console.log('Error Get Akses');
	            showNotif("", 'Error Get Akses', 'danger')
	        }
	    });
	}

	
	function activemenu() {
		$(".menuinduk-"+kodeinduk).addClass("active");
  		$(".menuanak-"+id_action).addClass("active");
  		$(".title").html(title);
	}

	function activemenux(induk, anak) {
		$("."+induk).addClass("active");
  		$("."+anak).addClass("active");
  		$(".title").html(title);
	}

	function imgError(image) {
	    image.onerror = "";
	    image.src = "/images/noimage.gif";
	    return true;
	}


	function ceknull(x) {
	    if ($('[name="' + x + '"]').val() == '' || $('[name="' + x + '"]').val() == null) {
	        showNotif('', 'Kolom Wajib Diisi', 'danger');
	        $('[name="' + x + '"]').focus()
	        formInvalid(x);
	        return true
			$('.btn-save').prop('disabled',false);
	    } else {
	        return false
	    }
	}

	function cekzero(x) {
	    if ($('[name="' + x + '"]').val() <= '0' || $('[name="' + x + '"]').val() <= 0 || $('[name="' + x + '"]').val() == null) {
	        showNotif('', 'Kolom Wajib Diisi', 'danger');
	        $('[name="' + x + '"]').focus()
	        formInvalid(x);
	        return true
			$('.btn-save').prop('disabled',false);
			clearform();
	    } else {
	        return false
	    }
	}

	function formInvalid(a) {
	    $('[name="' + a + '"]').addClass('pulse animated');
	}

	function clearform() {
	    $('input').removeClass('pulse animated');
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
