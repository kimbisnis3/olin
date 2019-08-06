<!DOCTYPE html>
<html> 
	<title>My Panel</title>
	<?php $this->load->view('_partials/head') ?>
	<style type="text/css">
		body {
			background:#9adea9 !important;
		}
		.hue {
		    background: #f35626;
		    background-image: linear-gradient(92deg, #f35626 0%,#feab3a 100%);
		    -webkit-background-clip: text;
		            background-clip: text;
		    -webkit-text-fill-color: transparent;
		    animation: hue 20s infinite linear;
		  }

		  @keyframes hue {
			  from {
			    filter: hue-rotate(0deg);
			  }
			  
			  to {
			    filter: hue-rotate(-360deg);
			  }
			}
	</style>
	<body class="hold-transition">
		<div class="login-box">
			<div class="login-logo hue">
				<b>My Panel</b> <br>
			</div>
			<div class="login-box-body" id="login">
				<p class="login-box-msg">Login</p><br>
				<form>
					<div class="form-group has-feedback">
						<input type="text" name="username" class="form-control" placeholder="Username">
						<span class="fa fa-user form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" name="pass" class="form-control" placeholder="Password">
						<span class="fa fa-lock form-control-feedback"></span>
					</div>
					<div class="row">
						<div class="col-xs-12">
							<button type="button" class="btn btn-success btn-block btn-flat btn-lg" onclick="login()">Masuk</button>
						</div>
					</div>
				</form>
				<br>
				<a href="#"></a><br>
			</div>
		</div>
	</body>
<?php $this->load->view('_partials/js');?>
</html>
<script src="<?php echo base_url()?>assets/vanta/three.r92.min.js"></script>
<script src="<?php echo base_url()?>assets/vanta/vanta.birds.min.js"></script>
<script type="text/javascript">
	function login() {
		$.ajax({
          url: '<?php echo base_url() ?>auth/auth_process/',
          type: "POST",
          dataType: "JSON",
          data: {
              username	: $('[name="username"]').val(),
              pass		: $('[name="pass"]').val(),
          },
          success: function(data) {
              if (data.result == 'success') {
                  showNotif(data.caption, data.msg, data.class)
                  setTimeout(function(){ window.location.href = "<?php echo base_url() ?>landingpage" }, 1000);
                  ;
              } else if (data.result == 'fail') {
                  showNotif(data.caption, data.msg, data.class)
              }
          },
          error: function(jqXHR, textStatus, errorThrown) {
              showNotif('Gagal', 'Internal Error', 'danger')
          }
      });
	}

	$('[name="username"]').keypress(function(e) {
	    var key = e.which;
	    if (key == 13) 
	    {
	        login();
	        return false;
	    }
	});
	
	$('[name="pass"]').keypress(function(e) {
	    var key = e.which;
	    if (key == 13) 
	    {
	        login();
	        return false;
	    }
	});

</script>
<script>
VANTA.BIRDS({
  el: "#login",
  backgroundColor: 0xffffff,
  birdSize: 1.90,
  quantity: 5.00
})
</script>
