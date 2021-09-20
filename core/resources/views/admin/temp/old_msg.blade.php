<?php
$msgs = App\msg::orderby('id', 'desc')->paginate(50); ?>
<table id="" class=" table table-stripped table-hover">
    <thead>
        <tr>
            <th>Subject</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($msgs as $msg)
            <tr>
                <td>{{ $msg->subject }}</td>
                <td>{{ $msg->created_at }}</td>
                <td>
                    <span>
                        <a id="{{ $msg->id }}" href="javascript:void(0)"
                            onclick="load_get_ajax('/admin/message/edit/{{ $msg->id }}', this.id, 'admEditMsg')">
                            <i class="fas fa-edit text-warning"></i>
                        </a>
                        <a id="{{ $msg->id }}" href="javascript:void(0)"
                            onclick="load_get_ajax('/admin/message/delete/{{ $msg->id }}', this.id, 'admDeleteMsg')">
                            <i class="fas fa-times text-danger"></i>
                        </a>
                    </span>
                    <div id="msg_cnts{{ $msg->id }}" class="cont_display_none">
                        {!! $msg->message !!}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<br><br>

<div id='del_msg_lang' class="cont_display_none">
    {{ __('messages.suc_msg') }}
</div>
