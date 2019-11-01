   // for (var i = 0; i < menuItem.length; i++) {
	    //     $(".sidebar-menu").append(`<li class="treeview ${menuItem[i].nama}"><a href="<?php echo base_url(); ?>${menuItem[i].nama}"><i class="${menuItem[i].icon}"></i><span>${menuItem[i].nama}</span></a></li>`);
	    // }

	    // $.each(menuItem, function(i, v) {
	    //     if (menuItem[i].path == menuItem[i].path) {
	    //         $(".sidebar-menu").append(`<li class="treeview ${menuItem[i].nama}"><a href="${php_base_url}${menuItem[i].nama}"><i class="${menuItem[i].icon}"></i><span>${menuItem[i].nama}</span></a></li>`);
	    //     }
	    // });


		<?php $menu = $this->Unimodel->getaksesmenu_new() ?>
  <li class="header">MENU</li>
      <?php 
      $id = -1;
      $no=1;

      foreach ($menu as $t) {

          if ($id != -1 && $id != $t->group_action) {
              echo '</ul>';
          }

          if ($id != $t->group_action) { ?>

              <li class="treeview <?php echo strtolower(str_replace(' ', '', $t->group_action)); ?>" >
                <a href="#">
                <?php 
                $geticongroup= $t->icon_group;
                $icongroup = 'fa fa-database';
                if ($geticongroup) {
                  $icongroup = $geticongroup;
                }else {
                  $icongroup = $icongroup;
                }?>
                
                <?php 
                $group = "";
                if ($t->group_action == NULL) {
                  $group = "Lainnya";
                }else {
                  $group = $t->group_action;
                }

                 ?>
                <i class="fa <?php echo $icongroup; ?>"></i> <span>
                    <?php echo $group; ?>
                </span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu data">
              

          <?php $id = $t->group_action; } ?>

          <?php $str = substr("$t->nama",0,6);
            $hidden = 'inline';
            if ($str != 'Master') {
              $hidden = 'none';
            };
            $geticon= $t->icon;
            $icon = 'fa fa-circle-o';
            if ($geticon) {
              $icon = $geticon;
            }else {
              $icon = $icon;
            }?>
             
          <li class="<?php echo strtolower(str_replace(' ', '', $t->nama)); ?>">
            <a href="<?php echo site_url( strtolower(str_replace(' ', '', $t->url))); ?>">
          <i class="fa <?php echo $icon ?>"></i> <span><?php echo $t->nama ?></span>
          </a>
          </li>
             

        <?php $no++;}

      echo '</ul>';
      echo '</li>';

      ?> 
    