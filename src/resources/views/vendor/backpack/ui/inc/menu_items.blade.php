{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

@if (backpack_user()->isAdmin())
<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
@endif

<x-backpack::menu-item title="Rooms" icon="la la-question" :link="backpack_url('room')" />
