@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thống kê số lượng sinh viên đăng ký và được nhận của mỗi học bổng</h6>
    </div>
    <div class="card-body">
        <div id="columnchart_material" style="width: 1000px; height: 500px;"></div>
        <div class="table-responsive" style="margin-top: 30px;">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên học bổng</th>
                        <th>Số lượng sinh viên đăng ký</th>
                        <th>Số lượng sinh viên được nhận học bổng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($total_studentApply as $key => $item )
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$item->hocbong_ten}}</td>
                        <td>{{$item->total_apply}}</td>
                        <td>
                            {{$item->total_accept}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    google.charts.load('current', {
        packages: ['corechart', 'bar']
    });
    google.charts.setOnLoadCallback(drawStacked);

    function drawStacked() {
        var data = google.visualization.arrayToDataTable([
            ['Học bổng', 'Số lượng đăng ký', 'Số lượng được nhận'],
            <?php echo $chartData; ?>
        ]);

        var options = {
            title: 'THÔNG KÊ SỐ LƯỢNG SINH VIÊN ĐĂNG KÝ VÀ SỐ LƯỢNG SINH VIÊN NHẬN HỌC BỔNG',
            titleTextStyle: {
                    color: "#000",
                    fontName: "Roboto",
                    fontSize: 16,
                    bold: true,
                    italic: false,
            },
            vAxis: {
                format: '0',
                title: 'SỐ LƯỢNG',
                titleTextStyle: {
                    color: "#000",
                    fontName: "Roboto",
                    fontSize: 16,
                    bold: true,
                    italic: false
                }
            },
            hAxis: {
                title: 'HỌC BỔNG',
                titleTextStyle: {
                    color: "#000",
                    fontName: "Roboto",
                    fontSize: 16,
                    bold: true,
                    italic: false
                }
            },
        };


        var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_material'));
        chart.draw(data, options);
    }
</script>
@endsection