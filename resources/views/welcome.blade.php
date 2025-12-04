<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
            @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased">
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            @if (Route::has('login'))
                <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                    @auth
                        <a href="{{ url('/home') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="max-w-7xl mx-auto p-6 lg:p-8">
                <div class="flex justify-center">
                    <svg viewBox="0 0 128 128" class="w-16 h-16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M64 0C28.7 0 0 28.7 0 64s28.7 64 64 64c11.2 0 21.7-2.9 30.8-8L42.4 96.6c-2.9-1.6-5.1-4.3-6.4-7.4-1.3-3.1-1.3-6.5 0-9.6 1.3-3.1 3.5-5.8 6.4-7.4 2.9-1.6 6.2-2.1 9.5-1.5 3.3.6 6.3 2.3 8.5 4.8l22.4-22.4c-4.2-3.8-9.2-6.6-14.6-8.1-5.4-1.5-11.1-1.5-16.5 0-5.4 1.5-10.4 4.3-14.6 8.1-4.2 3.8-7.4 8.3-9.3 13.3-1.9 5-2.4 10.3-1.5 15.4.9 5.1 3.1 9.9 6.4 13.7 3.3 3.8 7.5 6.6 12.1 8.1 4.6 1.5 9.5 1.5 14.1 0 4.6-1.5 8.8-4.3 12.1-8.1l22.4-22.4c2.2 2.5 5.2 4.2 8.5 4.8 3.3.6 6.6.1 9.5-1.5 2.9-1.6 5.1-4.3 6.4-7.4 1.3-3.1 1.3-6.5 0-9.6-1.3-3.1-3.5-5.8-6.4-7.4-2.9-1.6-6.2-2.1-9.5-1.5-3.3.6-6.3 2.3-8.5 4.8L52.4 19.2c4.2-3.8 9.2-6.6 14.6-8.1 5.4-1.5 11.1-1.5 16.5 0 5.4 1.5 10.4 4.3 14.6 8.1 4.2 3.8 7.4 8.3 9.3 13.3 1.9 5 2.4 10.3 1.5 15.4-.9 5.1-3.1 9.9-6.4 13.7-3.3 3.8-7.5 6.6-12.1 8.1-4.6 1.5-9.5 1.5-14.1 0-4.6-1.5-8.8-4.3-12.1-8.1l-22.4 22.4c-2.2-2.5-5.2-4.2-8.5-4.8-3.3-.6-6.6-.1-9.5 1.5-2.9 1.6-5.1 4.3-6.4 7.4-1.3 3.1-1.3 6.5 0 9.6 1.3 3.1 3.5 5.8 6.4 7.4 2.9 1.6 6.2 2.1 9.5 1.5 3.3-.6 6.3-2.3 8.5-4.8l22.4 22.4c-3.8 4.2-6.6 9.2-8.1 14.6-1.5 5.4-1.5 11.1 0 16.5 1.5 5.4 4.3 10.4 8.1 14.6 3.8 4.2 8.3 7.4 13.3 9.3 5 1.9 10.3 2.4 15.4 1.5 5.1-.9 9.9-3.1 13.7-6.4 3.8-3.3 6.6-7.5 8.1-12.1 1.5-4.6 1.5-9.5 0-14.1-1.5-4.6-4.3-8.8-8.1-12.1l22.4-22.4c2.5 2.2 4.2 5.2 4.8 8.5.6 3.3.1 6.6-1.5 9.5-1.6 2.9-4.3 5.1-7.4 6.4-3.1 1.3-6.5 1.3-9.6 0-3.1-1.3-5.8-3.5-7.4-6.4-1.6-2.9-2.1-6.2-1.5-9.5.6-3.3 2.3-6.3 4.8-8.5L93.2 56c3.8-4.2 6.6-9.2 8.1-14.6 1.5-5.4 1.5-11.1 0-16.5-1.5-5.4-4.3-10.4-8.1-14.6-3.8-4.2-8.3-7.4-13.3-9.3-5-1.9-10.3-2.4-15.4-1.5-5.1.9-9.9 3.1-13.7 6.4-3.8 3.3-6.6 7.5-8.1 12.1-1.5 4.6-1.5 9.5 0 14.1 1.5 4.6 4.3 8.8 8.1 12.1l-22.4 22.4c-2.5-2.2-5.2-4.2-8.5-4.8-3.3-.6-6.6-.1-9.5 1.5-2.9 1.6-5.1 4.3-6.4 7.4-1.3 3.1-1.3 6.5 0 9.6 1.3 3.1 3.5 5.8 6.4 7.4 2.9 1.6 6.2 2.1 9.5 1.5 3.3-.6 6.3-2.3 8.5-4.8L64 128c11.2 0 21.7-2.9 30.8-8C110.1 114.7 128 91.2 128 64 128 28.7 99.3 0 64 0z" fill="url(#gradient)"/>
                        <defs>
                            <linearGradient id="gradient" x1="0" y1="0" x2="128" y2="128" gradientUnits="userSpaceOnUse">
                                <stop stop-color="#FF2D20"/>
                                <stop offset="1" stop-color="#FF2D20" stop-opacity=".1"/>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>

                <div class="mt-16">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                        <a href="https://laravel.com/docs" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.31 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Documentation</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Laravel has wonderful documentation covering every aspect of the framework. Whether you're a beginner or have prior experience with Laravel, we recommend reading our documentation from cover to cover.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                    </svg>
                                </a>

                        <a href="https://laracasts.com" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" d="M15.75 10.5l4.72-4.72a.75.75 0 011.28.53v11.38a.75.75 0 01-1.28.53l-4.72-4.72M4.5 18.75h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25h-9A2.25 2.25 0 002.25 7.5v9a2.25 2.25 0 002.25 2.25z" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Laracasts</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Laracasts offers thousands of video tutorials on Laravel, PHP, and JavaScript development. Check them out, see for yourself, and massively level up your development skills in the process.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                                    </svg>
                                </a>

                        <a href="https://laravel-news.com" class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.8c.442.331.742.974.742 1.68v.75M12.75 3.03c-.136 0-.274.008-.412.025l-.412.025c-1.978.123-3.5 1.8-3.5 3.82v.568c0 .334.148.65.405.864l1.068.8c.442.331.742.974.742 1.68v.75m0 0v.568c0 .334-.148.65-.405.864l-1.068.8c-.442.331-.742.974-.742 1.68v.75m0 0v.75c0 .414.336.75.75.75h.75m-9 0H3a.75.75 0 01-.75-.75v-.75m0 0v-.568c0-.334.148-.65.405-.864l1.068-.8c.442-.331.742-.974.742-1.68v-.75m0 0v-.568c0-.334-.148-.65-.405-.864l-1.068-.8c-.442-.331-.742-.974-.742-1.68v-.75m0 0v-.75c0-.414.336-.75.75-.75h.75m9 0h.75a.75.75 0 01.75.75v.75" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Laravel News</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Laravel News is a community driven portal and newsletter aggregating all of the latest and most important news in the Laravel ecosystem, including new package releases and tutorials.
                                </p>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="self-center shrink-0 stroke-red-500 w-6 h-6 mx-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12h15m0 0l-6.75-6.75M19.5 12l-6.75 6.75" />
                            </svg>
                        </a>

                        <div class="scale-100 p-6 bg-white dark:bg-gray-800/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                            <div>
                                <div class="h-16 w-16 bg-red-50 dark:bg-red-800/20 flex items-center justify-center rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="w-7 h-7 stroke-red-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.115 5.19l.319 1.913A6 6 0 008.11 10.766l1.073.58a6 6 0 003.114 3.178l-.785 1.549M6.115 5.19L4.69 3.664M6.115 5.19l1.549-.785m0 0l.58-1.073a6 6 0 013.178-3.114l1.913.319m-5.709 4.549l-.785-1.549M15.19 6.115l-1.549.785m0 0l-.58 1.073a6 6 0 00-3.178 3.114l-1.913.319m5.709-4.549l1.549.785m0 0l.58-1.073a6 6 0 013.178-3.114l1.913-.319m-5.709 4.549l.785 1.549M15.19 6.115l1.549-.785m0 0l.58-1.073a6 6 0 013.178-3.114l1.913.319m-5.709 4.549l-.785-1.549" />
                                    </svg>
                                </div>

                                <h2 class="mt-6 text-xl font-semibold text-gray-900 dark:text-white">Vibrant Ecosystem</h2>

                                <p class="mt-4 text-gray-500 dark:text-gray-400 text-sm leading-relaxed">
                                    Laravel's robust library of first-party tools and libraries, such as <a href="https://forge.laravel.com" class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Forge</a>, <a href="https://vapor.laravel.com" class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Vapor</a>, <a href="https://nova.laravel.com" class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Nova</a>, and <a href="https://envoyer.io" class="underline hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Envoyer</a> help you take your projects to the next level.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-center mt-16 px-6 sm:items-center sm:justify-between">
                    <div class="text-center text-sm text-gray-500 dark:text-gray-400 sm:text-left">
                        <div class="flex items-center gap-4">
                            <a href="https://github.com/laravel/laravel" class="group inline-flex items-center hover:text-gray-700 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" class="mr-3 inline-block size-5 stroke-gray-400 dark:stroke-gray-500 group-hover:stroke-gray-600 dark:group-hover:stroke-gray-300">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                    </svg>
                                Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
                            </a>
                        </div>
                    </div>

                    <div class="ml-4 text-center text-sm text-gray-500 dark:text-gray-400 sm:text-right sm:ml-0">
                        Laravel
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>