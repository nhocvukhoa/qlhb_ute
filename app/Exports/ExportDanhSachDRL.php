<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Modules\User\Entities\User;
use Illuminate\Contracts\View\View;
use App\Models\DiemRenLuyen;

class ExportDanhSachDRL implements FromView, ShouldAutoSize, WithEvents
{
    private $diemrenluyen;

    public function __construct($diemrenluyen)
    {
        $this->diemrenluyen = $diemrenluyen;
    }

    /**
     * @return View
     */
    public function view(): View
    {
        return view('Admin.CanBoKhoa.DiemRenLuyen.filter', ['diemrenluyen' => $this->diemrenluyen]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

}
