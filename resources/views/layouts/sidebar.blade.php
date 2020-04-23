<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="{{ (request()->is('home')) ? 'active' : '' }}"><a href="{{url('home')}}"><i class="fa fa-dashboard"></i><span>Home</span></a></li>
        <li class="header">Others</li>
        <li><a href="{{url('auth/logout')}}"><i class="fa fa-sign-out"></i><span>Logout</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>
