@extends('layouts.admin')
@section('content')
    @if (session('payment_success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close text-light" data-dismiss="alert" aria-hidden="true">×</button>
            <h5><i class="icon fas fa-check"></i> Payment successful!</h5>
            {{ session('success') }}
        </div>
    @endif

    @if (session('payment_fail'))
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-info"></i> Payment Failed!</h5>
            {{ session('payment_fail') }}
        </div>
    @endif


    <div class="card">
        <div class="card-header">
            My Bookings {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Amenity">
                    <thead>
                        <tr>
                            
                            <th>
                                Event Title
                            </th>
                            <th>
                                Booking Date & Time
                            </th>
                            <th>
                                Amount
                            </th>
                            
                            <th>
                                Status
                            </th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $key => $booking)
                            <tr data-entry-id="{{ $booking->id }}">

                               
                                <td>
                                    {{ $booking->event->title }}
                                </td>
                                <td>
                                    {{ $booking->booking_date_time }}
                                </td>
                                <td>
                                    {{ $booking->amount }}
                                </td>
                                
                                <td>
                                    {{ $booking->status }}
                                </td>
                                <td>
                                    <a class="btn btn-xs btn-primary"
                                        href="{{ route('admin.mybookings.show', $booking->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
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
            @can('amenity_delete')
                let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
                let deleteButton = {
                    text: deleteButtonTrans,
                    url: "{{ route('admin.cities.massDestroy') }}",
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
            $('.datatable-Amenity:not(.ajaxTable)').DataTable({
                buttons: dtButtons
            })
            $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
