<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\SinhVienCanBo;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ImportDanhSachSVCB implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SinhVienCanBo([
            'hocky' => $row['hocky'],
            'masinhvien' => $row['masinhvien'],
            'tensinhvien' => $row['tensinhvien'],
            'ngaysinh' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ngaysinh']),
            'khoa' => $row['khoa'],
            'nganh' => $row['nganh'],
            'lop' => $row['lop'],
            'chucvu' => $row['chucvu'],
            'diemthuong' => $row['diemthuong'],
        ]);
    }
}
