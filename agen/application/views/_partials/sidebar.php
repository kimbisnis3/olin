<?php 
  include(APPPATH.'libraries/dbinclude.php');  
  // $w = array('active' => '1', );
  // $this->dbtwo->order_by('urutan','ASC');
  $q = "SELECT 
            * 
        FROM 
          takses 
        LEFT JOIN tmenu ON tmenu.kode = takses.ref_menu
        WHERE 
          takses.ref_cust = '{$this->session->userdata('kodecust')}'";
  $menulist = $this->dbtwo->query($q)->result_array()
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
    $access     = $this->session->userdata("access");
    $issuper    = $this->session->userdata("issuper");
    $sql    = 
        "SELECT DISTINCT
        taction_group.group_action,
        taction_group.kode,
        taction_group.icon_group,
        taction_group.sort_group
      FROM
        taction_group
      LEFT OUTER JOIN taction ON taction.group_action = taction_group.kode
      LEFT OUTER JOIN topsi ON taction.id_action = topsi.ref_action_opsi
    ";
    if ($issuper !='1' or $issuper != '1') {
        $sql .= " WHERE topsi.ref_access_opsi = '$access'";
    }
    $sql .= " ORDER BY taction_group.sort_group ASC";
    $menuinduk = $this->db->query($sql)->result();
    ?>
    <?php foreach ($menuinduk as $i => $v): ?>
    <li class="<?php echo strtolower(str_replace(' ', '', $v->group_action)); ?> treeview">
      <a href="#">
        <i class="fa <?php echo $v->icon_group; ?>"></i> <span><?php echo $v->group_action ?></span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
        <?php
        $access     = $this->session->userdata("access");
        $issuper    = $this->session->userdata("issuper");
        $sql    = 
            "SELECT
            taction_group.group_action,
            taction_group.icon_group,
            taction.nama_action nama,
            taction.icon_action icon,
            taction.kategori_menu kategori,
            taction.url
        FROM
            taction
        LEFT OUTER JOIN topsi ON taction.id_action = topsi.ref_action_opsi
        LEFT OUTER JOIN taction_group ON taction.group_action = taction_group.kode";

        if ($issuper !='1' or $issuper != '1') {
            $sql .= " WHERE topsi.ref_access_opsi = '$access'";
        }
        $sql .= " AND taction.group_action = '$v->kode'";
        $sql .= " ORDER BY taction_group.sort_group, taction.sort_menu ASC";
        $menuanak = $this->db->query($sql)->result();
        ?>
        <?php foreach ($menuanak as $i => $t): ?>
        <li class="<?php echo strtolower(str_replace(' ', '', $t->nama)); ?>">
          <a href="<?php echo site_url( strtolower(str_replace(' ', '', $t->url))); ?>">
            <i class="fa <?php echo $t->icon ?>"></i> <span><?php echo $t->nama ?></span>
          </a>
        </li>
        <?php endforeach; ?>
      </ul>
    </li>
    <?php endforeach; ?>
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
