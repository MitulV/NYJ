@extends('layouts.admin')
@section('content')
    @if (auth()->user()->isOrganizer() && !auth()->user()->stripeSettings()->exists())
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-info"></i> Warning!</h5>
            Please Connect with Admin Team.
        </div>
    @endif
    @if (auth()->user()->isOrganizer() &&
            auth()->user()->stripeSettings()->exists() &&
            !auth()->user()->stripeSettings()->first()->details_submitted)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-info"></i> Warning!</h5>
            Please Connect with Stripe to Access the platform.
            <a href="{{ auth()->user()->stripeSettings->onboarding_url }}">Click Here</a>
        </div>
    @endif
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.city.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatable datatable-Amenity">
                    <thead>
                        <tr>
                            <th width="10"></th>
                            <th>User Name</th>
                            <th>Amount</th>
                            <th>Event Name</th>
                            <th>Reference Number</th>
                            <th>Status</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $key => $booking)
                            <tr data-entry-id="{{ $booking->id }}">
                                <td></td>
                                <td>{{ $booking->user->name ?? '' }}</td>
                                <td>{{ $booking->amount ?? '' }}</td>
                                <td>{{ $booking->event->name ?? '' }}</td>
                                <td>{{ $booking->reference_number ?? '' }}</td>
                                <td>{{ $booking->status ?? '' }}</td>
                                <td>

                                    <a class="btn btn-xs btn-primary"
                                        href="{{ route('admin.cities.show', $booking->id) }}">{{ trans('global.view') }}</a>

                                    <a class="btn btn-xs btn-info"
                                        href="{{ route('admin.cities.edit', $booking->id) }}">{{ trans('global.edit') }}</a>


                                    <form action="{{ route('admin.cities.destroy', $booking->id) }}" method="POST"
                                        onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                        style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                            value="{{ trans('global.delete') }}">
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
