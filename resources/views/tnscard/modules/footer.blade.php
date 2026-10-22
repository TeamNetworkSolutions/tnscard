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
	{{-- Removed class spacing --}}
	<a href="https://teamnetworksolutions.com" target="_blank" rel="noopener" title="Team Network Solutions" style="text-decoration:none;">
		<div style="display:inline-block;padding-bottom:12px;" class="credit-hover hvr-grow fadein">
			<img src="{{ asset('assets/tnscard/images/tns-mark.png') }}" alt="Team Network Solutions" style="width:44px;height:auto;">
		</div>
	</a>
	@endif
	<div style="padding-bottom:40px;font-size:11px;opacity:.55;" class="fadein">
		<a class="credit-txt-clr" style="text-decoration:none;" href="{{ env('SOURCE_CODE_URL', 'https://github.com/TeamNetworkSolutions/tnscard') }}" target="_blank" rel="noopener">Source code (AGPL-3.0)</a>
	</div>
	</div>