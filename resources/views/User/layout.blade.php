<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!--    CDN boostraps-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.4.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain/bsb.css" />

    <link rel="stylesheet" href="{{asset('css/user.css')}}">
    <title>
        @section('title')
        @show
    </title>
</head>
<body>

    @if (Session::has('success'))
        <ul class="notification">
            <li class="success toasts">
                <div class="column">
                    <i class="fa fa-check"></i>
                    <span>{{ session('success') }}</span>
                </div>
                <i class="fa fa-xmark"></i>
            </li>
        </ul>
    @elseif (Session::has('error'))
        <ul class="notification">
            <li class="error toasts">
                <div class="column">
                    <i class="fa fa-check"></i>
                    <span>{{ session('error') }}</span>
                </div>
                <i class="fa fa-xmark"></i>
            </li>
        </ul>
    @endif
    <ul class="notification">
    </ul>

    <header>
        <div class="header-news position-relative min-height-100">
            <div class="overlay"></div>
            <div class="menu-item-hide position-fixed top-0 bottom-0 bg-white border-end">
                <div class="close-menu position-absolute top-5 end-5 cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M12.0007 10.5865L16.9504 5.63672L18.3646 7.05093L13.4149 12.0007L18.3646 16.9504L16.9504 18.3646L12.0007 13.4149L7.05093 18.3646L5.63672 16.9504L10.5865 12.0007L5.63672 7.05093L7.05093 5.63672L12.0007 10.5865Z" fill="rgba(0,0,0,1)"></path></svg>
                </div>
                <div class="mt-4 ms-2">
                    <svg style="margin-top: -9px !important;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"><path d="M12 3.09747L7.05025 8.04722C4.31658 10.7809 4.31658 15.213 7.05025 17.9467C9.78392 20.6804 14.2161 20.6804 16.9497 17.9467C19.6834 15.213 19.6834 10.7809 16.9497 8.04722L12 3.09747ZM12 0.269043L18.364 6.633C21.8787 10.1477 21.8787 15.8462 18.364 19.3609C14.8492 22.8756 9.15076 22.8756 5.63604 19.3609C2.12132 15.8462 2.12132 10.1477 5.63604 6.633L12 0.269043ZM7 12.997H17C17 15.7584 14.7614 17.997 12 17.997C9.23858 17.997 7 15.7584 7 12.997Z" fill="rgba(100,205,138,1)"></path></svg>
                    <a href="{{url('/')}}" style="color: #4cc170;" class="mt-3 ms-1 text-uppercase fw-bold text-decoration-none fs-3 text-bs-indigo">NEWS</a>
                </div>
                <div class="item-menu-hide">
                    <ul class="list-category-header">
                        @foreach(\App\Models\Admin\Category::where('parent_id', 0)->whereNot(function ($query) { $query->where('id', 7);})->limit(8)->get() as $category)
                            <li>
                                <a href="{{url('category/'. $category->slug)}}">{{$category->name}}</a>
                            </li>
                        @endforeach
                    </ul>

                    <div class="login-hide-item">
                        @if(\Illuminate\Support\Facades\Auth::check())
                            <div class="dropdown user-login-dropdown">
                                    <form role="form" action="{{ url('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                style="outline: none; border: none; background-color: transparent;display: flex;">
                                            <div
                                                class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                                                <i class="ri-login-box-line text-warning  text-sm opacity-10"></i>
                                            </div>
                                            <span class="nav-link-text ms-1" style="font-size:14px; margin-top:4px;">Log Out</span>
                                        </button>
                                    </form>
                                </ul>
                            </div>
                        @else
                            <div class="login-header">
                                <a style="color:black; margin-left: 23px" href="{{ url('/login')}}">Đăng nhập</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="top-header d-md-flex justify-content-center align-items-center gap-md-7 ">
                    <a href="#" target="_blank" class="text-uppercase text-xs ">GameK</a>
                    <a href="#" target="_blank" class="text-uppercase text-xs ">Kenh14</a>
                    <a href="#" target="_blank" class="text-uppercase text-xs ">Cafebinz</a>
                </div>
            </div>
            <div class="main-header container-fluid">
                <div class="container">
                    <div class="middle-header">
                        <div class="row">
                            <div class="col-sm-2 logo">
                                <div class="mt-2">
                                    <svg style="margin-top: -9px !important;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"><path d="M12 3.09747L7.05025 8.04722C4.31658 10.7809 4.31658 15.213 7.05025 17.9467C9.78392 20.6804 14.2161 20.6804 16.9497 17.9467C19.6834 15.213 19.6834 10.7809 16.9497 8.04722L12 3.09747ZM12 0.269043L18.364 6.633C21.8787 10.1477 21.8787 15.8462 18.364 19.3609C14.8492 22.8756 9.15076 22.8756 5.63604 19.3609C2.12132 15.8462 2.12132 10.1477 5.63604 6.633L12 0.269043ZM7 12.997H17C17 15.7584 14.7614 17.997 12 17.997C9.23858 17.997 7 15.7584 7 12.997Z" fill="rgba(100,205,138,1)"></path></svg>
                                    <a href="{{url('/')}}" style="color: #4cc170;" class="mt-3 ms-1 text-uppercase fw-bold text-decoration-none fs-3 text-bs-indigo">NEWS</a>
                                </div>
                            </div>
                            <div class="col-md-4 d-flex justify-content-start align-items-center">
                                    <svg class="bar-chat me-3 cursor-pointer" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"><path d="M3 4H21V6H3V4ZM3 19H21V21H3V19ZM3 14H21V16H3V14ZM3 9H21V11H3V9Z" fill="rgba(255,255,255,1)"></path></svg>
                                <div class="trending-icon">
                                    <svg width="20" height="13" viewBox="0 0 20 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_2_588)">
                                            <path d="M7.71094 6.06641L11.6953 10.0508L17.4141 4.35547L19.7109 6.65234V0.652344H13.7109L16.0078 2.92578L11.6953 7.23828L7.71094 3.23047L0 10.9414L1.40625 12.3477L7.71094 6.06641Z" fill="white"></path>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2_588">
                                                <rect width="19.7109" height="11.6953" fill="white" transform="translate(0 0.652344)"></rect>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </div>
                                <div class="button-middle-header">
                                    <ul class="btn-list-middle-header d-md-flex justify-content-left align-items-center gap-3 mt-4">
                                        <li>
                                            <a href="{{url('tag/ Tech Kiệm')}}" class="btn-middle-header" type="button" class="btn">Tech Kiệm</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="hide-mobile col-md-6 z d-sm-flex justify-content-end align-items-center">
                                    @if(\Illuminate\Support\Facades\Auth::check())
                                        <div class="dropdown user-login-dropdown">
                                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                {{\Illuminate\Support\Facades\Auth::user()->name}}
                                            </a>
                                            <ul class="dropdown-menu menu-item-dropdown">
                                                @if (!(\Illuminate\Support\Facades\Auth::user()->hasRole('user')))
                                                <li><a class="dropdown-item" href="{{url('admin/dashboard')}}">Trang quản trị</a></li>
                                                    <li><hr class="dropdown-divider" /></li>
                                                @endif()
                                                <li>
                                                <form role="form" action="{{ url('logout') }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                            style="outline: none; border: none; background-color: transparent;display: flex;">
                                                        <span class="nav-link-text ms-1" style="font-size:14px; margin-top:4px;">Log Out</span>
                                                    </button>
                                                </form>
                                                </li>
                                            </ul>
                                        </div>
                                    @else
                                    <div class="login-header">
                                        <a href="{{ url('/login')}}">Đăng nhập</a>
                                    </div>
                                    @endif
                                        <div class="search-bar-header position-relative top-4">
                                            <form method="GET" action="{{url('search')}}">
                                                <svg id="icon-search-bar" class="position-absolute top-5 end-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"><path d="M18.031 16.6168L22.3137 20.8995L20.8995 22.3137L16.6168 18.031C15.0769 19.263 13.124 20 11 20C6.032 20 2 15.968 2 11C2 6.032 6.032 2 11 2C15.968 2 20 6.032 20 11C20 13.124 19.263 15.0769 18.031 16.6168ZM16.0247 15.8748C17.2475 14.6146 18 12.8956 18 11C18 7.1325 14.8675 4 11 4C7.1325 4 4 7.1325 4 11C4 14.8675 7.1325 18 11 18C12.8956 18 14.6146 17.2475 15.8748 16.0247L16.0247 15.8748Z" fill="rgba(255,255,255,1)"></path></svg>
                                                <input id="search-text-bar" class="top-5 end-8 position-absolute" type="search" name="search" placeholder="Tìm kiếm ở đây...">
                                            </form>
                                                <ul class="results_search">

                                                </ul>
                                        </div>
                            </div>
                        </div>
                    </div>
                    <div class="bottom-header mt-8">
                        <div class="row">
                            <div class="col-md-10">
                                <ul class="list-category-header hide-mobile d-sm-flex justify-content-start align-items-center gap-7">
                                    @foreach(\App\Models\Admin\Category::where('parent_id', 0)->limit(8)->get() as $category)
                                        <li class="nav-item dropdown position-relative dropdown-category">
                                            <div>
                                                <a class="dropdown" href="{{url('category/'.$category->slug)}}">{{$category->name}}</a>
                                                @if(\App\Models\Admin\Category::where('parent_id', $category->id)->count() > 0)
                                                    <div class="dropdown-item item-category position-absolute">
                                                    @foreach(\App\Models\Admin\Category::where('parent_id', $category->id)->get() as $item)
                                                        <a class="my-3" href="{{url('category/' .$item->slug)}}">{{$item->name}}</a>
                                                    @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <nav>

    </nav>

    <main style="background: #e7e7e7">
        <div class="container mt-20 mb-20 ">
        <img style="object-fit: cover; width: 100%;" src="{{asset('image/download.png')}}" alt="banner">
         <div class="ps-6 detail-main">

                    @section('content')
                    @show

                            @yield('banner')

            <div class="row">
                <div class="col-sm-12">
                    @yield('bottom-main')
                </div>
            </div>
         </div>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="logo-footer">
                    <div class="mt-2 middle-navbar-item-logo">
                        <svg style="margin-top: -9px !important;" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="28" height="28"><path d="M12 3.09747L7.05025 8.04722C4.31658 10.7809 4.31658 15.213 7.05025 17.9467C9.78392 20.6804 14.2161 20.6804 16.9497 17.9467C19.6834 15.213 19.6834 10.7809 16.9497 8.04722L12 3.09747ZM12 0.269043L18.364 6.633C21.8787 10.1477 21.8787 15.8462 18.364 19.3609C14.8492 22.8756 9.15076 22.8756 5.63604 19.3609C2.12132 15.8462 2.12132 10.1477 5.63604 6.633L12 0.269043ZM7 12.997H17C17 15.7584 14.7614 17.997 12 17.997C9.23858 17.997 7 15.7584 7 12.997Z" fill="rgba(100,205,138,1)"></path></svg>
                        <a href="{{url('/')}}" style="color: #4cc170;" class="mt-3 ms-1 text-uppercase fw-bold text-decoration-none fs-3 text-bs-indigo">NEWS</a>
                    </div>
            </div>
            <hr style="color: white">
            <div class="item-footer">
                <div class="d-flex mt-2 justify-content-left align-items-center gap-5">
                    <ul class="list-category-header hide-mobile d-sm-flex justify-content-start align-items-center gap-7">
                        @foreach(\App\Models\Admin\Category::where('parent_id', 0)->whereNot(function ($query) { $query->where('id', 7);})->limit(8)->get() as $category)
                            <li>
                                <a href="{{url('category/'. $category->slug)}}">{{$category->name}}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="horizon-footer mt-2">
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 content-left-footer mb-5">
                    <p>
                        Chịu trách nhiệm quản lý nội dung: Bà Nguyễn Bích Minh
                        <br>
                        Hà Nội: Tầng 20, Tòa nhà Center Building - Hapulico Complex, Số 1 Nguyễn Huy Tưởng, Thanh Xuân, Hà Nội.
                        <br>
                        Email: <span>info@genk.vn</span>
                        <br>
                        Điện thoại: 024.73095555, máy lẻ 62374
                        <br>
                        VPĐD tại TP.HCM: Tầng 4, Tòa nhà 123
                        <br>
                        Võ Văn Tần, Phường 6, Quận 3, Tp. Hồ Chí Minh
                    </p>

                    <p class="mt-3">
                        © Copyright 2010 - 2023 - Công ty Cổ phần VCCorp
                        <br>
                        Tầng 17, 19, 20, 21 Toà nhà Center Building - Hapulico Complex, Số 1 Nguyễn Huy Tưởng, Thanh Xuân, Hà Nội.
                        <br>
                        Giấy phép thiết lập trang thông tin điện tử tổng hợp trên mạng số 460/GP-TTĐT do Sở Thông tin và Truyền thông Hà Nội cấp ngày 03/02/2016
                    </p>
                </div>
                <div class="col-md-6">
                    <div class="right-content-footer">
                        <img src="https://vccorp.mediacdn.vn/vccorp-m.png" alt="logo vccorp">
                        <h4 class="advertise-footer mt-3">Liên hệ quảng cáo</h4>
                        <p style="color:#eeeeee; font-size: 13px;">
                            Hotline hỗ trợ quảng cáo: 0794463333 - 0961984388
                            <br>
                            <br>
                            Email: <span style="color: red">giaitrixahoi@admicro.vn</span>
                            <br>
                            Hỗ trợ & CSKH: Admicro
                            <br>
                            Address: Tầng 20, Tòa nhà Center Building - Hapulico Complex, Số 1 Nguyễn Huy Tưởng, Thanh Xuân, Hà Nội.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>



    <!-- Javascript Files: Vendors -->
    <script src="https://unpkg.com/browse/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let searchNavbar = document.querySelector('#icon-search-bar');
        let inputSearchNavbar = document.querySelector('#search-text-bar');
        let searchResult = document.querySelector('.results_search');
        searchNavbar.addEventListener('click', () =>{
            inputSearchNavbar.classList.toggle('active');
        });
        searchProduct();

        // Lấy Value ở ô input

        function searchProduct() {
            inputSearchNavbar.addEventListener('keyup', function(e) {
                if (e.target.value) {
                    send(e.target.value.trim());
                    searchResult.style.display = 'block';
                } else {
                    searchResult.style.display = 'none';
                }
            })

            document.addEventListener('click', (e) => {
                if (e.target != searchResult) {
                    searchResult.style.display = "none";
                }
            })
        }

        async function send(data) {
            const res = await fetch(`http://127.0.0.1:8000/searchAPI?key=${data}`)
                .then((response) => response.json())
                .then((data) => {
                    show(data);
                })
                .catch((error) => {
                    console.error("Error:", error);
                });
        }

        function show(data) {
            if(data.results.length > 0) {
                let output = '';
                data.results.map((item)=> {
                   output +=
                   `
                        <li>
                                <a class="d-sm-flex" href="{{url('detail/${item.id}' )}}">
                                <img class="me-2" src="{{asset('storage/image/${item.avatar}')}}" alt="${item.title}">
                                        <p class="mt-3">${(item.title).substring(0,50)}</p>
                                </a>
                        </li>
                   `;
                    searchResult.innerHTML = output;
                });
            }else {
                searchResult.innerHTML = `'<li> <span> Không tìm thấy sản phẩm </span></li>';`
            }
        }



        let barChat = document.querySelector('.bar-chat');
        let menuHide = document.querySelector('.menu-item-hide');
        let overlay = document.querySelector('.overlay');
        let closeMenu = document.querySelector('.close-menu');


        barChat.addEventListener('click', ()=> {
            menuHide.classList.add('active');
            overlay.classList.add('active');
        })

        closeMenu.addEventListener('click', ()=> {
            menuHide.classList.remove('active');
            overlay.classList.remove('active');
        })

        function hasClass(element, className) {
            return element.classList.contains(className);
        }


        function removeActiveClass() {
            menuHide.classList.remove('active');
            overlay.classList.remove('active');
        }

        overlay.addEventListener('click', () => {
            if (hasClass(menuHide, 'active')) {
                removeActiveClass();
            }
        });

        closeMenu.addEventListener('click', () => {
            removeActiveClass();
        });

        // Tao Toast
        const notifications = document.querySelector('.notification');
        const toast = document.querySelector('.toasts');
        const timer = 3000;

        const removeToast = (toast) => {
            toast.classList.add("hide");
            if (toast.timeoutId) clearTimeout(toast.timeoutId);
            setTimeout(() => toast.remove(), 400);
        };


        function createErrorToast(toastMessage) {
            const toast = document.createElement('li');
            toast.className = `toasts error`;
            toast.innerHTML = `
                <div class="column">
                    <i class="ri-bug-line"></i>
                    <span>${toastMessage}</span>
                </div>
           <i class="ri-close-line"></i>
                `
            notifications.appendChild(toast);
            setTimeout(() => removeToast(toast), 3000)
        };

        function createSuccessToast(message) {
            const toast = document.createElement('li');
            toast.className = `toasts success`;
            toast.innerHTML = `
                        <div class="column">
                              <i class="ri-check-line"></i>
                            <span>${message}</span>
                        </div>
                      <i class="ri-close-line"></i>
                        `
            notifications.appendChild(toast);
            setTimeout(() => removeToast(toast), 3000)
        };
    </script>

    @section('javascript')
    @show

    @if (Session::has('success') || Session::has('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                function removeToast(toast) {
                    toast.classList.add("hide");
                    if (toast.timeoutId) clearTimeout(toast.timeoutId);
                    setTimeout(() => toast.remove(), 400);
                }

                setTime();

                function setTime() {
                    setTimeout(() => removeToast(toast), 3000)
                }
            });
        </script>
    @endif
</body>

