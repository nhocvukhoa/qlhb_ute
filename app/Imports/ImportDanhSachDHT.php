<?php

namespace App\Imports;


use App\Models\DiemHocTap;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportDanhSachDHT implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new DiemHocTap([
            'diemhoctap_hocky' => $row['diemhoctap_hocky'],
            'diemhoctap_msv' => $row['diemhoctap_msv'],
            'diemhoctap_tensv' => $row['diemhoctap_tensv'],
            'diemhoctap_ngaysinh' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['diemhoctap_ngaysinh']),
            'diemhoctap_khoa' => $row['diemhoctap_khoa'],
            'diemhoctap_nganh' => $row['diemhoctap_nganh'],
            'diemhoctap_lop' => $row['diemhoctap_lop'],
            'diemhoctap_tinchi' => $row['diemhoctap_tinchi'],
            'diemhoctap_thang4' => $row['diemhoctap_thang4'],
            'diemhoctap_thang10' => $row['diemhoctap_thang10'],
            'diemhoctap_xeploai' => $row['diemhoctap_xeploai'],
        ]);
    }
}