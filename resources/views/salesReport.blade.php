@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            Sales Report of Event -
            <a href="{{ route('admin.events.show', ['event' => $event_id]) }}">
                {{ $event_title }}
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Setting">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>

                            <th>
                                Date
                            </th>
                            <th>
                                Customer
                            </th>
                            <th>
                                Reference Number
                            </th>

                            <th>
                                Payment Mode
                            </th>
                            <th>
                                No.
                                Tickets
                            </th>
                            <th>
                                Discount
                            </th>
                            <th>
                                Total Amount
                            </th>
                            <th></th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $key => $booking)
                            <tr data-entry-id="{{ $booking['id'] }}">
                                <td>

                                </td>

                                <td>{{ $booking['booking_date'] ?? '' }}</td>
                                <td>{{ $booking['user_name'] ?? '' }}</td>
                                <td>{{ $booking['payment_mode'] ?? '' }}</td>
                                <td>{{ $booking['reference_number'] ?? '' }}</td>
                                <td>{{ $booking['no_of_tickets'] ?? '' }}</td>
                                <td>{{ $booking['discount_amount'] ?? '' }}</td>
                                <td>{{ $booking['amount'] ?? '' }}</td>
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
                            }).done(function() {
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
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });
        });

        function changeAction(eventId) {

            var value = $('#select-' + eventId).val();
            if (value === 'delete') {
                $('#select-' + eventId).prop('selectedIndex', 0); // Reset the select element to "Action" option
                if (confirm('{{ trans('global.areYouSure') }}')) {
                    var form = $('<form>', {
                        method: 'POST',
                        action: '{{ route('admin.events.destroy', ':eventId') }}'.replace(':eventId', eventId)
                    });

                    var methodInput = $('<input>', {
                        type: 'hidden',
                        name: '_method',
                        value: 'DELETE'
                    });

                    var tokenInput = $('<input>', {
                        type: 'hidden',
                        name: '_token',
                        value: '{{ csrf_token() }}'
                    });

                    form.append(methodInput, tokenInput);
                    $('body').append(form);
                    form.submit();
                }
            } else if (value === 'Action') {
                return;
            } else if (value) {
                window.location.href = value;
            }
        }

        $(document).ready(function() {
            $('select').each(function() {
                $(this).prop('selectedIndex', 0); // Reset all select elements to the first option
            });
        });
    </script>
@endsection
