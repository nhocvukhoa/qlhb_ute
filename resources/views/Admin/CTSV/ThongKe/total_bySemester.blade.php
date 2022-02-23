@extends('admin_layout')
@section('admin_content')
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary text-center">Thống kê số lượng học bổng trong từng kỳ</h6>
    </div>
    <div class="card-body">
        <div id="columnchart_material" style="width: 1000px; height: 500px; margin-bottom: 30px;"></div>
        <div class="table-responsive">
            <table class="table table-bordered" id="loaihocbong_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên học kỳ</th>
                        <th>Số lượng</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($total_bysemester as $key => $item)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>Học kỳ {{$item->hocky_ten}}</td>
                        <td>
                            @if($item->total_bySemester !=0)
                            {{$item->total_bySemester}}
                            @else
                            Không có học bổng
                            @endif
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
        'packages': ['bar']
    });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Học kỳ', 'Số lượng'],
            <?php echo $chartData; ?>
        ]);

        var options = {
            title: 'THỐNG KÊ SỐ LƯỢNG HỌC BỔNG TRONG TỪNG HỌC KỲ',
            legend:{
                textStyle:{
                    fontSize: 16,
                    fontName: "Roboto"
                }
            },
            titleTextStyle: {
                    color: "#000",
                    fontName: "Roboto",
                    fontSize: 16,
                    bold: true,
                    italic: false,
            },
            hAxis: {
                title: 'HỌC KỲ',
                titleTextStyle: {
                    color: "#000",
                    fontName: "Roboto",
                    fontSize: 14,
                    bold: true,
                    italic: false
                }
            },
            vAxis: {
                title: 'SỐ LƯỢNG',
                titleTextStyle: {
                    color: "#000",
                    fontName: "Roboto",
                    fontSize: 14,
                    bold: true,
                    italic: false
                }
            },
           
         
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));
        chart.draw(data, google.charts.Bar.convertOptions(options));
    }
</script>
@endsection