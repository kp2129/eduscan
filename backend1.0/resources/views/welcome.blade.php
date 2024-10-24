<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduScan</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    @vite('resources/css/app.css')

</head>

<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">
    <header class="bg-blue-vtdt">
        <div class="container p-4 flex-row flex items-center">
            <img src="storage/logo.png" alt="EduScan Logo" class="h-16 md:h-24" loading="lazy">
        </div>
    </header>

    <main class="flex-1 p-4">
        <section class="h-auto md:h-dvh flex flex-col md:flex-row mb-6 px-10">
            <div class="flex-1 md:mr-4 mb-4 md:mb-0">
                <img 
                    src="storage/first.webp" 
                    alt="Screenshot of the EduScan app" 
                    class="h-full" 
                    loading="lazy">
            </div>
            <div class="flex-1 md:ml-4 flex items-center">
                <div class="text-center">
                    <h2 class="text-xl md:text-3xl font-bold mb-2">VTDT EduScan</h2>
                    <p class="text-gray-700 text-lg md:text-2xl">
                        EduScan ir VTDT izstrādāta mobilā lietotne, kuras mērķis ir automatizēt skolēnu uzskaiti skolā.
                        Skolēnam noskenējot savu unikālo kvadrātkodu, skolas vadība redzēs skolā ieradušos skolēnus.
                    </p>
                </div>
            </div>
        </section>

        <section class="h-auto md:h-dvh flex flex-col md:flex-row-reverse mb-6 px-10">
            <div class="flex-1 md:ml-4">
                <img 
                    src="storage/second.webp" 
                    alt="EduScan app login" 
                    class="h-full" 
                    loading="lazy">
            </div>
            <div class="flex-1 md:ml-4 flex items-center">
                <div class="text-center">
                    <h2 class="text-xl md:text-3xl font-bold mb-2">Pieslēdzies EduScan</h2>
                    <p class="text-gray-700 text-lg md:text-2xl">
                        Pieslēdzies EduScan mobilajai lietotnei, izmantojot piešķirto skolas e-pastu.
                        Sagaidi skolas administratora konta apstiprināšanu un sāc lietot EduScan.
                    </p>
                </div>
            </div>
        </section>

        <section class="h-auto md:h-dvh flex flex-col md:flex-row px-10">
            <div class="flex-1">
                <img 
                    src="storage/third.webp" 
                    alt="EduScan app QR code scanning" 
                    class="h-full" 
                    loading="lazy">
            </div>
            <div class="flex-1 md:ml-4 flex items-center">
                <div class="text-center">
                    <h2 class="text-xl md:text-3xl font-bold mb-2">Skenē savu kvadrātkodu</h2>
                    <p class="text-gray-700 text-lg md:text-2xl">
                        Dodies uz kvadrātkoda sadaļu, pavērs ekrānu pret skolā novietoto kvadrātkoda lasītāju 
                        un sagaidi apstiprinošu paziņojumu par veiksmīgi noskenētu kvadrātkodu.
                    </p>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-blue-vtdt py-4 text-center text-white">
        <p>&copy; 2024 EduScan</p>
    </footer>
</body>

</html>
