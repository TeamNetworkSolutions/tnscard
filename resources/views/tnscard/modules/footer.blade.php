<div class="container">
	<div class="footer fadein" style="margin:5% 0px 35px 0px;">
	@if(env('DISPLAY_FOOTER') === true)
		@if(env('DISPLAY_FOOTER_HOME') === true)<a class="footer-hover spacing" href="@if(str_replace('"', "", EnvEditor::getKey('HOME_FOOTER_LINK')) === "" ){{ url('') }}@else{{ str_replace('"', "", EnvEditor::getKey('HOME_FOOTER_LINK')) }}@endif">{{footer('Home')}}</a>@endif
		@if(env('DISPLAY_FOOTER_TERMS') === true)<a class="footer-hover spacing" href="{{ url('') }}/pages/{{ strtolower(footer('Terms')) }}">{{footer('Terms')}}</a>@endif
		@if(env('DISPLAY_FOOTER_PRIVACY') === true)<a class="footer-hover spacing" href="{{ url('') }}/pages/{{ strtolower(footer('Privacy')) }}">{{footer('Privacy')}}</a>@endif
		@if(env('DISPLAY_FOOTER_CONTACT') === true)<a class="footer-hover spacing" href="{{ url('') }}/pages/{{ strtolower(footer('Contact')) }}">{{footer('Contact')}}</a>@endif
	@endif
	</div>

	@if(env('DISPLAY_CREDIT') === true)
	{{-- Logo and credit line both lead to tnscard.com, whose footer carries the
	     AGPL-3.0 source offer for anyone viewing a card. --}}
	<a href="{{ env('CREDIT_URL', 'https://tnscard.com') }}" target="_blank" rel="noopener" title="TNS Card" style="text-decoration:none;display:block;">
		<div style="display:inline-block;padding-bottom:8px;" class="credit-hover hvr-grow fadein">
			<img src="{{ asset('assets/tnscard/images/tns-mark.png') }}" alt="TNS Card" style="width:44px;height:auto;">
		</div>
		<div class="credit-txt-clr fadein" style="padding-bottom:40px;font-size:11px;opacity:.55;">Powered by Team Network Solutions</div>
	</a>
	@endif
	</div>