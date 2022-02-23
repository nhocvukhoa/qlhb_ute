<?php

namespace App\Imports;
use App\Models\Diem;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportDanhSachDiem implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Diem([
            'diem_hocky' => $row['diem_hocky'],
            'diem_masv' => $row['diem_masv'],
            'diem_tensv' => $row['diem_tensv'],
            'diem_ngaysinh' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['diem_ngaysinh']),
            'diem_khoa' => $row['diem_khoa'],
            'diem_nganh' => $row['diem_nganh'],
            'diem_lop' => $row['diem_lop'],
            'diem_tinchi' => $row['diem_tinchi'],
            'diem_thang4' => $row['diem_thang4'],
            'diem_thang10' => $row['diem_thang10'],
            'diem_renluyen' => $row['diem_renluyen'],
            'diem_loaihocluc' => $row['diem_loaihocluc'],
            'diem_loairenluyen' => $row['diem_loairenluyen'],
        ]);
    }
}
