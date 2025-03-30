<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
   
    <script defer src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    
    <style>
        body { height: 100vh; margin: 0; 
            background-color:#F0F0F0;
        }

        .sidebar {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 70px; /* Adjust as needed */
            background-color: #f8f9fa; /* Light background */
            padding: 2px;
        }

        .sidebar-exp{
            position: fixed;
            bottom: 0;
            left: 80px;
            width: 180px; /* Adjust as needed */
            background-color:#F0F0F0; /* Light background */
            padding: 2px;
        }

        .pico-img{
            margin-top: 10px;
            margin-bottom: 10px;
            width:30px;
            height: 30px;
        }

        .btn-primary{
            margin-bottom: 40px;
            margin-left: 50px;
        }
        
        .modal-dialog{
            margin-left: 75px;
        }

        .service-btn{
            display: flex;
            flex-direction:column;
            align-items: center;
            justify-content: center;
            padding: 10px;
            width: 100%;
            
        }

        .nav-link.active-service {
            /* Optional: Add a subtle background */
            opacity: 1 !important;
        }

        .box-feature{
            width: 40px;
            height: 40px;
            background-color: red;
            justify-content: center;
            align-items: center;
        }

        
        .col-md-10{
            min-height: 100vh; 
            background-color:#F0F0F0;
            min-width: 100%;
        }

        .col-md-1{
            background-color:#F0F0F0 ;
        }

        #navbar-a{
            text-align:center;
            align-items: center;
            display:block;
            background-color: white; 
            border-radius: 5px;
        }

        @media (min-width: 768px) {
        .ps-md-4 {
            padding-left: 90px !important;         
        }
        .row{
            height: 100vh;
        }
        }   
        
        li:hover {
            color:blue;
        }

        .fa-circle-info:hover{
            
            background-color: green;
        }

        #main-layout{
            margin-left: 10px;
        }

    </style>
    <title>Role Edit</title>
</head>
<body>
    <div class="container-fluid ">
        <div class="row " style="background-color:#F0F0F0;">
            <div class="col-sm-1 col-md-1 col-lg-1 bg-light sticky-top" id="sidebar" >
                <div class="d-flex flex-sm-column flex-nowrap bg-white sticky-top  align-items-center sidebar">
                    <a  class="d-block p-3 link-dark text-decoration-none" title="" >
                        <img src="/images/pico.jpg" class="pico-img"/>
                    </a>
                    <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center justify-content-between w-80 align-items-center">
                        <li class="nav-item">  
                            <a href="#"  class="nav-link py-3 px-2"  data-bs-toggle="modal" data-bs-target="#modalDashboard" id="service-userManage">
                                <i class="fa-solid fa-grip-vertical text-primary" id="icon-userManage"></i>
                            </a> 
                        </li>
                        <li>
                            <a href="#" class="nav-link py-3 px-1" >
                            <i class="fa-solid fa-address-book" style="color:gray"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link py-3 px-2" >
                                <i class="fa-solid fa-calendar-days" style="color:gray"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link py-3 px-2" >
                            <i class="fa-solid fa-cart-shopping" style="color:gray"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link py-3 px-2"  >
                            <i class="fa-solid fa-truck" style="color:gray"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link py-3 px-2" >
                            <i class="fa-solid fa-keyboard" style="color:gray"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link py-3 px-2" >
                            <i class="fa-solid fa-building-columns" style="color:gray"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link py-3 px-2" >
                            <i class="fa-solid fa-chart-column" style="color:gray"></i>
                            </a>
                        </li>
                    </ul>
                    <button type="button" class="btn btn-primary " id="sidebar-btn"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
            <div class="col-sm-1 col-md-1 col-lg-1 bg-light sticky-top" id="expand-sidebar" style="display: none;" >
                <div class="d-flex flex-sm-column flex-nowrap bg-white sticky-top  align-items-center sidebar-exp">
                        <ul class="nav nav-pills nav-flush flex-sm-column flex-row flex-nowrap mb-auto mx-auto text-center justify-content-between align-items-center" id="expand-bar"> 
                            <li>
                                
                                <a  class="nav-link py-3 px-1 mb-2" >
                                <b class="text-secondary fs-6" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">USER MANAGEMENT</b>
                                </a>
                            </li>
                            <li class="w-100 ">
                                @if ($features->isNotEmpty())
                                    @foreach($features as $feature)
                                        <nav class="nav flex-column" id="sidebar-item">
                                            <?php 
                                            $url =strtolower(str_replace(' ','',$feature->feature_name));
                                            $url_href= '/' . $url ; ?>
                                           
                                            <a class="nav-link  text-secondary py-3 " aria-current="page" href=<?php echo htmlspecialchars($url_href) ?>><b>{{$feature->feature_name}} </b></a>
                                        </nav>
                                    @endforeach
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>
            
            <div class="col-sm-10 col-md-10 col-lg-9 " id="main-layout">
                <div class="container">
                    <div class="navbar navbar-expand-md navbar-expand-sm navbar-light">
                        <div class="container">
                            <div class="navbar-header" >
                                <h4>Users Edit</h4>    
                            </div>
                            @if (session('password'))
                            <div class="alert alert-danger"  style="margin-left: 20%">
                                {{ session('password') }}
                            </div>
                            @endif
                            <div class="collapse navbar-collapse " id="navbarNavAltMarkup">
                                <div class="navbar-nav  ms-md-auto ms-sx-auto ">
                                    <div class="d-flex flex-row" style="height:40px">
                                        <a class="nav-item nav-link " href="#" id="navbar-a" ><span>English <img src="/images/us-flag.png" style="width: 20px; height:20px; border-radius:40%"></span></a>
                                    </div>
                                    <div class=" bg-white mx-2 "  id="navbar-a" style="height:40px"  >
                                        <a class="nav-item nav-link " href="#"><i class="fa-solid fa-fax"></i> </a>
                                    </div>
                                    <div class=" bg-white mx-2 " id="navbar-a" style="height:40px">
                                        <a class="nav-item nav-link " href="#"  ><i class="fas fa-volume-mute text-gray" ></i> </a>
                                    </div>
                                    <div class="bg-white mx-2" id="navbar-a" style="height:40px">
                                        <a class="nav-item nav-link" href="#"  ><i class="bi bi-brightness-high"></i></a>
                                    </div>
                                    <div clas="nav-item dropdown">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                            {{ Auth::user()->name }}
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                                                document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                                @csrf
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container py-2">
                    <a href="/users" class="text-decoration-none text-secondary"><i class="fa-solid fa-arrow-left"></i> Back</a>                  
                </div>
                <div class="container d-flex flex-column justify-content-center align-items-center bg-light rounded " style="width: 90%;" >
                    <div class="container ps-1" style="justify-content: space-between; margin-top:20px">                    
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="input-username">Username</label>
                                <input type="text" class="form-control mb-3 @error('name') is-invalid @enderror" id="input-username"
                                    placeholder="Enter name" name="name" value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="input-email">Email</label>
                                <input type="email" class="form-control mb-3 @error('email') is-invalid @enderror" id="input-email"
                                    placeholder="Enter Email" name="email" value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="input-pwd">Old Password</label>
                                <input type="password" class="form-control mb-3 @error('password') is-invalid @enderror" id="input-pwd"
                                    placeholder="Enter Old Password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="input-pwd">New Password</label>
                                <input type="password" class="form-control mb-3 @error('new_password') is-invalid @enderror" id="input-pwd"
                                    placeholder="Enter New Password" name="new_password">
                                @error('new_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="input-pwd">Confirm New Password</label>
                                <input type="password" class="form-control mb-3 @error('new_password_confirmation') is-invalid @enderror"
                                    id="input-pwd-confirm" placeholder="Confirm New Password" name="new_password_confirmation">
                                @error('new_password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        
                            <label for="role_id">Roles</label>
                            <select class="form-select mb-3 @error('role_id') is-invalid @enderror" name="role_id" id="role_id">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        
                            <button type="submit" class="btn btn-primary mx-auto d-block w-100 mb-2">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        
        //feature-select-all
        document.querySelectorAll('.select-all-features').forEach(selectAll => { // Corrected class name
        selectAll.addEventListener('change', function() {
            let featureId = this.getAttribute('data-feature-id');
            let checkboxes = document.querySelectorAll('.permission-checkbox[data-feature-id="' + featureId + '"]');
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
        });                                     

        /* document.addEventListener('DOMContentLoaded', function() {
            const roleTitle = document.getElementById('role_title');
            const roleLi = document.getElementById('role_li');
            const roleList = document.getElementById('role_href');
            const currentPath = window.location.pathname; // Get the current path

            if (currentPath === "/users/create") {
                roleTitle.style.color = '#0080FF';
                roleLi.style.color = '#0080FF';
                roleList.style.color = '#0080FF'; 
            }
        }); */
    

        //active service on sidebar
        document.addEventListener('DOMContentLoaded', function() 
        {
            const modal = document.getElementById('modalDashboard');
            const service = document.getElementById('service-userManage');
            const iconUser = document.getElementById('icon-userManage');
            modal.addEventListener('show.bs.modal', function() 
            {
            // Highlight the icon when the modal opens
            service.classList.add('active-service'); //adjust to the right Id to highlight
            iconUser.style.color = "#007bff";
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            const expandSidebarButton = document.getElementById('sidebar-btn');
            const expandedSidebar = document.getElementById('expand-sidebar');
            const mainContent = document.getElementById('main-layout');
            const sidebar = document.getElementById("sidebar");
            const userCollap = document.getElementById('user-collap')
            const userIconDown = document.getElementById('user-collap-i-down');
            const collapseExample = document.getElementById('collapseExample');
            const roleCollap = document.getElementById('role-collap');
            const roleIconDown = document.getElementById('role-collap-i-down');
            const collapseRole = document.getElementById('collapseRole');

            expandSidebarButton.addEventListener('click', function() {
                if (expandedSidebar.style.display === 'none') {
                    expandedSidebar.style.display = 'flex';
                    mainContent.classList.remove('col-md-10');
                    mainContent.classList.add('col-md-7');
                    expandSidebarButton.innerHTML = '<i class="fas fa-chevron-left"></i>';
                    /* expandSidebarButton.style.marginBottom='40px';
                    expandSidebarButton.style.marginLeft = '50px'; */
                    roleCollap.click();
                    
                    collapseRole.addEventListener('shown.bs.collapse', function() {
                        roleIconDown.classList.remove('fa-angle-down');
                        roleIconDown.classList.add('fa-angle-up');
                    });

                    collapseRole.addEventListener('hidden.bs.collapse', function() {
                        roleIconDown.classList.remove('fa-angle-up');
                        roleIconDown.classList.add('fa-angle-down');
                    });

                    collapseExample.addEventListener('shown.bs.collapse', function() {
                        userIconDown.classList.remove('fa-angle-down');
                        userIconDown.classList.add('fa-angle-up');
                    });

                    collapseExample.addEventListener('hidden.bs.collapse', function() {
                        userIconDown.classList.remove('fa-angle-up');
                        userIconDown.classList.add('fa-angle-down');
                    });
            
            } 
            else {
                expandedSidebar.style.display = 'none';
                mainContent.classList.remove('col-md-7');
                mainContent.classList.add('col-md-10');
                expandSidebarButton.innerHTML = '<i class="fas fa-chevron-right"></i>';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        const roleBtn = document.getElementById("role-icon");
        roleBtn;
    });
        
    </script>
    </body>
</html>