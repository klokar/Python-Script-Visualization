<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Poročilo') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/sass.css') }}">
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen text-center max-w-screen-sm mx-auto">
        <div class="w-full text-gray-800 text-4xl px-5 py-6 font-bold leading-none">
            {{ $title }}
        </div>
        <main>
            <pre class="px-5 mt-6 mb-8 w-full mx-auto text-left whitespace-pre-wrap">
                {{ $description }}
            </pre>

            <div class="mt-12">
                <div class="px-6 py-4 rounded-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6 mx-auto">Program</div>
                <table class="container table-fixed mb-4 text-left">
                    <tr class="border-t">
                        <td class="py-2 w-1/2">Ime programa</td>
                        <td class="py-2 w-1/2">{{ $program->name }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2">Direktorij programa</td>
                        <td class="py-2">{{ $program->e_path }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2">Mapa slik</td>
                        <td class="py-2">{{ $program->e_path_result_figures }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2">Mapa rezultatov</td>
                        <td class="py-2">{{ $program->e_path_result_data }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2">Število nivojev za model SVM</td>
                        <td class="py-2">{{ $program->level }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2">Komentar</td>
                        <td class="py-2">{{ $program->comment }}</td>
                    </tr>
                </table>
            </div>

            <div class="mt-12">
                <div class="px-6 py-4 rounded-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6 mx-auto">Podatki</div>
                <table class="container table-fixed mb-4 text-left">
                    <tr class="border-t">
                        <td class="py-2 w-1/2">Naslov podatkov</td>
                        <td class="py-2 w-1/2">{{ $dataset->name }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2">Komentar</td>
                        <td class="py-2">{{ $dataset->comment }}</td>
                    </tr>
                </table>
            </div>

            <div class="mt-12">
                <div class="px-6 py-4 rounded-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6 mx-auto">Izvajanje</div>
                <table class="container table-fixed mb-4 text-left">
                    <tr class="border-t">
                        <td class="py-2 w-1/2">Velikost testne množice v %</td>
                        <td class="py-2 w-1/2">{{ $execution->test_set_size }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2">Parametri, ločeni z vejico</td>
                        <td class="py-2">{{ $execution->parameters }}</td>
                    </tr>
                    <tr class="border-t">
                        <td class="py-2">Komentar</td>
                        <td class="py-2">{{ $execution->comment }}</td>
                    </tr>
                </table>
            </div>

            <div class="mt-12">
                <div class="px-6 py-4 rounded-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6 mx-auto">Parametri izvajanja</div>
                <table class="container table-fixed mb-4 text-left">
                    @foreach ($p_details as $key => $value)
                        <tr class="border-t">
                            <td class="py-2 w-1/2">{{ $key }}</td>
                            <td class="py-2 w-1/2">{{ is_array($value) ? implode(', ', $value) : $value }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="mt-12">
                <div class="px-6 py-4 rounded-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6 mx-auto">Podatki o evalvaciji</div>
                <table class="container table-fixed mb-4 text-left">
                    @foreach ($e_details as $key => $value)
                        <tr class="border-t">
                            <td class="py-2 w-1/2">{{ $key }}</td>
                            <td class="py-2 w-1/2">{{ is_array($value) ? implode(', ', $value) : $value }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="mt-8">
                <div class="px-6 py-4 rounded-md text-xs text-gray uppercase bg-gray-200 tracking-widest w-max mb-6 mx-auto">Slikovni rezultati</div>
                @foreach($images as $path => $title)
                    <div class="mx-5 mb-5 flex flex-col items-center">
                        <img class="max-w-screen-sm mb-2" title="{{ $title }}" src="/{{ $path }}">
                        <div class="max-w-screen-sm text-gray-600 text-normal mx-5">
                            <p class="border-b py-3">{{ $title }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>
