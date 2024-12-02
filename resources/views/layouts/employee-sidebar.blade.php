<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    @vite('resources/css/app.css')

    <title>employee dashboard</title>
</head>

<body>
    <div class="flex">
        <div class="h-full flex-[0.3] hidden
        laptop:block">
            <div class="flex items-center gap-x-4 font-['Tajawal'] font-bold text-lg mr-6 mt-8">
                @if(!preg_match('/\.(jpg|jpeg|png|gif)$/i', basename($employee->profile_image)))
                <img src="{{ asset("assets/images/user-profile.png") }}" class="w-14 rounded-full" alt="image-profile" />
                @else
                <img src="{{ $employee->profile_image }}" class="w-14 rounded-full" alt="image-profile" />
                @endif
                <div class="grid">
                    <p>{{ $employee->name }}</p>
                    @foreach($employee->roles as $role)
                    <p class="font-normal text-sm text-gray-600">{{ $role->name }}</p>
                    @endforeach
                </div>
                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn m-1">. . .</div>
                    <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                        <li><a href="{{ route('employee.setting.show') }}" class="font-bold text-cyan-700 text-lg"><x-fas-gear class="text-cyan-700 w-7 h-7" /> الإعدادات</a></li>
                        <li>
                            <form method="POST" action="{{ route('auth.logout') }}" dir="rtl">
                                @csrf
                                <button type="submit" class="btn bg-transparent border-0 font-normal text-red-600 text-base"><x-fas-arrow-right-from-bracket class="text-red-600 w-5 h-5" />تسجيل الخروج</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
            <ul class="menu bg-white text-base-content min-h-full w-80 px-4 py-10">
                <li class="hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                    <div class="flex items-center gap-x-4 text-lg my-auto">
                        <x-fas-table-columns class="text-cyan-700 w-7 h-7" />
                        <a class="font-['Tajawal'] text-center mt-2" href="{{ route('employee.dashboard') }}">لوحة التحكم</a>
                    </div>
                </li>
                <li class="hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                    <div class="flex items-center gap-x-4 text-lg my-auto">
                        <x-fas-users class="text-cyan-700 w-7 h-7" />
                        <a class="font-['Tajawal'] text-center mt-2" href="{{ route('employee.users') }}">الحسابات</a>
                    </div>
                </li>
                <li class="hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                    <div class="flex items-center gap-x-4 text-lg my-auto font-['Tajawal']">
                        <x-fas-list class="text-cyan-700 w-7 h-7" />
                        <a class="text-right text-base mt-2">أقسام المشاريع</a>
                    </div>
                </li>
                <li class="hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                    <div class="flex items-center gap-x-4 text-lg my-auto">
                        <x-fas-hand-holding-dollar class="text-cyan-700 w-7 h-7" />
                        <a class="font-['Tajawal'] text-right mt-2">التحصيل</a>
                    </div>
                </li>
                <li class="hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                    <ul class="menu menu-lg rounded-lg w-full max-w-xs">
                        <li>
                            <details>
                                <summary class="font-['Tajawal']">
                                    <x-fas-diagram-project class="text-cyan-700 w-7 h-7" />
                                    مشاريع التقنية
                                </summary>
                                <ul class="font-['Tajawal']">
                                    @foreach($projects as $project)
                                    <li>
                                        <a class="flex items-center gap-x-3" href="{{ route('employee.show.project', $project->id) }}">
                                            <x-far-folder class="text-gray-500 w-6 h-6" />
                                            <p class="text-black font-normal mt-2">{{ $project->p_name }}</p>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </details>
                        </li>
                    </ul>
                </li>
                <li class="hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                    <ul class="menu menu-lg rounded-lg w-full max-w-xs">
                        <li>
                            <details>
                                <summary class="font-['Tajawal']">
                                    مشاريع تنمية الموارد
                                </summary>
                            </details>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

        <div class="w-full">
            <div class="bg-[#F8FAFB] h-full">
                <div class="top-0 w-full">
                    <div class="navbar bg-base-100 hidden
                    laptop:block">
                        <div class="navbar-start justify-around w-full">
                            <img src="{{ asset("assets/images/logo.svg") }}" alt="awon-logo" />
                            {{-- <div class="flex items-center mt-6 gap-x-3">
                                <img src="{{ asset("assets/icons/search.svg") }}" alt="search-icon" />
                            <input type="text" class="font-['Tajawal'] input input-lg" name="search" id="search" placeholder="ابحث باسم المشروع..." />
                        </div> --}}
                        {{-- <div class="bg-gray-50 p-3 rounded-2xl">
                                <x-far-bell class="w-6 h-7 text-gray-600" />
                            </div> --}}
                    </div>
                </div>
                <nav class="navbar bg-body-tertiary block
                laptop:hidden">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                            <div class="offcanvas-header">
                                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="flex items-center gap-x-4 font-['Tajawal'] font-bold text-base my-8">
                                    @if(!preg_match('/\.(jpg|jpeg|png|gif)$/i', basename($employee->profile_image)))
                                    <img src="{{ asset("assets/images/user-profile.png") }}" class="w-14 rounded-full" alt="image-profile" />
                                    @else
                                    <img src="{{ $employee->profile_image }}" class="w-14 rounded-full" alt="image-profile" />
                                    @endif
                                    <div class="grid">
                                        <p>{{ $employee->name }}</p>
                                        @foreach($employee->roles as $role)
                                        <p class="font-normal text-sm text-gray-600">{{ $role->name }}</p>
                                        @endforeach
                                    </div>
                                    <div class="dropdown">
                                        <div tabindex="0" role="button" class="btn m-1">. . .</div>
                                        <ul tabindex="0" class="dropdown-content menu bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                                            <li><a href="{{ route('employee.setting.show') }}" class="fobt-bold text-lg"><x-fas-gear class="text-cyan-700 w-7 h-7" /> الإعدادات</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('auth.logout') }}" dir="rtl">
                                                    @csrf
                                                    <button type="submit" class="btn bg-transparent border-0 font-normal text-red-600 text-base"><x-fas-arrow-right-from-bracket class="text-red-600 w-5 h-5" />تسجيل الخروج</button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3 my-16">
                                    <li class="nav-item
                                    hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                                        <div class="flex items-center gap-x-4 text-lg my-auto">
                                            <x-fas-table-columns class="text-cyan-700 w-7 h-7" />
                                            <a class="font-['Tajawal'] text-center mt-2" href="{{ route('employee.dashboard') }}">لوحة التحكم</a>
                                        </div>
                                    </li>
                                    <li class="nav-item
                                    hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                                        <div class="flex items-center gap-x-4 text-lg my-auto">
                                            <x-fas-users class="text-cyan-700 w-7 h-7" />
                                            <a class="font-['Tajawal'] text-center mt-2" href="{{ route('employee.users') }}">الحسابات</a>
                                        </div>
                                    </li>
                                    <li class="nav-item
                                    hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                                        <div class="flex items-center gap-x-4 text-lg my-auto font-['Tajawal']">
                                            <x-fas-list class="text-cyan-700 w-7 h-7" />
                                            <a class="text-right text-base mt-2">أقسام المشاريع</a>
                                        </div>
                                    </li>
                                    <li class="nav-item
                                    hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                                        <div class="flex items-center gap-x-4 text-lg my-auto">
                                            <x-fas-users class="text-cyan-700 w-7 h-7" />
                                            <a class="font-['Tajawal'] text-center mt-2">التحصيل</a>
                                        </div>
                                    </li>
                                    <li class="nav-item
                                    hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                                        <ul class="menu menu-lg rounded-lg w-full max-w-xs">
                                            <li>
                                                <details>
                                                    <summary class="font-['Tajawal']">
                                                        <x-fas-diagram-project class="text-cyan-700 w-7 h-7" />
                                                        مشاريع التقنية
                                                    </summary>
                                                    <ul class="font-['Tajawal']">
                                                        @foreach($projects as $project)
                                                        <li>
                                                            <a class="flex items-center gap-x-3" href="{{ route('employee.show.project', $project->id) }}">
                                                                <x-far-folder class="text-gray-500 w-6 h-6" />
                                                                <p class="text-black font-normal mt-2">{{ $project->p_name }}</p>
                                                            </a>
                                                        </li>
                                                        @endforeach
                                                    </ul>
                                                </details>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="nav-item
                                    hover:bg-cyan-[#F8F8F8] hover:text-cyan-700 my-2">
                                        <ul class="menu menu-lg rounded-lg w-full max-w-xs">
                                            <li>
                                                <details>
                                                    <summary class="font-['Tajawal']">
                                                        مشاريع تنمية الموارد
                                                    </summary>
                                                </details>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>

            </div>
            <div class="pt-11 pb-52">
                @yield('employee-content')
                {!! $chart->script() !!}
                {!! $viewGrossAnnualIncome->script() !!}
                {!! $viewCurrentGrossIncome->script() !!}
            </div>
        </div>

    </div>
</body>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@yield('scripts')
@stack('scripts')

</html>