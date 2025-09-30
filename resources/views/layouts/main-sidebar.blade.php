<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
	<div class="main-sidebar-header active">
		<a class="desktop-logo logo-light active" href="{{ url('/' . $page='index') }}"><img src="{{ asset('storage/' . config('settings.logo') ) ?? '' }}" class="main-logo" alt="logo"></a>
		<a class="desktop-logo logo-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
		<a class="logo-icon mobile-logo icon-light active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
		<a class="logo-icon mobile-logo icon-dark active" href="{{ url('/' . $page='index') }}"><img src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
	</div>
	<div class="main-sidemenu">
		<div class="app-sidebar__user clearfix">
			<div class="dropdown user-pro-body">
				<div class="">
					<img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/6.jpg')}}"><span class="avatar-status profile-status bg-green"></span>
				</div>
				<div class="user-info">
					<h4 class="font-weight-semibold mt-3 mb-0">{{ auth('admin')->user()->name ?? 'No Name'  }}</h4>
					<span class="mb-0 text-muted">Premium Member</span>
				</div>
			</div>
		</div>
		<ul class="side-menu">
			@foreach(config('menu') as $item)
			@if($item['type'] === 'link')
			<li class="slide">
				<a class="side-menu__item" href="{{ url($item['url']) }}">
					{!! $item['icon'] !!}
					<span class="side-menu__label" style="font-size: large;">{{ $item['label'] }}</span>
					@if(isset($item['badge']))
					<span class="badge badge-{{ $item['badge-color'] }} side-badge">{{ $item['badge'] }}</span>
					@endif
				</a>
			</li>
			@elseif($item['type'] === 'dropdown')
			<li class="slide">
				<a class="side-menu__item" data-toggle="slide" href="#">
					{!! $item['icon'] !!}
					<span class="side-menu__label" style="font-size: large;">{{ $item['label'] }}</span>
					<i class="angle fe fe-chevron-down"></i>
				</a>
				<ul class="slide-menu">
					@foreach($item['children'] as $child)
					<li><a class="slide-item" href="{{ url($child['url']) }}" style="font-size: medium;">{{ $child['label'] }}</a></li>
					@endforeach
				</ul>
			</li>
			@endif
			@endforeach
		</ul>

	</div>
</aside>
<!-- main-sidebar -->