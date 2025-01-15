@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'Manage Esim')



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

                <h1 class="mb-4">Manage E-sim</h1>
                <div class="row mb-4">
                    <form action="{{ route('b2b.manage_esims.index') }}" method="GET" class="d-flex align-items-end w-100">
                        <div class="col-3">
                            <label for="category_id" class="form-label">Category</label><br />
                            <select class="form-select" id="category_id" name="category_id" style="width: 100%">
                                <option class="text-center"  value="" selected>All</option>
                                @if(!empty($categories))
                                    @foreach($categories as $category)
                                        <option class="text-center" value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-primary mx-2">Filter</button>
                            <a href="{{ route('b2b.manage_esims.export', ['category_id' => request('category_id')]) }}" class="btn btn-success">Export Excel</a>

                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0" style="text-align: center">
                <thead>
                        <tr>
                            <th> # </th>
                            <th> Name </th>
                            <th> Capacity </th>
                            <th> Plan Type </th>
                            <th> Validity </th>
                            <th> Price </th>
                            <th> Created At </th>
                            <th> Updated At </th>
                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $index => $item)
                            <tr>
                                <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->getSubCategory->name ?? 'N/A' }}</td>
                                <td>{{ $item->capacity ?? 'N/A' }}</td>
                                <td>{{ $item->plan_type ?? 'N/A' }}</td>
                                <td>{{ $item->validaty ?? 'N/A' }}</td>
                                <td>${{ number_format($item->getItemSource->getPaymentPriceB2b->final_price, 2) }}</td>
                                <td>{{ formatDate($item->created_at) ?? 'N/A'  }}</td>
                                <td>{{ formatDate($item->updated_at) ?? 'N/A'  }}</td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('b2b.manage_esims.showEsim',    ['id' => $item->id]) }}">Show</a>
                                            <a class="dropdown-item" href="{{ route('b2b.manage_esims.export_esim', ['id' => $item->id]) }}">Export</a>
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
