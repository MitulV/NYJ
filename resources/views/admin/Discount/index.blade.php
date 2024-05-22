@extends('layouts.admin')
@section('content')
   

    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.automatic-discount.create') }}">
                Create New Discount Rule
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            Discount Rules List
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Setting">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>

                            <th>
                                Description
                            </th>
                            <th>
                                Linked To
                            </th>
                            <th>
                                Action
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
