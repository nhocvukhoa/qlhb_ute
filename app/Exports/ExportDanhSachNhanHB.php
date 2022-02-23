<?php

namespace App\Exports;

use App\Models\DangKyHocBong;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ExportDanhSachNhanHB implements FromCollection, WithHeadings, WithStrictNullComparison
{

    protected $hocbong_id;
    public function __construct($hocbong_id)
    {
        $this->hocbong_id = $hocbong_id;
    }

    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
            'Mã sinh viên',
            'Tên sinh viên',
            'Ngành',
            'Lớp',
        ];
    }

    public function collection()
    {
        $dangKyHocBong = new DangKyHocBong();
        return $dangKyHocBong->getDangKyHocBong($this->hocbong_id);
    }
}
