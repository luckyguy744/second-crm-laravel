<?php
    $acts = App\adminLog::orderby('id', 'desc')->paginate(50);
?>

<div class="sparkline9-list shadow-reset mg-tb-30">
    <div class="sparkline9-graph dashone-comment">
        <div class="datatable-dashv1-list custom-datatable-overright dashtwo-project-list-data">
            <div class="row">
                <div class="col-sm-12" align="">
                   <form action="/admin/send/notification" method="post">
                        <div class="form-group">
                          <input id="msg_state" type="hidden" class="form-control" value="0" name="msg_state" required>
                          <label>{{ __('messages.ttl') }}</label>
                          <input id="subject" type="text" class="form-control" name="subject" required>
                        </div>
                        <div class="form-group">
                          <label>{{ __('messages.entr_sep_comma') }}</label>
                          <textarea id="msg_users" name="msg_users" class="form-control"  rows="3" placeholder="Enter users separated by ',' or leave empty to send notification to all"></textarea>
                        </div>
                        <div class="form-group">
                           <input type="hidden" name="_token" value="{{csrf_token()}}">
                           <label>{{ __('messages.yr_msg') }}</label>
                           <textarea id="textmsg2" name="msg" class="form-control" required rows="15"></textarea>
                        </div>
                       <div class="form-group" align="center">
                          <br>
                           <button class="btn btn-info fa fa-paper-plane"> {{ __('messages.send_msg') }}</button>
                       </div>
                   </form>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
  $('#msg_state').val(0);

  const insert_template = () => {
      const html = `
      <table style="border-collapse: collapse; width: 100%;" border="0">
        <tbody>
            <tr>
                <td style="width: 9.09969%;"><img src="/img/logo.png" width="124" height="124" /></td>
                <td style="width: 88.9494%;">CompanyName<br />AddressLine1<br />AddressLine2<br />AddressLine3</td>
            </tr>
        </tbody>
    </table>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <p>&nbsp;</p>
    <table style="border-collapse: collapse; width: 100%;" border="0">
        <tbody>
            <tr>
                <td style="width: 48.9904%;">&nbsp;</td>
                <td style="width: 49.0587%;"></td>
            </tr>
        </tbody>
    </table>
    <p align="left">&nbsp;</p>
`;
    tinyMCE.activeEditor.setContent(html);
}
</script>
