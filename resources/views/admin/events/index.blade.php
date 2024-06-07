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

    <div style="margin-bottom: 10px;" class="row">
        @if (auth()->user()->isOrganizer() &&
                auth()->user()->stripeSettings()->exists() &&
                auth()->user()->stripeSettings()->first()->details_submitted)
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.events.create') }}">
                    {{ trans('global.create') }} {{ trans('cruds.events.title_singular') }}
                </a>
            </div>
        @endif
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.events.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Setting">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>

                            <th>
                                Title
                            </th>
                            <th>
                                Start Date
                            </th>

                            <th>
                                Status
                            </th>
                            <th></th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($events as $key => $event)
                            <tr data-entry-id="{{ $event->id }}">
                                <td>

                                </td>

                                <td>
                                    {{ $event->title ?? '' }}
                                </td>
                                <td>

                                    {{ \Carbon\Carbon::parse($event->start_date)->format('d/m/Y') }}
                                </td>

                                <td>
                                    {{ $event->status ?? '' }}
                                </td>
                                <td>
                                    <select style="background-color: #ECECEC; border: none;" onchange="changeAction({{$event->id}})"
                                        id="select-{{ $event->id }}" name="select" class="form-control">
                                        <option value="Action" selected>Action <i class="fa-solid fa-angle-down"></i></option>
                                        @if (auth()->user()->isOrganizer() && $event->bookings->count() === 0)
                                        <option value="{{ route('admin.events.edit', $event->id) }}">
                                            {{ trans('global.edit') }}
                                        </option>
                                        @endif
                                        
                                        <option value="{{ route('admin.events.show', $event->id) }}">
                                            {{ trans('global.view') }}
                                        </option>

                                        @if (auth()->user()->isOrganizer() && $event->bookings->count() === 0)
                                        <option value="delete">
                                            {{ trans('global.delete') }}
                                        </option>
                                        @endif
                                        
                                    </select>
                                </td>
                                <td>

                                    @if (auth()->user()->isOrganizer() && $event->status === 'Published')
                                        @php
                                            $startDateTime = $event->start_date . ' ' . $event->start_time;
                                            $now = now();
                                            $isPastEvent = $now > $startDateTime;
                                        @endphp

                                        <a class="btn btn-lg btn-block btn-{{ $isPastEvent ? 'secondary' : 'success' }}"
                                            href="{{ $isPastEvent ? '#' : route('admin.events.book', ['event_id' => $event->id]) }}"
                                            {{ $isPastEvent ? 'disabled' : '' }}>
                                            Book Now
                                        </a>
                                    @endif
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
                        var ids = $.map(dt.rows({ selected: true }).nodes(), function(entry) {
                            return $(entry).data('entry-id')
                        });

                        if (ids.length === 0) {
                            alert('{{ trans('global.datatables.zero_selected') }}')
                            return
                        }

                        if (confirm('{{ trans('global.areYouSure') }}')) {
                            $.ajax({
                                headers: { 'x-csrf-token': _token },
                                method: 'POST',
                                url: config.url,
                                data: { ids: ids, _method: 'DELETE' }
                            }).done(function() {
                                location.reload()
                            })
                        }
                    }
                }
                dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                order: [[1, 'desc']],
                pageLength: 100,
            });

            $('.datatable-Setting:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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
