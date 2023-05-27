<?php
use App\Http\Controllers\HomeController;
// if(Session::has('user')){
//   $total=HomeController::testBladeFunc();
// }
?>
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{request()->path()=='home'?'active':''}}" href="{{ url('/home') }}">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link {{request()->path()=='performance'?'active':''}}" href="{{ url('/performance') }}">
          <i class="bi bi-graph-up"></i>
          <span>Performance</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{request()->path()=='add-entry'?'active':''}}" href="{{ url('/add-entry') }}">
          <i class="bx bi-journals"></i>
          <span>Add Entry</span>
        </a>
      </li><!-- End Search Nav -->
      <li class="nav-item">
        <a class="nav-link {{request()->path()=='open-trade'?'active':''}}" href="{{ url('/open-trade') }}">
          <i class="bi bi-eyeglasses"></i>
          <span>Open Trade</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{request()->path()=='trade-journal'?'active':''}}" href="{{ url('/trade-journal') }}">
          <i class="bi bi-table"></i>
          <span>Trade Journal</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{request()->path()=='trade-summary'?'active':''}}" href="{{ url('/trade-summary') }}">
          <i class="bi bi-table"></i>
          <span>Trade Summary</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{request()->path()=='calculator'?'active':''}}" href="{{ url('/calculator') }}">
          <i class="bi bi-calculator"></i>
          <span>Calculator</span>
        </a>
      </li>
      <!-- <li class="nav-heading">Personal</li>

      <li class="nav-item">
        <a class="nav-link" href="profile">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="contact">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li> -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="{{ url('/logout') }}">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </a>
      </li>
       

    </ul>

  </aside>