<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <title>awon dashboard</title>
</head>
<body>
    <!-- start navbar -->
    <div class="navbar bg-base-100">
        <div class="navbar-start flex gap-x-28">
            <div class="dropdown block lg:hidden xl:hidden">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <svg
                    xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </div>
                <ul
                tabindex="0"
                class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li><a>Homepage</a></li>
                    <li><a>Portfolio</a></li>
                    <li><a>About</a></li>
                </ul>
            </div>
            <img src="{{ asset("assets/images/logo.svg") }}" alt="awon-logo" />
            <div class="flex items-center mt-6 gap-x-3">
                <img src="{{ asset("assets/icons/search.svg") }}" alt="search-icon" />
                <input type="text" class="font-['Tajawal']" name="search" id="search" placeholder="ابحث باسم المشروع..." />
            </div>
        </div>
    </div>
    <!-- end navbar -->

    <!-- start drawer -->
    <div class="drawer lg:drawer-open">
        <input id="my-drawer-2" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content bg-[#F8FAFB] flex flex-col items-center justify-center w-full">
            <!-- Page content here -->
            <label for="my-drawer-2" class="w-full">
                 @yield('content')
            </label>
            {!! $chart->script() !!}
        </div>
        <div class="drawer-side">
            <label for="my-drawer-2" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu bg-white shadow-2xl text-base-content m min-h-full w-80 p-4">
                <!-- Sidebar content here -->
                <li class="hover:bg-cyan-[#F8F8F8] hover:font-bold hover:text-cyan-700">
                    <div class="flex items-center gap-x-4 text-lg my-auto">
                        <x-fas-table-columns class="text-cyan-700 w-7 h-7" />
                        <a class="font-['Tajawal'] text-center mt-2" href="/">لوحة التحكم</a>
                    </div>
                </li>
                <li class="hover:bg-cyan-[#F8F8F8] hover:font-bold hover:text-cyan-700">
                    <ul class="menu menu-lg rounded-lg w-full max-w-xs">
                        <li>
                            <details>
                                <summary class="font-['Tajawal']">
                                    <x-fas-diagram-project class="text-cyan-700 w-7 h-7" />
                                    المشاريع التقنية
                                </summary>
                                <ul class="font-['Tajawal']">
                                    @foreach($dashboard as $project)
                                    <li>
                                        <a class="flex items-center gap-x-3" href="{{ route('tech', $project->id) }}">
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
            </ul>
        </div>
    </div>
    <!-- end drawer -->
</body>
</html>