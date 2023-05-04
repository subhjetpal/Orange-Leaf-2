<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'home.php')===TRUE){ echo 'active';} ?>" href="home.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>
      <!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'performance.php')===TRUE){ echo 'active';} ?>" href="performance.php">
          <i class="bi bi-graph-up"></i>
          <span>Performance</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'add-entry.php')===TRUE){ echo 'active';} ?>" href="add-entry.php">
          <i class="bx bxs-notepad"></i>
          <span>Add Entry</span>
        </a>
      </li><!-- End Search Nav -->
      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'open-trade.php')===TRUE){ echo 'active';} ?>" href="open-trade.php">
          <i class="bi bi-eyeglasses"></i>
          <span>Open Trade</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'trade-journal.php')===TRUE){ echo 'active';} ?>" href="trade-journal.php">
          <i class="bi bi-table"></i>
          <span>Trade Journal</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'trade-summary.php')===TRUE){ echo 'active';} ?>" href="trade-summary.php">
          <i class="bi bi-table"></i>
          <span>Trade Summary</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'calculator.php')===TRUE){ echo 'active';} ?>" href="calculator.php">
          <i class="bi bi-calculator"></i>
          <span>Calculator</span>
        </a>
      </li>
      <!-- <li class="nav-heading">Personal</li>

      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'profile.php')===TRUE){ echo 'active';} ?>" href="profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php if(str_contains($_SERVER['REQUEST_URI'], 'contact.php')===TRUE){ echo 'active';} ?>" href="contact.php">
          <i class="bi bi-envelope"></i>
          <span>Contact</span>
        </a>
      </li> -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-box-arrow-right"></i>
          <span>Logout</span>
        </a>
      </li>
       

    </ul>

  </aside>