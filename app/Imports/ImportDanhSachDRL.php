<?php

namespace App\Imports;

use App\Models\DiemRenLuyen;
use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportDanhSachDRL implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model(array $row)
    {
        return new DiemRenLuyen([
            'diemrenluyen_hocky' => $row['diemrenluyen_hocky'],
            'diemrenluyen_msv' => $row['diemrenluyen_msv'],
            'diemrenluyen_tensv' => $row['diemrenluyen_tensv'],
            'diemrenluyen_ngaysinh' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['diemrenluyen_ngaysinh']),
            'diemrenluyen_khoa' => $row['diemrenluyen_khoa'],
            'diemrenluyen_nganh' => $row['diemrenluyen_nganh'],
            'diemrenluyen_lop' => $row['diemrenluyen_lop'],
            'diemrenluyen_diem' => $row['diemrenluyen_diem'],
            'diemrenluyen_xeploai' => $row['diemrenluyen_xeploai'],
        ]);
    }
}
