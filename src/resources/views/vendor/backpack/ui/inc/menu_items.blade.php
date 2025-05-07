{{-- This file is used for menu items by any Backpack v6 theme --}}

@if (backpack_user()->isAdmin())
<x-backpack::menu-item title="Users" icon="la la-user" :link="backpack_url('user')" />
<x-backpack::menu-item title="Rooms" icon="la la-building" :link="backpack_url('room')" />
@endif

<x-backpack::menu-item title="Reservations" icon="la la-calendar" :link="backpack_url('reservation')" />
