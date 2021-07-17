<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://laravel.com/img/notification-logo.png" class="logo" alt="Laravel Logo">
@else
<img src="<?php echo $_SERVER["DOCUMENT_ROOT"]; ?>'/admin/dist-assets/images/logo.png'" class="logo" alt="PCN Logo">
@endif
</a>
</td>
</tr>
