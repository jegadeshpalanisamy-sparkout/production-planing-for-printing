   
   <nav class="sidebar sidebar-offcanvas bg-white shadow mt-5 pt-5" id="sidebar">
    <ul class="space-y-4  ps-0">
        <li class="nav-item menu-items">
            <a class="nav-link bg-white-500 rounded-md hover:bg-blue-400 hover:text-white " href="{{ route('home') }}">
                <button class="bg-white-500 text-black px-4  rounded-md w-100 ">
                    Process
                </button>
                
            </a>
        </li>
        <li class="nav-item menu-items">
          <a class="nav-link bg-white-500 rounded-md hover:bg-blue-400 hover:text-white" href="{{ route('admin.show_employees') }}">
              <button class="bg-white-500 text-black px-4  rounded-md w-100 ">
                  Employee Details
              </button>
              
          </a>
      </li>

      <li class="nav-item menu-items">
        <a class="nav-link bg-white-500 rounded-md hover:bg-blue-400  " href="{{ route('orders.index') }}">
            <button class="bg-white-500 text-black px-4  rounded-md w-100">
                Orders Details
            </button>
            
        </a>
    </li>

    <li class="nav-item menu-items">
        <a class="nav-link bg-white-500 rounded-md hover:bg-blue-400 " href="{{ route('admin.assign_list') }}">
            <button class="bg-white-500 text-black px-4  rounded-md w-100 ">
                Assign Order
            </button>
            
        </a>
    </li>

    <li class="nav-item menu-items">
        <a class="nav-link bg-white-500 rounded-md hover:bg-blue-400 " href="{{ route('admin.order_reports') }}">
            <button class="bg-white-500 text-black px-4  rounded-md w-100 ">
                 Order reports
            </button>
            
        </a>
    </li>
    <li class="nav-item menu-items">
        <a class="nav-link bg-white-500 rounded-md hover:bg-blue-400 " href="{{ route('admin.bill_index') }}">
            <button class="bg-white-500 text-black px-4  rounded-md w-100 ">
                 Billings
            </button>
            
        </a>
    </li>
    </ul>
</nav>



