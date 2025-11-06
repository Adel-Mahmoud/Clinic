<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
	<div class="main-sidebar-header active">
		<a class="desktop-logo logo-light active" href="{{ url('/admin/dashboard') }}">
			<img src="{{ asset('storage/' . config('settings.logo')) }}" class="main-logo" alt="logo">
		</a>
		<a class="desktop-logo logo-dark active" href="{{ url('/admin/dashboard') }}">
			<img src="{{ asset('storage/' . config('settings.logo')) }}" class="main-logo dark-theme" alt="logo">
		</a>
		<a class="logo-icon mobile-logo icon-light active" href="{{ url('/admin/dashboard') }}">
			<img src="{{ asset('storage/' . config('settings.logo')) }}" class="logo-icon" alt="logo">
		</a>
		<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/admin/dashboard') }}">
			<img src="{{ asset('storage/' . config('settings.logo')) }}" class="logo-icon dark-theme" alt="logo">
		</a>
	</div>

	<div class="main-sidemenu">

		<ul class="side-menu" style="margin-top: 20px;">
			@foreach(config('menu') as $item)
				@if($item['type'] === 'link')
					<li class="slide">
						<a class="side-menu__item" href="{{ url($item['url']) }}">
							{!! $item['icon'] !!}
							<span class="mr-2 side-menu__label" style="font-size: medium;">{{ $item['label'] }}</span>
							@if(isset($item['badge']))
								<span class="badge badge-{{ $item['badge-color'] }} side-badge">{{ $item['badge'] }}</span>
							@endif
						</a>
					</li>
				@elseif($item['type'] === 'dropdown')
					<li class="slide">
						<a class="side-menu__item" data-toggle="slide" href="#">
							{!! $item['icon'] !!}
							<span class="mr-2 side-menu__label" style="font-size: medium;">{{ $item['label'] }}</span>
							<i class="angle fe fe-chevron-down"></i>
						</a>
						<ul class="slide-menu">
							@foreach($item['children'] as $child)
								<li>
									<a class="slide-item" href="{{ url($child['url']) }}" style="font-size: small;">
										{{ $child['label'] }}
									</a>
								</li>
							@endforeach
						</ul>
					</li>
				@endif
			@endforeach
		</ul>
	</div>
</aside>
<!-- main-sidebar -->
