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

    @vite('resources/css/app.css')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>

    <title>awon dashboard</title>
</head>

<body>
    <div class="w-full grid h-svh max-h-svh
    2xl:flex
    xl:flex
    lg:flex">
        <div class="hidden h-full flex-[0.3]
        2xl:contents
        xl:contents">
            <ul class="menu bg-white text-base-content m min-h-full w-80 p-4">
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

        <div class="w-full">
            <div class="bg-[#F8FAFB] h-full">
                <div class="sticky top-0 w-full">
                    <div class="navbar bg-base-100 hidden
                    2xl:block
                    xl:block">
                        <div class="navbar-start gap-x-28 flex">
                            <img src="{{ asset("assets/images/logo.svg") }}" alt="awon-logo" />
                            <!-- <div class="flex items-center mt-6 gap-x-3">
                                <img src="{{ asset("assets/icons/search.svg") }}" alt="search-icon" />
                                <input type="text" class="font-['Tajawal']" name="search" id="search" placeholder="ابحث باسم المشروع..." />
                            </div> -->
                        </div>
                    </div>
                    <nav class="navbar bg-body-tertiary block
                    2xl:hidden
                    xl:hidden">
                        <div class="container-fluid">
                            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                                <div class="offcanvas-body">
                                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                                        </li>
                                        <li class="nav-item dropdown">
                                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                Dropdown
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="#">Action</a></li>
                                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </nav>

                </div>
                <div class="pt-11">
                    @yield('content')
                    {!! $chart->script() !!}
                </div>
            </div>

        </div>
</body>

</html>