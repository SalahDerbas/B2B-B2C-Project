@extends('layouts.master')

@section('title', 'B2B Dashboard')
@section('title_page', 'Billings')

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

                <h1 class="mb-4">Billings</h1>
                <div class="row mb-4">
                    <form action="{{ route('b2b.billing.index') }}" method="GET" class="d-flex align-items-end w-100">
                        <div class="col-3">
                            <label for="status_id" class="form-label">Status</label><br />
                            <select class="form-select" id="status_id" name="status_id" style="width: 100%">
                                <option class="text-center"  value="" selected>All</option>
                                @if(!empty($statuses))
                                    @foreach($statuses as $status)
                                        <option class="text-center" value="{{ $status->id }}" {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                            {{ $status->value }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-2">
                            <button type="submit" class="btn btn-primary mx-2">Filter</button>
                        </div>
                    </form>
                </div>

                <div class="table-responsive">
                <table id="datatable" class="table  table-hover table-sm table-bordered p-0" style="text-align: center">
                <thead>
                        <tr>
                            <th> # </th>
                            <th> Number ID </th>
                            <th> Issue Date </th>
                            <th> Due Date </th>
                            <th> Amount </th>
                            <th> User/Email </th>
                            <th> Payment </th>
                            <th> Status </th>
                            <th> Created At </th>
                            <th> Updated At </th>

                            <th> Actions </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas as $index => $item)
                            <tr>
                                <td>{{ ($datas->currentPage() - 1) * $datas->perPage() + $loop->iteration }}</td>
                                <td>{{ $item->number_id ?? 'N/A'               }}</td>
                                <td>{{ formatDate($item->issue_date) ?? 'N/A'  }}</td>
                                <td>{{ formatDate($item->due_date)  ?? 'N/A'   }}</td>
                                <td>{{ $item->amount ?? 'N/A'                  }}</td>
                                <td>{{ $item->getUser->email ?? 'N/A'          }}</td>
                                <td>
                                    <img src="{{$item->getPayment->photo}}" width="50" height="50"/>
                                </td>
                                <td>
                                    <span class="badge badge-info" style="font-size: 20px;">{{ $item->getStatus->value ?? 'N/A'        }} </span>
                                </td>
                                <td>{{ formatDate($item->created_at) ?? 'N/A'  }}</td>
                                <td>{{ formatDate($item->updated_at) ?? 'N/A'  }}</td>

                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Actions
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="{{ route('b2b.billing.show',     ['id' => $item->id]) }}">Show</a>
                                            <a class="dropdown-item" href="{{ route('b2b.billing.download', ['id' => $item->id]) }}">Download</a>
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
