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
        }
        .flex-column .nav-item {
            margin-top:10px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand" href="#"><h1>สวนลุงเด่น</h1></a>
    </nav>
    <div class="container-fluid" style="margin-top:20px;margin-bottom:20px">
        <div class="row">
            <div class="col-md-2">
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/employees')}}">พนักงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/items')}}">วัตถุดิบ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/shops')}}">ร้านค้า</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/zones')}}">โซน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/assignments')}}">การมอบหมายงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/attendances')}}">การลงเวลาทำงาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/salaries')}}">การจ่ายเงินเดือน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/leaves')}}">การลางาน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/purchases')}}">การสั่งซื้อ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/receipts')}}">การรับวัตถุดิบ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/payments')}}">การจ่ายเงิน</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/claims')}}">การเคลม</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/receiptclaims')}}">รับวัตถุดิบจากการเคลม</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/takes')}}">การเบิก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/returnings')}}">การคืนจากการเบิก</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-light" href="{{url('/deductions')}}">การหักเงิน</a>
                    </li>
                    {{--  <li class="nav-item">
                        <div class="btn-group" style="width:100%!important">
                            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width:100%!important">
                                เครื่องมือ
                            </button>
                            <div class="dropdown-menu dropdown-menu-left">
                                <a class="dropdown-item" href="{{url('/attendances')}}">การลงเวลาทำงาน</a>
                                <a class="dropdown-item" href="{{url('/salaries')}}">การจ่ายเงินเดือน</a>
                                <a class="dropdown-item" href="{{url('/leaves')}}">การลางาน</a>
                                <a class="dropdown-item" href="{{url('/purchases')}}">การสั่งซื้อ</a>
                                <a class="dropdown-item" href="{{url('/receipts')}}">การรับวัตถุดิบ</a>
                                <a class="dropdown-item" href="{{url('/payments')}}">การจ่ายเงิน</a>
                                <a class="dropdown-item" href="{{url('/claims')}}">การเคลม</a>
                                <a class="dropdown-item" href="{{url('/receiptclaims')}}">รับวัตถุดิบจากการเคลม</a>
                                <a class="dropdown-item" href="{{url('/takes')}}">การเบิก</a>
                                <a class="dropdown-item" href="{{url('/returnings')}}">การคืนจากการเบิก</a>
                                <a class="dropdown-item" href="{{url('/deductions')}}">การหักเงิน</a>
                            </div>
                        </div>
                    </li>  --}}
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
            $('#table_id_filter input').addClass('rounded border border-secondary');
        });
    </script>
</body>
</html>
