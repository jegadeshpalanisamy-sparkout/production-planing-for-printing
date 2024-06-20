   <nav class="sidebar sidebar-offcanvas bg-white shadow mt-5 pt-5 h-full" id="sidebar">
    <ul class="space-y-4 px-4">
        <li class="nav-item menu-items">
            <a class="nav-link bg-violet-500 rounded-md " href="{{ route('home') }}">
                <button class="bg-violet-500 text-white px-4  rounded-md w-100 hover:bg-violet-600">
                    Process
                </button>
                
            </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link bg-violet-500 rounded-md " href="{{ route('admin.show_employees') }}">
              <button class="bg-violet-500 text-white px-4  rounded-md w-100 hover:bg-violet-600">
                  Employee Details
              </button>
              
          </a>
      </li>

      <li class="nav-item menu-items">
        <a class="nav-link bg-violet-500 rounded-md " href="{{ route('orders.index') }}">
            <button class="bg-violet-500 text-white px-4  rounded-md w-100 hover:bg-violet-600">
                Orders Details
            </button>
            
        </a>
    </li>
    </ul>
</nav>

