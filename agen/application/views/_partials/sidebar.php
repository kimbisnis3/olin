<?php $menu = $this->Unimodel->getaksesmenu_new() ?>
<?php 
  include(APPPATH.'libraries/dbinclude.php');  
  $w = array('active' => '1', );
  $this->dbtwo->order_by('urutan','ASC');
  $menulist = $this->dbtwo->get_where('tmenu',$w)->result_array()
?>
<aside class="main-sidebar">
  <section class="sidebar">
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url()?>assets/gambar/logo.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $this->session->userdata("nama"); ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <ul class="sidebar-menu" data-widget="tree">
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
    
    <li class="frontend treeview">
      <a href="#">
        <i class="fa fa-dashboard"></i> <span>Front End</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <?php foreach ($menulist as $i => $v): ?>
        <li class="<?php echo $v['class'] ?>">
          <a href="<?php echo base_url() ?><?php echo $v['url'] ?>">
            <i class="<?php echo $v['icon'] ?>"></i> <span><?php echo $v['menu'] ?></span>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </li>
  </section>
</aside>
