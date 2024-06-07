{{-- <li class="nav-item">
    <a href="{{ route('absence.index') }}" class="nav-link {{ Request::is('absence*') ? 'active' : '' }}">
        <i class="fa-regular fa-calendar-minus mr-2"></i>
        <p>{{ __('Layouts/Menu.absences') }}</p>
    </a>
</li> --}}


<li class="nav-item has-treeview">
    <a class="nav-link {{ Request::is('*absence*') || Request::is('*jourFerie*') ? 'active' : '' }}">
        <i class="fa-regular fa-calendar-minus mr-2"></i>
        <p>
            {{ __('Layouts/Menu.absences') }}
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('absence.index') }}" class="nav-link {{ Request::is('*absence*') ? 'active' : '' }}">
                <i class="fa-regular fa-calendar-minus mr-2"></i>
                <p>{{ __('Layouts/Menu.absences') }}</p>
            </a>
        </li>

        <!-- Role -->
        <li class="nav-item">
            <a href="{{ route('jourFerie.index') }}" class="nav-link {{ Request::is('*jourFerie*') ? 'active' : '' }}">
                {{-- <i class="far fa-user-circle nav-icon"></i> --}}
                <i class="fa-solid fa-calendar-days"></i>
                <p>Jour férié</p>
            </a>
        </li>


    </ul>
</li>


