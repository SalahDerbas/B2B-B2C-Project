@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'API Orders')

@section('content')
<div class="row">
    <div class="col-md-12 mb-30">
        <div class="card card-statistics h-100">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif



                <h1 class="mb-4">API Orders</h1>
                <div class="row">
                    <form action="{{ route('b2b.api_orders.index') }}" method="GET" class="d-flex align-items-end w-100">
                        <div class="col-3">
                            <label for="status_order_id" class="form-label">Status Orders</label><br />
                            <select class="form-select" id="status_order_id" name="status_order_id" style="width: 100%">
                                <option class="text-center"  value="" selected>All</option>
                                @if(!empty($statusOrders))
                                    @foreach($statusOrders as $statusOrder)
                                        <option class="text-center" value="{{ $statusOrder->id }}" {{ request('status_order_id') == $statusOrder->id ? 'selected' : '' }}>
                                            {{ $statusOrder->value }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="status_package_id" class="form-label">Status Packages</label><br />
                            <select class="form-select" id="status_package_id" name="status_package_id" style="width: 100%">
                                <option class="text-center"  value="" selected>All</option>
                                @if(!empty($statusPackages))
                                    @foreach($statusPackages as $statusPackage)
                                        <option class="text-center" value="{{ $statusPackage->id }}" {{ request('status_package_id') == $statusPackage->id ? 'selected' : '' }}>
                                            {{ $statusPackage->value }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-primary mx-2">Filter</button>
                            <a href="{{ route('b2b.api_orders.export', ['status_order_id' => request('status_order_id') , 'status_package_id' => request('status_package_id')]) }}" class="btn btn-success">Export Excel</a>

                        </div>
                    </form>
                </div>


                <div class="table-responsive">
                    <table id="datatable" class="table  table-hover table-sm table-bordered p-0" style="text-align: center">
                    <thead>
                            <tr>
                                <th> # </th>
                                <th> Email </th>
                                <th> Final Price </th>
                                <th> ICCID </th>
                                <th> Category </th>
                                <th> Item </th>
                                <th> User </th>
                                <th> Status Order </th>
                                <th> Status Package </th>
                                <th> Order Data </th>
                                <th> Created At </th>
                                <th> Updated At </th>
                                <th> Actions </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($datas as $index => $item)
                                <tr>
                                    <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                                    <td>{{ $item->email ?? 'N/A' }}</td>
                                    <td>${{ number_format($item->final_price  ,2 ) ?? 'N/A' }}</td>
                                    <td>{{ $item->iccid ?? 'N/A' }}</td>
                                    <td>{{ $item->getCategory->name ?? 'N/A' }}</td>
                                    <td>{{ '('.$item->getItem->capacity.')-('.$item->getItem->plan_type.')-('.$item->getItem->validaty.')' }}</td>
                                    <td>{{ '('.$item->getUser->name.')-('.$item->getUser->email.')' }}</td>
                                    <td>{{ $item->getStatusOrder->value }}</td>
                                    <td>{{ $item->getStatusPackage->value }}</td>
                                    <td><a href="{{ route('order.callBack.success' , ['order_id' =>  encryptWithKey( $item['id'] , 'B2B-B2C') ]) }}" target="_blank">Data</a></td>
                                    <td>{{ formatDate($item->created_at) ?? 'N/A'  }}</td>
                                    <td>{{ formatDate($item->updated_at) ?? 'N/A'  }}</td>
                                        <td>
                                        <div class="dropdown">
                                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Actions
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <a class="dropdown-item" href="{{ route('b2b.api_orders.show',         ['id' => $item->id]) }}">Show</a>
                                                <a class="dropdown-item" href="{{ route('b2b.api_orders.exportOrder',  ['id' => $item->id]) }}">Export</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No data available.</td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $datas->links('pagination::bootstrap-4') }}
                    </div>

                    </div>




            </div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $(".select2").on("select2:select", function (evt) {
        var element = evt.params.data.element;
        var $element = $(element);

        $element.detach();
        $(this).append($element);
        $(this).trigger("change");
    });

    $(".select2").select2({
        dir: "rtl",
        placeholder: 'Select',
        closeOnSelect: true,
        allowClear: true
    });



</script>

@endsection
