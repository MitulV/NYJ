@extends('layouts.admin')
@section('content')
   

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.discount.create') }}">
                Create
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Discount Codes List
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Setting">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>

                            <th>
                                Code
                            </th>
                            <th>
                                Amount
                            </th>
                            <th>
                                Used
                            </th>
                            <th>
                                Status
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($discounts as $discount)
                            <tr>
                                <td></td>
                                <td>{{ $discount->code }}</td>
                                <td>{{ $discount->discount_amount }}</td>
                                <td>5</td>
                                <td>
                                    @if ($discount->valid_from_date && $discount->valid_from_time && $discount->valid_to_date && $discount->valid_to_time)
                                        @php
                                            $currentDateTime = now();
                                            $validFromDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $discount->valid_from_date . ' ' . $discount->valid_from_time);
                                            $validToDate = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $discount->valid_to_date . ' ' . $discount->valid_to_time);
                                        @endphp
                                        @if ($currentDateTime >= $validFromDate && $currentDateTime <= $validToDate)
                                            Active
                                        @else
                                            Not Active
                                        @endif
                                    @else
                                        Active
                                    @endif
                                </td>
                                
                                <td>

                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.discount.show', $discount->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                               
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.discount.edit', $discount->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                
                                    <form action="{{ route('admin.discount.destroy', $discount->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                               

                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                </table>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent
    <script>
        $(function() {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('setting_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.settings.massDestroy') }}",
                    className: 'btn-danger',
                    action: function(e, dt, node, config) {
                        var ids = $.map(dt.rows({
                            selected: true
                        }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')

                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                    headers: {
                                        'x-csrf-token': _token
                                    },
                                    method: 'POST',
                                    url: config.url,
                                    data: {
                                        ids: ids,
                                        _method: 'DELETE'
                                    }
                                })
                                .done(function() {
                                    location.reload()
                                })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [
                    [1, 'desc']
                ],
                pageLength: 100,
            });
            $('.datatable-Setting:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })


        document.querySelectorAll('select[name="select"]').forEach(function(selectElement) {
        selectElement.addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                window.location.href = selectedOption.value;
                // Reset the selected option back to the first one after a slight delay
                setTimeout(function() {
                    selectElement.selectedIndex = 0;
                }, 100);
            }
        });
    });
    </script>
@endsection
