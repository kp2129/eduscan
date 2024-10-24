<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" type="image/x-icon" href="/storage/favicon.ico">
    <meta name="google-site-verification" content="1riamkU7k1xF_39eMbVfdSCDn67fOEOMzb22oWNHiBg" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-status-bar-style" content="default">
    <meta name="description"
        content=" EduScan ir VTDT izstrādāta mobilā lietotne, kuras mērķis ir automatizēt skolēnu uzskaiti skolā. Skolēnam noskenējot savu unikālo kvadrātkodu, skolas vadība redzēs skolā ieradušos skolēnus.">
    <meta name="author" content="KP2129">
    <meta name="developer" content="KP2129">


    <title>EduScan</title>

    <link rel="preload" href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" as="style">
    <link rel="preconnect" href="https://fonts.bunny.net" crossorigin>
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap">

    @vite('resources/css/app.css')
</head>

<body class="flex flex-col min-h-screen bg-gray-100 text-gray-800">
    <header class="bg-blue-vtdt">
        <div class="container p-4 flex-row flex items-center">
            <a href="https://vtdt.lv">
                <img src="storage/logo.png" alt="EduScan Logo" class="h-16 md:h-24" loading="lazy" decoding="async">
            </a>
        </div>
    </header>

    <main class="flex-1 p-4">
        <section class="h-auto md:h-dvh flex flex-col md:flex-row mb-12 md:mb-40 px-10">
            <div class="flex-1 flex items-center justify-center">
                <img src="storage/first.webp" alt="Screenshot of the EduScan app" class="h-fit" loading="lazy"
                    decoding="async" width="600" height="400"
                    srcset="storage/first.webp 1x, storage/first@2x.webp 2x">
            </div>
            <div class="flex-1 md:ml-4 flex items-center">
                <div class="text-center md:text-left">
                    <h2 class="text-xl md:text-3xl font-bold mb-2">VTDT EduScan</h2>
                    <p class="text-gray-700 text-lg md:text-2xl">
                        EduScan ir VTDT izstrādāta mobilā lietotne, kuras mērķis ir automatizēt skolēnu uzskaiti skolā.
                        Skolēnam noskenējot savu unikālo kvadrātkodu, skolas vadība redzēs skolā ieradušos skolēnus.
                    </p>
                    <div class="flex py-3 sm:gap-x-5 gap-x-1 justify-center sm:justify-start">
                        <a href="/" tabIndex="0"><img class=" sm:h-10 h-8"
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/78/Google_Play_Store_badge_EN.svg/2560px-Google_Play_Store_badge_EN.svg.png"
                                alt="bn45" /></a>
                        <a href="/" tabIndex="0"><img class=" sm:h-10 h-8"
                                src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"alt="bn45" /></a>
                    </div>
                </div>
            </div>
        </section>

        <section class="h-auto md:h-dvh flex flex-col md:flex-row-reverse mb-12 md:mb-40 px-10">
            <div class="flex-1 flex items-center justify-center">
                <img src="storage/second.webp" alt="EduScan app login" class="h-fit" loading="lazy" decoding="async"
                    width="600" height="400" srcset="storage/second.webp 1x, storage/second@2x.webp 2x">
            </div>
            <div class="flex-1 md:ml-4 flex items-center">
                <div class="text-center md:text-left">
                    <h2 class="text-xl md:text-3xl font-bold mb-2">Pieslēdzies EduScan</h2>
                    <p class="text-gray-700 text-lg md:text-2xl">
                        Pieslēdzies EduScan mobilajai lietotnei, izmantojot piešķirto skolas e-pastu.
                        Sagaidi skolas administratora konta apstiprināšanu un sāc lietot EduScan.
                    </p>
                </div>
            </div>
        </section>

        <section class="h-auto md:h-dvh flex flex-col md:flex-row px-10 mb-12 md:mb-40 px-10">
            <div class="flex-1 flex items-center justify-center">
                <img src="storage/third.webp" alt="EduScan app QR code scanning" class="h-fit" loading="lazy"
                    decoding="async" width="600" height="400"
                    srcset="storage/third.webp 1x, storage/third@2x.webp 2x">
            </div>
            <div class="flex-1 md:ml-4 flex items-center">
                <div class="text-center md:text-left">
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
