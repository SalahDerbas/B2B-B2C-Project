<?php
namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromQuery, WithHeadings ,WithMapping
{

    /**
     * Constructor function for initializing the order ID.
     *
     * @author Salah Derbas
     * @param mixed|null $id The ID of the order (optional).
     */
    protected $id;
    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Query function for retrieving an order by its ID with related data.
     *
     * @author Salah Derbas
     * @return \Illuminate\Database\Eloquent\Builder The query builder with applied filters and relationships.
     */
    public function query()
    {
        return Order::query()
            ->where('id', $this->id)
            ->with(['getUser' ,'getItem' ,'getStatusOrder' ,'getStatusPackage' ,'getCategory']);
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
            'Email',
            'Price',
            'ICCID',
            'Category',
            'Item',
            'User',
            'Status Order',
            'Status Package',
            'Order Data',
            'Created At',
            'Updated At',
        ];
    }

    /**
     * Map data for each row.
     */
    public function map($item): array
    {
        return [
            $item->id,
            $item->email ?? 'N/A',
            number_format($item->final_price ?? 0, 2),
            $item->iccid ?? 'N/A',
            $item->getCategory->name ?? 'N/A',
            '('.$item->getItem->capacity.')-('.$item->getItem->plan_type.')-('.$item->getItem->validaty.')' ?? 'N/A',
            '('.$item->getUser->name.')-('.$item->getUser->email.')',
            $item->getStatusOrder->value,
            $item->getStatusPackage->value,
            env('APP_URL').'webview/order/callback-success/'.encryptWithKey( $item['id'] , 'B2B-B2C') .'',
            formatDate($item->created_at),
            formatDate($item->updated_at),
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
