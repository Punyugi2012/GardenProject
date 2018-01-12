@extends('layouts.app')
@section('title', 'หน้าหลัก')
@section('breadcrumb')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb"  style="margin-bottom:0px!important">
        <li class="breadcrumb-item active" aria-current="page">หน้าหลัก</li>
    </ol>
</nav>
@endsection
@section('content')
<style>
    *,
    *:before,
    *:after {
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }
    .group:after {
        content: "";
        display: table;
        clear: both;
    }
    img {
        max-width: 100%;
        height: auto;
        vertical-align: baseline;
    }
    a {
        text-decoration: none;
    }
    .calendar-wrapper {
        width: 360px;
        margin: 3em auto;
        padding: 2em;
        border: 1px solid #dcdcff;
        border-radius: 5px;
        background: #fff;
    }
    table {
        clear: both;
        width: 100%;
        border: 1px solid #dcdcff;
        border-radius: 3px;
        border-collapse: collapse;
        color: #444;
    }
    td {
        height: 48px;
        text-align: center;
        vertical-align: middle;
        border-right: 1px solid #dcdcff;
        border-top: 1px solid #dcdcff;
        width: 14.28571429%;
    }
    td.not-current {
        color: #c0c0c0;
    }
    td.today {
        font-weight: 700;
        color: #28283b;
        font-size: 1.5em;
    }
    thead td {
        border: none;
        color: #28283b;
        text-transform: uppercase;
        font-size: 1.5em;
    }
    #btnPrev {
        float: left;
        margin-bottom: 20px;
    }
    #btnPrev:before {
        padding-right: 4px;
    }
    #btnNext {
        float: right;
        margin-bottom: 20px;
    }
    #btnNext:after {
        padding-left: 4px;
    }
    #btnPrev,
    #btnNext {
        background: transparent;
        border: none;
        outline: none;
        font-size: 1em;
        color: #c0c0c0;
        cursor: pointer;
        text-transform: uppercase;
        -webkit-transition: all 0.3s ease;
        transition: all 0.3s ease;
    }
    #btnPrev:hover,
    #btnNext:hover {
        color: #28283b;
        font-weight: bold;
    }
</style>
<div class="calendar-wrapper">
    <button id="btnPrev" type="button">ก่อนหน้า</button>
    <button id="btnNext" type="button">ถัดไป</button>
    <div id="divCal"></div>
</div>  
@endsection
@section('footer')
    <script type="text/javascript">
        var Cal = function(divId) {
            this.divId = divId;
            this.DaysOfWeek = [
                'อา',
                'จ',
                'อ',
                'พ',
                'พฤ',
                'ศ',
                'ส'
            ];          
            // Months, stating on January
            this.Months = ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.' ];
            
            // Set the current month, year
            var d = new Date();
            
            this.currMonth = d.getMonth();
            this.currYear = d.getFullYear();
            this.currDay = d.getDate();
            
            };
            
            // Goes to next month
            Cal.prototype.nextMonth = function() {
            if ( this.currMonth == 11 ) {
                this.currMonth = 0;
                this.currYear = this.currYear + 1;
            }
            else {
                this.currMonth = this.currMonth + 1;
            }
            this.showcurr();
            };
            
            // Goes to previous month
            Cal.prototype.previousMonth = function() {
            if ( this.currMonth == 0 ) {
                this.currMonth = 11;
                this.currYear = this.currYear - 1;
            }
            else {
                this.currMonth = this.currMonth - 1;
            }
            this.showcurr();
            };
            
            // Show current month
            Cal.prototype.showcurr = function() {
            this.showMonth(this.currYear, this.currMonth);
            };
            
            // Show month (year, month)
            Cal.prototype.showMonth = function(y, m) {
            
            var d = new Date()
            // First day of the week in the selected month
            , firstDayOfMonth = new Date(y, m, 1).getDay()
            // Last day of the selected month
            , lastDateOfMonth =  new Date(y, m+1, 0).getDate()
            // Last day of the previous month
            , lastDayOfLastMonth = m == 0 ? new Date(y-1, 11, 0).getDate() : new Date(y, m, 0).getDate();
            
            
            var html = '<table>';
            
            // Write selected month and year
            html += '<thead><tr>';
            html += '<td colspan="7">' + this.Months[m] + ' ' + y + '</td>';
            html += '</tr></thead>';
            
            
            // Write the header of the days of the week
            html += '<tr class="days">';
            for(var i=0; i < this.DaysOfWeek.length;i++) {
                html += '<td>' + this.DaysOfWeek[i] + '</td>';
            }
            html += '</tr>';
            
            // Write the days
            var i=1;
            do {
            
                var dow = new Date(y, m, i).getDay();
            
                // If Sunday, start new row
                if ( dow == 0 ) {
                html += '<tr>';
                }
                // If not Sunday but first day of the month
                // it will write the last days from the previous month
                else if ( i == 1 ) {
                html += '<tr>';
                var k = lastDayOfLastMonth - firstDayOfMonth+1;
                for(var j=0; j < firstDayOfMonth; j++) {
                    html += '<td class="not-current">' + k + '</td>';
                    k++;
                }
                }
            
                // Write the current day in the loop
                var chk = new Date();
                var chkY = chk.getFullYear();
                var chkM = chk.getMonth();
                if (chkY == this.currYear && chkM == this.currMonth && i == this.currDay) {
                html += '<td class="today">' + i + '</td>';
                } else {
                html += '<td class="normal">' + i + '</td>';
                }
                // If Saturday, closes the row
                if ( dow == 6 ) {
                html += '</tr>';
                }
                // If not Saturday, but last day of the selected month
                // it will write the next few days from the next month
                else if ( i == lastDateOfMonth ) {
                var k=1;
                for(dow; dow < 6; dow++) {
                    html += '<td class="not-current">' + k + '</td>';
                    k++;
                }
                }
            
                i++;
            }while(i <= lastDateOfMonth);
            
            // Closes table
            html += '</table>';
            
            // Write HTML to the div
            document.getElementById(this.divId).innerHTML = html;
            };
            
            // On Load of the window
            window.onload = function() {
            
            // Start calendar
            var c = new Cal("divCal");			
            c.showcurr();
            
            // Bind next and previous button clicks
            getId('btnNext').onclick = function() {
                c.nextMonth();
            };
            getId('btnPrev').onclick = function() {
                c.previousMonth();
            };
            }
            
            // Get element by id
            function getId(id) {
            return document.getElementById(id);
            }
    </script>
@endsection