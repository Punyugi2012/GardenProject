<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Prompt" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
    <link href="{{ asset('css/lity.min.css') }}" rel="stylesheet">
    @yield('head')
    <style>
        body {
            font-family: 'Prompt', sans-serif;
            background-color: #f5f8fa;
        }
        .flex-column .nav-item {
            margin-top:10px;
        }
        .card-header {
            background-color: #31698A;
            color:#fff;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg justify-content-between"  style="border: 1px solid #d3e0e9;background-color:#fff">
        <span>
            <a class="navbar-brand" href="{{url('/')}}" style="margin-right:50px"><h1>สวนลุงเด่น</h1></a>
            <a class="btn btn-primary {{Request::segment(1) == 'employees' ? 'active' : ''}}" href="{{url('/employees')}}">พนักงาน</a>
            <a class="btn btn-primary {{Request::segment(1) == 'items' ? 'active' : ''}}" href="{{url('/items')}}">วัตถุดิบ</a>
            <a class="btn btn-primary {{Request::segment(1) == 'shops' ? 'active' : ''}}" href="{{url('/shops')}}">ร้านค้า</a>
            <a class="btn btn-primary" href="{{url('/zones')}}">โซน</a>
            <a class="btn btn-primary" href="{{url('/products')}}">ผลผลิต</a>
            <div>
                <div id="time"></div>
            </div>
        </span>
        <ul class="navbar-nav">
            @if (Auth::guest())
                <li><a href="{{ route('login') }}">เข้าสู่ระบบ</a></li>
            @else
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link btn btn-warning" data-toggle="dropdown" role="button" aria-expanded="false">
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                ออกจากระบบ
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </nav>
    <div class="container-fluid" style="margin-top:20px;margin-bottom:20px">
        @yield('breadcrumb')
        <div class="row">
            <div class="col-md-2">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link btn btn-info {{Request::segment(1) == 'attendances' ? 'active' : ''}}" href="{{url('/attendances')}}">การลงเวลาทำงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info {{Request::segment(1) == 'salaries' ? 'active' : ''}}" href="{{url('/salaries')}}">การจ่ายเงินเดือน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info {{Request::segment(1) == 'leaves' ? 'active' : ''}}" href="{{url('/leaves')}}">การลางาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info {{Request::segment(1) == 'purchases' || Request::segment(1) == 'claims' || Request::segment(1) == 'receiptclaims' || Request::segment(1) == 'edit-claims_detail' || Request::segment(1) == 'receipts' ? 'active' : ''}}" href="{{url('/purchases')}}">การสั่งซื้อ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info {{Request::segment(1) == 'payments' ? 'active' : ''}}" href="{{url('/payments')}}">การจ่ายเงิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" href="{{url('/assignments')}}">การมอบหมายงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" href="{{url('/takes')}}">การเบิก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" href="{{url('/reports')}}">การรายงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" href="{{url('/returnings')}}">การคืนจากการเบิก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" href="{{url('/deductions')}}">การหักเงิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" href="{{url('/harvests')}}">การเก็บเกี่ยว</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-info" href="{{url('/sales')}}">การขาย</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-10">
                @yield('content')
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.js"></script>
    <script src="{{ asset('js/lity.min.js') }}"></script>
    @yield('footer')
    <script type="text/javascript">
        $(document).ready(function() {
            $('.dataTables_filter input').addClass('rounded border border-secondary');
        });
        (function () {
            function checkTime(i) {
                return (i < 10) ? "0" + i : i;
            }
        
            function startTime() {
                var today = new Date(),
                    h = checkTime(today.getHours()),
                    m = checkTime(today.getMinutes()),
                    s = checkTime(today.getSeconds());
                document.getElementById('time').innerHTML = h + ":" + m + ":" + s + " น.";
                t = setTimeout(function () {
                    startTime()
                }, 500);
            }
            startTime();
        })();
    </script>
</body>
</html>
