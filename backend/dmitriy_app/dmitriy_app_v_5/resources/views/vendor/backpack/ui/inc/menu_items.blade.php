{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Тарифы" icon="la la-question" :link="backpack_url('rate')" />
<x-backpack::menu-item title="Курсы" icon="la la-question" :link="backpack_url('course')" />
<x-backpack::menu-item title="Клиенты" icon="la la-question" :link="backpack_url('client')" />
<x-backpack::menu-item title="Криптограммы" icon="la la-question" :link="backpack_url('cryptogram')" />
<x-backpack::menu-item title="Коллаборации" icon="la la-question" :link="backpack_url('collaboration')" />
<x-backpack::menu-item title="Заказы" icon="la la-question" :link="backpack_url('order')" />
