<?php
namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;

class ItemExport implements FromQuery, WithHeadings ,WithMapping
{
    /**
     * Constructor function for initializing the item ID.
     *
     * @author Salah Derbas
     * @param mixed|null $id The ID of the item (optional).
     */
    protected $sub_category_id;
    public function __construct($sub_category_id = null)
    {
        $this->sub_category_id = $sub_category_id;
    }
    /**
     * Query function for retrieving an item by its ID with related data.
     *
     * @author Salah Derbas
     * @return \Illuminate\Database\Eloquent\Builder The query builder with applied filters and relationships.
     */
    public function query()
    {
        $query = Item::query()->with(['getSubCategory' , 'getItemSource.getSource']);

        if (!is_null($this->sub_category_id))
            $query->where('sub_category_id', $this->sub_category_id);

        return $query;
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
            'Main Category',
            'Capacity',
            'Plan Type',
            'Validaty',
            'Status',
            'Package ID',
            'Source',
            'Cost Price',
            'Retail Price',
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
            $item->status ?? 'N/A',
            $item->getItemSource->package_id ?? 'N/A',
            $item->getItemSource->getSource->name ?? 'N/A',
            $item->getItemSource->cost_price ?? 'N/A',
            $item->getItemSource->retail_price ?? 'N/A',
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
