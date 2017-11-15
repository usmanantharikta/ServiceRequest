<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?php echo base_url().'/assets/dist/img/user2-160x160.jpg'?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?php echo $_SESSION['fullname'];?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <!-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
            <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form> -->
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li style="text-align:center" class="header">MAIN MENU</li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-envelope-o"></i>
          <span>REQUEST</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id="add"><a href="<?php echo site_url().'/directure/add_request'?>"><i class="fa fa-circle-o"></i> Add New Request</a></li>
          <li id="list"><a href="<?php echo site_url().'/directure'?>"><i class="fa fa-circle-o"></i> All Request</a></li>
          <!-- <li><a href="collapsed-sidebar.html"><i class="fa fa-circle-o"></i> Collapsed Sidebar</a></li> -->
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-inbox"></i>
          <span>RECEIPT</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li id='receipt_menu'><a href="<?php echo site_url().'/directure/receipt'?>"><i class="fa fa-circle-o"></i> Receipt Task List</a></li>
          <!-- <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li> -->
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user-circle-o"></i>
          <span>PROFILE</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <?php
          if($_SESSION['level']=='admin'){
            ?>
          <li id='create'><a href="<?php echo site_url().'/admin/create_user'?>"><i class="fa fa-circle-o"></i> Create User</a></li>
          <li id='reset'><a href="<?php echo site_url().'/admin/reset_password'?>"><i class="fa fa-circle-o"></i> Reset Password</a></li>
          <li id='reset'><a href="<?php echo site_url().'/admin/add_employ'?>"><i class="fa fa-circle-o"></i> Add Employee</a></li>
        <?php } ?>
          <li id='change'><a href="<?php echo site_url().'/general'?>"><i class="fa fa-circle-o"></i> Change Password</a></li>
          <li><a href="<?php echo site_url().'/general/logout'?>"><i class="fa fa-circle-o"></i> Sign out</a></li>
          <!-- <li><a href="../../index2.html"><i class="fa fa-circle-o"></i> Dashboard v2</a></li> -->
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
