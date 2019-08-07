<div class="control-sidebar-bg"></div>
<script src="<?php echo base_url()?>assets/lte/plugins/jquery/dist/jquery.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/dist/js/adminlte.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/notify/bootstrap-notify.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/select2/dist/js/select2.full.min.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/ajaxupload/jquery.ajaxfileupload.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/ckeditor/ckeditor.js"></script>
<script src="<?php echo base_url()?>assets/lte/plugins/pace/pace.js"></script>
<script src="<?php echo base_url()?>assets/jquery.chained.js"></script>
<!-- <script src="<?php echo base_url()?>assets/vue.min.js"></script>
<script src="<?php echo base_url()?>assets/axios.min.js"></script> -->
<script type="text/javascript">

	var php_base_url = '<?php echo base_url() ?>';
	var php_session_nama = '<?php echo $this->session->userdata("nama") ?>';
	var php_session_id = '<?php echo $this->session->userdata("id") ?>';
	var id_action ;

	$(document).ready(function() {
	    
	})

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

	function getSelect(d, u) {
	    $.ajax({
	        url: `${apiurl}/${u}`,
	        type: "POST",
	        dataType: "JSON",
	        success: function(data) {
	            for (var i = 0; i < data.length; i++) {
	                $("#" + d).append('<option value=' + data[i].id + '>' + data[i].judul + '</option>');
	            }
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	            alert('Error on process');
	        }
	    });

	}

	function getAkses(m) {
	    $.ajax({
	        url: `${php_base_url}/universe/getAkses`,
	        type: "POST",
	        data: {
	            menu: m
	        },
	        dataType: "JSON",
	        success: function(data) {
				(data.res.i == 't') ? $('.add-btn').removeClass('invisible') : '';
				(data.res.u == 't') ? $('.edit-btn').removeClass('invisible') : '';
				(data.res.d == 't') ? $('.delete-btn').removeClass('invisible') : '';
				(data.res.o == 't') ? $('.option-btn').removeClass('invisible') : '';
				kodeinduk = data.res.kodeinduk;
				id_action = data.res.id_action;
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	            console.log('Error Get Akses');
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

	function getMenu() {
		var mInudk;
		var mChild;

	    $.ajax({
	        url: `${php_base_url}/universe/getMenu`,
	        type: "POST",
	        dataType: "JSON",
	        success: function(data) {
	            mInduk = data.induk;
	            mChild = data.anak;
	            $.each(mInduk, function(i, v) {
	                if (mInduk[i].kodeinduk == mInduk[i].kodeinduk) {
	                    $(".sidebar-menu").append(`
				<li class="treeview menu-user-list menuinduk-${mInduk[i].kodeinduk}">
		          <a href="#">
		            <i class="fa ${mInduk[i].iconinduk}"></i> <span>${mInduk[i].namainduk}</span>
		            <span class="pull-right-container">
		              <i class="fa fa-angle-left pull-right"></i>
		            </span>
		          </a>
		          <ul class="treeview-menu tree-child-${mInduk[i].kodeinduk}">
		          </ul>
		        </li>`);
	                }
	            });

	            $.each(mChild, function(i, v) {
	                if (mChild[i].kodeinduk == mChild[i].kodeinduk) {
	                    $(`.tree-child-${mChild[i].kodeinduk}`).append(`<li class="menuanak-${mChild[i].id_action}"><a href="${php_base_url}${mChild[i].path}"><i class="fa fa-circle-o"></i> ${(mChild[i].nama_action).trim()}</a></li>`);
	                }
	            });
	        },
	        error: function(jqXHR, textStatus, errorThrown) {
	            showNotif('Gagal', 'Internal Error', 'danger')
	        }
	    });
	}

	function allowAkses() {
		// $('.add-btn').remove();
	}

</script>
