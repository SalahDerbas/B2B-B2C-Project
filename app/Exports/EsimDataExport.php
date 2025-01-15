<?php
namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;

class EsimDataExport implements FromQuery, WithHeadings ,WithMapping
{
    /**
     * Constructor function for initializing the category ID.
     *
     * @author Salah Derbas
     * @param mixed|null $categoryId The ID of the category (optional).
     */
    protected $categoryId;
    public function __construct($categoryId = null)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * Main query function for retrieving filtered items.
     *
     * @author Salah Derbas
     * @return \Illuminate\Database\Eloquent\Builder The query builder with applied filters and relationships.
     */
    public function query()
    {
        return Item::query()
            ->where('status', true)
            ->when($this->categoryId, function ($query) {
                return $query->where('sub_category_id', $this->categoryId);
            })
            ->with(['getSubCategory', 'getItemSource.getPaymentPriceB2b']);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */

    public function headings(): array
    {
        return [
            '#',
            'Name',
            'Capacity',
            'Plan Type',
            'Validity',
            'Price',
            'Created At',
        ];
    }

    /**
     * Map data for each row.
     */
    public function map($item): array
    {
        return [
            $item->id,
            $item->getSubCategory->name ?? 'N/A',
            $item->capacity ?? 'N/A',
            $item->plan_type ?? 'N/A',
            $item->validaty ?? 'N/A',
            number_format($item->getItemSource->getPaymentPriceB2b->final_price ?? 0, 2),
            $item->created_at->format('Y-m-d'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle($sheet->calculateWorksheetDimension())
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A1:Z1")
            ->getAlignment()
            ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
            ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A1:Z1")
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB("29AFE4");
        $sheet->getStyle("A1:Z1")
            ->getFont()
            ->getColor()
            ->setARGB("FFFFFF");
        $sheet->getStyle("A1:Z1")->getFont()->setBold(true);
    }
}
