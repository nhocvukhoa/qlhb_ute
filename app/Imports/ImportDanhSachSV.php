<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use App\Models\User;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportDanhSachSV implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => $row['password'],
            'quyen' => $row['quyen'],
            'lop_id' => $row['lop_id'],
            'fullname' => $row['fullname'],
            'diachi' => $row['diachi'],
            'sdt' => $row['sdt'],
            'gioitinh' => $row['gioitinh'],
            'tinhtrang' => $row['tinhtrang'],
            'ngaysinh' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['ngaysinh']),
        ]);
    }
}
