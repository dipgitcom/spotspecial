@extends('backend.master')

@section('content')
<div class="container py-4">
  <h2>User Notification Settings</h2>
  <div class="mb-3">
    <button id="bulk-enable" class="btn btn-success btn-sm">Enable Selected</button>
    <button id="bulk-disable" class="btn btn-danger btn-sm">Disable Selected</button>
  </div>
  <table id="notificationTable" class="table table-bordered" style="width:100%">
    <thead>
      <tr>
        <th><input type="checkbox" id="select-all"></th>
        <th>User</th>
        <th>Push Notification</th>
        <th>Sound</th>
        <th>Vibration</th>
        <th>Reactions</th>
        <th>Community Alerts</th>
        <th>Critical Safety Alerts</th>
        <th>Proximity Warnings</th>
        <th>Direct Messages</th>
        <th>Calls</th>
        <th>Subscriptions Updates</th>
        <th>System Notifications</th>
        <th>Actions</th>
      </tr>
    </thead>
  </table>
</div>
@endsection

@push('scripts')
<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"/>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#notificationTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("notification.settings.data") }}',
        columns: [
            {data: 'checkbox', orderable: false, searchable: false},
            {data: 'user_name', name: 'user.name'},
            {data: 'push_notification', name: 'push_notification'},
            {data: 'sound', name: 'sound'},
            {data: 'vibration', name: 'vibration'},
            {data: 'reactions', name: 'reactions'},
            {data: 'community_alerts', name: 'community_alerts'},
            {data: 'critical_safety_alerts', name: 'critical_safety_alerts'},
            {data: 'proximity_warnings', name: 'proximity_warnings'},
            {data: 'direct_messages', name: 'direct_messages'},
            {data: 'calls', name: 'calls'},
            {data: 'subscriptions_updates', name: 'subscriptions_updates'},
            {data: 'system_notifications', name: 'system_notifications'},
            {data: 'actions', orderable: false, searchable: false}
        ],
        rowCallback: function(row, data) {
            $(row).find('.setting-toggle').each(function() {
              var checked = $(this).data('value') == 1;
              $(this).prop('checked', checked);
            });
        }
    });

    // Select All functionality
    $('#select-all').on('click', function() {
        var rows = table.rows().nodes();
        $('input.bulk-checkbox', rows).prop('checked', this.checked);
    });

    // Individual toggle button
    $('#notificationTable').on('click', '.toggle-setting', function() {
        var button = $(this);
        var id = button.data('id');
        var field = prompt("Enter field to toggle (e.g., 'push_notification')");
        if (!field) return alert('Field name is required.');
        var currentValue = button.data('value');
        var newValue = confirm("Turn " + (currentValue ? "off" : "on") + " this setting?") ? !currentValue : currentValue;
        $.post('/admin/notification-settings/' + id + '/toggle', {
            _token: '{{ csrf_token() }}',
            field: field,
            value: newValue
        }, function(res) {
            alert('Setting updated');
            table.ajax.reload(null, false);
        });
    });

    // Bulk enable/disable buttons
    $('#bulk-enable').on('click', function() {
        bulkToggle(true);
    });
    $('#bulk-disable').on('click', function() {
        bulkToggle(false);
    });

    function bulkToggle(value) {
        var ids = [];
        $('input.bulk-checkbox:checked').each(function() {
            ids.push($(this).data('id'));
        });
        if (ids.length === 0) {
            alert('No rows selected');
            return;
        }
        var field = prompt('Enter field to toggle for selected (e.g., push_notification)');
        if (!field) return alert('Field name required');
        $.post('{{ route("notification.settings.bulkToggle") }}', {
            _token: '{{ csrf_token() }}',
            ids: ids,
            field: field,
            value: value
        }, function(res) {
            alert('Settings updated');
            table.ajax.reload(null, false);
            $('#select-all').prop('checked', false);
        });
    }
});
</script>
@endpush
