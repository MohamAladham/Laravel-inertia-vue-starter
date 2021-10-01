<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{get_setting( 'admin_panel_logo', asset( 'assets/admin/custom/img/logo_placeholder.png' ) )}}" class="logo" alt="{{config('app.name')}}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
